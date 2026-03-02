<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Meter;
use Illuminate\Support\Facades\Auth;

class MeterController extends Controller
{
    public function index(Request $request)
    {
        $query = Meter::query();

        $query->where('providers_id', Auth::guard('provider')->user()->provider->id)->get();

        if($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where('serial_number', 'like', $search)
            ->orWhereHas('room', function($q) use($search) {
                $q->where('room_number', 'like', $search);
            });
        }

        if($request->filled('type')){
            $query->where('type', $request->type);
        }

        if($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }


        $pagetitle = 'Manage Meters';
        $meters = $query->latest()->paginate(10);
        return view('providers.meters.index', compact('meters', 'pagetitle'));
    }

    public function show(int $id)
    {
        $pagetitle = 'Meter Details';
        $meter = Meter::findOrFail($id);
        return view('providers.meters.show', compact('meter', 'pagetitle'));
    }

    public function create()
    {
        $meter = new Meter();
        $provider = Auth::guard('provider')->user()->provider;
        $rooms = $provider->rooms()->get();
        return view('providers.meters.form', ['actionUrl' => route('provider.meters.store'), 'action' => 'Create', 'method' => 'POST', 'meter' => $meter, 'rooms' => $rooms]);
    }

    public function store(Request $request)
    {
        $validationData = $request->validate([
            'serial_number' => 'required|string|max:255',
            'meter_type' => 'required|string|max:255',
            'multiplier' => 'required|numeric|min:0',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $validationData['providers_id'] = Auth::guard('provider')->user()->provider->id;

        $meter = Meter::create($validationData);

        $meter->save();
        return redirect()->route('provider.meters.index')->with('success', 'Meter created successfully.');
    }

    public function edit(int $id)
    {
        $meter = Meter::findOrFail($id);
        $provider = Auth::guard('provider')->user()->provider;
        $rooms = $provider->rooms()->get();

        return view('providers.meters.form', ['actionUrl' => route('provider.meters.update', $meter->id), 'action' => 'Update', 'method' => 'PUT', 'meter' => $meter, 'rooms' => $rooms
        ]);
    }

    public function update(Request $request, int $id)
    {
        $meter = Meter::findOrFail($id);

        $validationData = $request->validate([
            'serial_number' => 'string|max:255',
            'meter_type' => 'string|max:255',
            'multiplier' => 'numeric|min:0',
            'room_id' => 'exists:rooms,id',
        ]);

        $meter->update([
            'serial_number' => $validationData['serial_number'] ?? $meter->serial_number,
            'meter_type' => $validationData['meter_type'] ?? $meter->meter_type,
            'multiplier' => $validationData['multiplier'] ?? $meter->multiplier,
            'room_id' => $validationData['room_id'] ?? $meter->room_id,
        ]);

        return redirect()->route('provider.meters.index')->with('success', 'Meter updated successfully.');
    }

    public function destroy(int $id)
    {
        $meter = Meter::findOrFail($id);
        $meter->delete();
        return redirect()->route('provider.meters.index')->with('success', 'Meter deleted successfully.');
    }
}
