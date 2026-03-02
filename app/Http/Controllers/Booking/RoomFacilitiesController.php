<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\RoomFacilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomFacilitiesController extends Controller
{
    public function index(){

    }

    public function create(int $id){
        $facilitiy = new RoomFacilities();
        $rooms = DB::select('SELECT rooms.id, provider_name from rooms LEFT JOIN providers ON providers.id = rooms.providers_id WHERE rooms.id = ? ', [$id]);
        return view('Booking/booking_form', ['facility' => $facilitiy, 'rooms' => $rooms, 'table' => 'Room Facilities', 'action' => 'Create', 'actionUrl' => route('facility.store', $id)]);
    }

    public function store(Request $request, int $id){
        $validationData = $request->validate([
            'Flat Screen TV' => 'boolean', 
            'Private Bathroom' => 'boolean',
            'Terrace' => 'boolean',
            'Hot Tub' => 'boolean',
            'View' => 'boolean',
            'Balcony' => 'boolean',
            'Washing Machine' => 'boolean',
            'Air Conditioning' => 'boolean',
            'Private Pool' => 'boolean',
            'fireplace' => 'boolean',
            'pool cover' => 'boolean',
            'mountain view' => 'boolean',
            'infinity pool' => 'boolean',
            'Sauna' => 'boolean',
            'Salt Water Pool' => 'boolean',
            'Computer' => 'boolean',
            'Gam Console' => 'boolean',
            'Yukata' => 'boolean',
            'Lake View' => 'boolean',
            'Complimentary evening snacks' => 'boolean',
            'Reading Light' => 'boolean',
            'Sea View' => 'boolean',
            'rooms_id'  => 'integer',
        ]);

        RoomFacilities::create($validationData);
        return redirect()->route('rooms.index')->with('success', 'facilities added successfully');
    }
}
