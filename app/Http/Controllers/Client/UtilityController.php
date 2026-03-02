<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking\MeterReading; // Assuming this model exists
use Illuminate\Support\Facades\Auth;

class UtilityController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $readings = MeterReading::whereHas('meter', function($query) use ($user) {
            $query->where('rooms_id', $user->room_id)->orderBy('created_at', 'desc');
        })->latest()->paginate(9);

        return view('clients.utilities.index', compact('user', 'readings'));
    }

    public function downloadUtilityReport()
    {
        $user = Auth::guard('web')->user();
        $room = $user->room;

        

        // dd($readings);
        // Fetch historical data for this user's room
        $readings = MeterReading::whereHas('meter', function($query) use ($user) {
            $query->where('rooms_id', $user->room_id)->orderBy('created_at', 'desc');
        })->latest()->get();

        // dd($readings);
        
        

        $data = [
            'title' => 'Monthly Utility Consumption Report',
            'date' => date('d M Y'),
            'user' => $user,
            'readings' => $readings,
            'color' => '#ad68e4' // Your signature purple
        ];

        // Load the view and download the PDF
        $pdf = Pdf::loadView('pdf.client.utility_report', $data);
        return $pdf->download('utility-report-' . now()->format('M-Y') . '.pdf');
    }
}
