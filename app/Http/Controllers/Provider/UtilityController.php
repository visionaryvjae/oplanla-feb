<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking\Meter;
use App\Models\Booking\MeterReading;
use App\Services\UtilityBillingService;
use Illuminate\Http\Request;
use League\Csv\Reader;

class UtilityController extends Controller
{
    protected $billingService;

    public function __construct(UtilityBillingService $billingService)
    {
        $this->billingService = $billingService;
    }

    public function showImport()
    {

        return view('providers.utilities.import');
    }

    /**
     * Step 1: Analyze the CSV and show a preview
     */
    public function analyze(Request $request)
    {
        $file = $request->file('motla_file');
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0);

        $results = [];
        $localBaselines = []; // Tracks readings within the CSV itself

        foreach ($csv as $record) {
            $meter = Meter::where('serial_number', $record['Meter_ID'])->first();
            
            if ($meter) {
                // Priority: 1. Previous row in this CSV, 2. Last reading in DB, 3. Null
                $prevValue = $localBaselines[$meter->id] ?? ($meter->lastReading()->reading_value ?? null);
                $currentValue = (float)$record['Reading_kWh'];

                // Consumption is 0 if this is the very first reading the system has ever seen
                $consumption = ($prevValue !== null) ? ($currentValue - $prevValue) : 0; 
                
                $results[] = [
                    'meter_id' => $meter->id,
                    'room_number' => $meter->room->room_number,
                    'serial' => $meter->serial_number,
                    'consumption' => round($consumption, 2),
                    'cost' => $this->billingService->calculateCost($consumption, $meter->type),
                    'current_reading' => $currentValue
                ];

                // Update tracker so the NEXT row for this meter uses THIS as the baseline
                $localBaselines[$meter->id] = $currentValue;
            }
        }

        // Pass data to a NEW preview blade
        return view('providers.utilities.preview', compact('results'));
    }

    /**
     * Step 2: Bulk Dispatch (Store readings and create charges)
     */
    public function bulkDispatch(Request $request)
    {
        $data = json_decode($request->input('readings_data'), true);

        foreach ($data as $item) {
            // 1. Record the official reading
            MeterReading::create([
                'meter_id' => $item['meter_id'],
                'reading_value' => $item['current_reading'],
                'consumption' => $item['consumption'],
                'reading_date' => now(),
                'source' => 'Motla_Import'
            ]);

            // 2. Add as a charge to the tenant's next invoice
            $meter = Meter::find($item['meter_id']);
            $meter->room->charges()->create([
                'description' => "Utility Usage: {$item['consumption']} units",
                'amount' => $item['cost'],
                'due_date' => now()->addDays(7),
                'type' => 'utility'
            ]);
        }

        return redirect()->route('provider.rooms.index')->with('success', 'Invoices dispatched successfully!');
    }
}
