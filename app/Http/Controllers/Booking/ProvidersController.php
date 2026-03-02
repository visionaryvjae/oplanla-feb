<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\Providers;
use App\Models\Booking\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvidersController extends Controller
{
    public function index(Request $request) {
        
        $query = Providers::query();
        
        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->where('provider_name', 'like', $search)
            ->orWhere('description', 'like', $search);
        }
        
        $providers = $query->latest()->paginate(9);
        return view('admin.providers.providers', ['providers' => $providers, 'pagetitle' => 'List of Providers']);
    }

    public function roomSearch(Request $request) {
        //$rooms = DB::select('SELECT rooms.id, provider_name, price, available, booking_address, GROUP_CONCAT(photos.image SEPARATOR ',') AS images FROM rooms LEFT JOIN providers ON rooms.providers_id = providers.id LEFT JOIN photos ON providers.id = photos.providers_id GROUP BY rooms.id, provider_name, price, available, booking_address');
        $checkInDate = $request->input('check_in_time'); // e.g., '2025-05-20'
        $checkOutDate = $request->input('check_out_time'); // e.g., '2025-05-30'
        $location = $request->input('location');

        if (!$checkInDate || !$checkOutDate) {
            return response()->json(['error' => 'Check-in and check-out dates are required'], 400);
        }

        try {
            $checkInDate = Carbon::parse($checkInDate)->format('Y-m-d');
            $checkOutDate = Carbon::parse($checkOutDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }
        
        $providers = Providers::select([
            'providers.id',
            'providers.booking_address',
            'providers.provider_name'
        ])
        ->join('rooms', 'rooms.providers_id', '=', 'providers.id')
        ->leftJoin('photos', 'providers.id', '=', 'photos.providers_id')
        ->leftJoin('booking_rooms', 'rooms.id', '=', 'booking_rooms.rooms_id')
        ->leftJoin('room_bookings', function ($join) use ($checkInDate, $checkOutDate) {
            $join->on('room_bookings.id', '=', 'booking_rooms.bookings_id')
                ->where('room_bookings.check_in_time', '<', $checkOutDate)
                ->where('room_bookings.check_out_time', '>', $checkInDate);
        })
        ->whereNull('booking_rooms.id') // No overlapping bookings
        ->where('rooms.available', true)
        ->where('providers.booking_address', 'like', '%' . $location . '%')
        ->groupBy([
            'providers.id',
            'providers.provider_name',
            'providers.booking_address'
        ])
        ->selectRaw('GROUP_CONCAT(photos.image SEPARATOR ",") as images')
        ->selectRaw('MIN(rooms.price) as price')
        ->get();
        // dd($providers);
        return view('Booking.providers.providers', ['providers' => $providers, 'pagetitle' => 'All Rooms']);
    }

    public function viewSingle(int $id) {
        $provider = DB::selectOne("
            SELECT 
                providers.id,
                providers.provider_name,
                providers.booking_address,
                provider_contacts.phone,
                providers.description
                GROUP_CONCAT(photos.image SEPARATOR ',') AS photos
            FROM providers
            LEFT JOIN provider_contacts ON provider_contacts.providers_id = providers.id
            LEFT JOIN photos ON photos.providers_id = providers.id
            WHERE providers.id = ?
            GROUP BY providers.id, providers.description, providers.provider_name, providers.booking_address, provider_contacts.phone
        ", [$id]);

        $rooms = DB::select(
            'SELECT 
                room_type,
                GROUP_CONCAT(DISTINCT price ORDER BY price) AS prices,
                GROUP_CONCAT(DISTINCT rooms.id ORDER BY rooms.id) AS roomId,
                GROUP_CONCAT(num_people ORDER BY num_people) AS num_people,
                SUM(CASE WHEN available = TRUE THEN 1 ELSE 0 END) AS rooms_available
            FROM rooms
            WHERE providers_id = ? AND 
            rooms.available = true
            GROUP BY room_type'
            , [$id]);
        // dd($provider);
        return view('Booking.providers.provider', ['provider' => $provider, 'rooms' => $rooms, 'providerId' => $id, 'actionUrl' => '' /*route('booking.store')*/]);
    }

    public function viewSingleAdmin(int $id) {
        $provider = DB::select(
            '
                SELECT 
                    providers.id, 
                    provider_name, 
                    description, 
                    booking_address,
                    GROUP_CONCAT(users.name SEPARATOR ",") as usernames,
                    GROUP_CONCAT(avatars.avatar SEPARATOR ",") as avatars, 
                    GROUP_CONCAT(reviews.comment SEPARATOR ",") as reviews, 
                    GROUP_CONCAT(reviews.rating SEPARATOR ",") as ratings, 
                    provider_contacts.id AS contact_id, 
                    provider_contacts.phone, 
                    provider_contacts.email 
                from providers 
                    LEFT JOIN provider_contacts ON providers.id = provider_contacts.providers_id 
                    LEFT JOIN reviews on providers.id = reviews.providers_id
                    LEFT JOIN users on reviews.users_id = users.id
                    LEFT JOIN avatars on avatars.users_id = users.id
                WHERE providers.id = ?
                GROUP BY providers.id, provider_name, description, booking_address, contact_id, phone, email
            ', [$id]
        );
        // dd($provider);
        $rooms = DB::select('SELECT * from rooms WHERE providers_id = ?', [$id]);
        return view('admin.providers.showProvider', ['provider' => $provider[0], 'providerId' => $id, 'rooms' => $rooms]);
    }


    public function create(){
        $provider = new Providers();
        return view('Booking/booking_form', ['provider' => $provider, 'table' => 'Provider', 'action' => 'Create', 'actionUrl' => route('admin.providers.store')]);
    }

    public function store(Request $request){
        $validationData = $request-> validate([
            'provider_name' => 'required|string',
            'booking_address' => 'required|string',
            'description' => 'required|string',
            'provider_facilities' => 'nullable'
        ]);

        $validationData['provider_facilities'] = $request->input('room_facilities');

        Providers::create($validationData);
        return redirect()->route('admin.providers.index')->with('success','successfully entered new provider');
    }

    public function edit(int $id) {
        $provider = Providers::findOrFail($id);
        return view('Booking/booking_form', ['provider' => $provider, 'table' => 'Provider', 'action' => 'Update', 'actionUrl' => route('admin.providers.update', $id)]);
    }

    public function update(int $id, Request $request){
        $provider = Providers::findOrFail($id);
        $provider->provider_name = $request->input('provider_name');
        $provider->booking_address = $request->input('booking_address');
        $provider->description = $request->input('description');
        $provider->save();
        return redirect()->route('admin.providers.index')->with('success', 'successfully edited provider details');
    }

    public function delete(int $id){
        DB::delete('DELETE FROM rooms WHERE providers_id = ?', [$id]);
        DB::delete('DELETE FROM photos WHERE providers_id = ?', [$id]);
        $provider = Providers::findOrFail($id);
        $provider->delete();
        return redirect()->route('admin.providers.index')->with('success', 'provider deleted successfully');
    }
}
