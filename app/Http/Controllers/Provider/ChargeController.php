<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking\Charge;
use App\Models\Booking\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{
    public function index(Request $request)
    {
        $query = Charge::query();

        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->where('description', 'like', $search)
                ->orWhereHas('room', function($q) use ($search) {
                    $q->where('room_number', 'like', $search);
                });
        }

        if($request->filled('type')){
            $query->where('type', $request->type);
        }

        if($request->filled('is_paid')) {
            $query->where('is_paid', $request->is_paid);
        }

        if($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('due_date', [$request->start_date, $request->end_date]);
        }

        $charges = $query->with('room')->latest()->paginate(10);
        return view('providers.charges.index', compact('charges'));
    }

    public function create()
    {
        $pid = Auth::guard('provider')->user()->provider->id;
        $charge = new Charge();
        $rooms = Room::where('providers_id', $pid)->get();
        return view('providers.charges.form', ['charge' => $charge, 'rooms' => $rooms, 'actionUrl' => route('provider.charges.store'), 'action' => 'Create']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rooms_id'     => 'required|exists:rooms,id',
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'type'        => 'required|in:utility,rent,penalty,other',
            'due_date'    => 'required|date',
        ]);

        Charge::create($validated);

        return redirect()->route('provider.charges.index')
            ->with('success', 'Charge created manually successfully.');
    }

    public function edit(Charge $charge)
    { 
        $pid = Auth::guard('provider')->user()->provider->id;
        $rooms = Room::where('providers_id', $pid)->get();
        return view('providers.charges.form', ['charge' => $charge, 'rooms' => $rooms, 'actionUrl' => route('provider.charges.update', $charge), 'action' => 'Update']);
    }

    public function update(Request $request, Charge $charge)
    {
        $validated = $request->validate([
            'rooms_id'     => 'required|exists:rooms,id',
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'type'        => 'required|in:utility,rent,penalty,other',
            'due_date'    => 'required|date',
            'is_paid'     => 'boolean'
        ]);

        $charge->update($validated);

        return redirect()->route('provider.charges.index')
            ->with('success', 'Charge updated successfully.');
    }

    public function destroy(Charge $charge)
    {
        $charge->delete();
        return back()->with('success', 'Charge deleted successfully.');
    }
}
