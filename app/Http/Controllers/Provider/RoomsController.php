<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking\Room;
use App\Models\Booking\RoomFacilities;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
    public function index(Request $request) {
        $pid = Auth::guard('provider')->user()->provider->id;
        
        $query = Room::query();
        
        $query->where('providers_id', $pid);
        
        if($request->filled('search')){
            $query->where('room_number', $request->search);
        }

        if($request->filled('rental')){
            $query->where('rental', $request->rental);
        }
        
        // Property Type Filter
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Number of beds Filter
        if ($request->filled('num_beds')) {
            $query->where('num_beds', $request->num_beds);
        }
        
        //Availability filter
        if($request->filled('available')){
            // dd($request->available);
            if($request->available == 'available'){
                $query->where('available', 1);
            }
            else{
                $query->where('available', 0);
            }
        }
        
        $rooms = $query->latest()->paginate(10);
        return view('providers.rooms.rooms', ['rooms' => $rooms, 'pagetitle' => 'List of Rooms', ]);
    }

    public function viewSingleProvider(int $id) {
        $room = Room::findOrFail($id);
        // dd($room);
        return view('providers.rooms.room', ['room' => $room]);
    }

    public function createSingle(int $id){
        $room = new Room();
        $providers = DB::select('SELECT id, provider_name from providers');
        return view('providers.form.booking_form', ['room' => $room, 'table' => 'Room', 'providerId' => $id, 'providers' => $providers, 'action' => 'CreateProvider', 'actionUrl' => route('provider.rooms.store')]);
    }

    public function store(Request $request){
        $validationData = $request-> validate([
            'available' => 'boolean',
            'price' => 'required|numeric',
            'num_people' => 'integer',
            'room_type' => 'string',
            'room_facilities' => 'string|nullable',
            'provider_facilities' => 'string|nullable',
            'property_type' => 'string|max:20',
            'room_number' => 'integer',
            'rental' => 'boolean',
            'num_beds' => 'integer',
            'num_bathrooms' => 'integer',
            'rental_price' => 'nullable|numeric',
            'furnishing' => 'in:furnished,unfurnished,partially furnished',
            'providers_id' => 'required|integer',
            
        ]);
        
        $isRental = $request->has('rental') ? true : false;
        
        $validationData['rental'] = $isRental;

        $room = Room::create($validationData);
        return redirect()->route('provider.rooms.index')->with('success','successfully entered room');
    }

    public function edit(int $id) {
        $room = Room::findOrFail($id);
        $provider = DB::select('SELECT id, provider_name from providers');
        return view('providers.form.booking_form', ['room' => $room, 'table' => 'Room', 'providers' => $provider, 'action' => 'Update', 'actionUrl' => route('provider.rooms.update', $id)]);
    }

    public function update(int $id, Request $request){
        $room = Room::findOrFail($id);
        $room->price = $request->input('price');
        $room->num_people = $request->input('num_people');
        $room->room_number = $request->input('room_number');
        $room->room_facilities = $request->input('room_facilities');
        $room->property_type = $request->input('property_type');
        $room->available = $request->input('available');
        $room->room_type = $request->input('room_type');

        $room->save();
        return redirect()->route('provider.rooms.index')->with('success', 'successfully edited room details');
    }

    public function delete(int $id){
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('provider.rooms.index')->with('success', 'room deleted successfully');
    }
}
