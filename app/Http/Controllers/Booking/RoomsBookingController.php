<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\BookingRooms;
use App\Models\Booking\Room;
use App\Models\Booking\RoomBooking;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationData;
use App\Notifications\NewBookingNotification;
use Throwable;


class RoomsBookingController extends Controller
{
    public function index(Request $request) {
        
        $query = RoomBooking::query();
        
        if($request->filled('status')){
            $query->where('status', $request->status);
        }
        
        if($request->filled('client')){
            $query->where('users_id', $request->client);
        }
        
        if($request->filled('start_date')){
            $query->where('check_in_time', '>=', $request->start_date);
        }
        
        if($request->filled('end_date')){
            $query->where('check_out_time', '<=', $request->end_date);
        }
        
        $bookings = $query->latest()->paginate(10);
        
        $users = User::all();
        return view('admin.bookings.bookings', ['bookings' => $bookings, 'users' => $users, 'pagetitle' => 'List of booking made']);
    }

    public function indexProvider() {
        
        
        $pid = Auth::guard('provider')->user()->provider->id;

        $bookings = $bookings = DB::table('room_bookings')
        ->leftJoin('booking_rooms', 'room_bookings.id', '=', 'booking_rooms.bookings_id')
        ->leftJoin('users', 'room_bookings.users_id', '=', 'users.id')
        ->leftJoin('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->select(
            'room_bookings.id',
            'providers.provider_name',
            'users.name as user_name',
            'room_bookings.status',
            'room_bookings.booking_price',
            'room_bookings.check_in_time',
            'room_bookings.check_out_time',
            DB::raw('GROUP_CONCAT(DISTINCT rooms.room_type) as room_types')
        )
        ->where('providers.id', '=', $pid)
        ->groupBy([
            'room_bookings.id',
            'providers.provider_name',
            'users.name',
            'room_bookings.status',
            'room_bookings.booking_price',
            'room_bookings.check_in_time',
            'room_bookings.check_out_time',
        ])
        ->get();
        return view('providers.bookings.bookings', ['bookings' => $bookings, 'pagetitle' => 'List of booking made']);
    }

    public function dashboard() {

        if(!Auth::check()){
            return redirect()->back()->with('error', 'You must be logged in.');
        }

        $userId = Auth::id();
        $currentDate = now();

        $bookings = RoomBooking::where('room_bookings.users_id', $userId)
        ->where('room_bookings.status', '=', 'pending check in')
        ->where('room_bookings.check_in_time', '>=', $currentDate)
        ->get();
        
        
        // $bookings = DB::table('room_bookings')
        // ->leftJoin('booking_rooms', 'room_bookings.id', '=', 'booking_rooms.bookings_id')
        // ->leftJoin('users', 'room_bookings.users_id', '=', 'users.id')
        // ->leftJoin('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
        // ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        // ->leftJoin('photos', 'photos.providers_id', '=', 'providers.id')
        // ->select(
        //     'room_bookings.id',
        //     'providers.id AS provider_id',
        //     'providers.provider_name',
        //     'users.name as user_name',
        //     'room_bookings.status',
        //     'room_bookings.booking_price',
        //     'room_bookings.check_in_time',
        //     'room_bookings.check_out_time',
        //     DB::raw('MIN(photos.image) as display'),
        //     DB::raw('GROUP_CONCAT(DISTINCT rooms.room_type) as room_types')
        // )
        // ->where('room_bookings.users_id', $userId)
        // ->where('room_bookings.status', '=', 'pending check in')
        // ->whereDate('room_bookings.check_in_time', '>=', $currentDate)
        // ->groupBy([
        //     'room_bookings.id',
        //     'providers.id',
        //     'providers.provider_name',
        //     'users.name',
        //     'room_bookings.status',
        //     'room_bookings.booking_price',
        //     'room_bookings.check_in_time',
        //     'room_bookings.check_out_time',
        // ])
        // ->get();

        $pastBookings = DB::table('room_bookings')
        ->leftJoin('booking_rooms', 'room_bookings.id', '=', 'booking_rooms.bookings_id')
        ->leftJoin('users', 'room_bookings.users_id', '=', 'users.id')
        ->leftJoin('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->leftJoin('photos', 'photos.providers_id', '=', 'providers.id')
        ->leftJoin('reviews', function($join) use ($userId) {
            $join->on('room_bookings.id', '=', 'reviews.bookings_id')
            ->where('reviews.users_id', '=', $userId); // Ensure it's the current user's review
        })
        ->select(
            'room_bookings.id',
            'providers.id AS provider_id',
            'providers.provider_name',
            'users.name as user_name',
            'room_bookings.status',
            'room_bookings.booking_price',
            'room_bookings.check_in_time',
            'room_bookings.check_out_time',
            DB::raw('MIN(photos.image) as display'),
            DB::raw('GROUP_CONCAT(DISTINCT rooms.room_type) as room_types'),
            DB::raw('CASE WHEN reviews.id IS NOT NULL THEN 1 ELSE 0 END AS has_review')
        )
        ->where('room_bookings.users_id', $userId)
        ->where('room_bookings.status', '<>', 'booking canceled')
        ->whereDate('room_bookings.check_out_time', '<', $currentDate)
        ->groupBy([
            'room_bookings.id',
            'providers.id',
            'providers.provider_name',
            'users.name',
            'room_bookings.status',
            'room_bookings.booking_price',
            'room_bookings.check_in_time',
            'room_bookings.check_out_time',
            'reviews.id'
        ])
        ->orderby('room_bookings.check_in_time', 'desc')
        ->get();

        // dd($bookings);
        return view('dashboard', ['bookings' => $bookings, 'pastBookings' => $pastBookings]);
    }

    function landing () {
        return view('Booking.landing', ['actionUrl' => route('rooms.search')]);
    }

    public function viewSingle(int $id) {
        $booking = DB::select('
            SELECT 
                room_bookings.id,
                room_bookings.status,
                room_bookings.check_in_time,
                room_bookings.check_out_time,
                room_bookings.booking_price,
                providers.provider_name,
                rooms.room_type,
                rooms.room_facilities,
                providers.booking_address,
                GROUP_CONCAT(photos.image SEPARATOR ",") as images
            from room_bookings
                LEFT JOIN booking_rooms ON room_bookings.id = booking_rooms.bookings_id
                LEFT JOIN rooms ON booking_rooms.rooms_id = rooms.id
                LEFT JOIN providers ON rooms.providers_id = providers.id
                LEFT JOIN photos ON providers.id = photos.providers_id
            where room_bookings.id = ?
            GROUP BY 
                room_bookings.id,
                room_bookings.status,
                room_bookings.check_in_time,
                room_bookings.check_out_time,
                room_bookings.booking_price,
                providers.provider_name,
                rooms.room_type,
                rooms.room_facilities,
                providers.booking_address
        ', [$id]);
        // dd($booking);
        return view('Booking/bookings/booking_show', ['booking' => $booking[0]]);
    }

    public function viewSingleAdmin(int $id) {
        $room_booking = $bookings = DB::table('room_bookings')
        ->leftJoin('booking_rooms', 'room_bookings.id', '=', 'booking_rooms.bookings_id')
        ->leftJoin('users', 'room_bookings.users_id', '=', 'users.id')
        ->leftJoin('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->select(
            'room_bookings.id',
            'providers.provider_name',
            'providers.booking_address',
            'users.name as user_name',
            'room_bookings.status',
            'room_bookings.booking_price',
            'room_bookings.check_in_time',
            'room_bookings.check_out_time',
            DB::raw('GROUP_CONCAT(DISTINCT rooms.room_type) as room_types')
        )
        ->groupBy([
            'room_bookings.id',
            'providers.provider_name',
            'providers.booking_address',
            'users.name',
            'room_bookings.status',
            'room_bookings.booking_price',
            'room_bookings.check_in_time',
            'room_bookings.check_out_time',
        ])
        ->where('room_bookings.id', $id)
        ->first();
        //dd($room_booking);
        return view('admin.bookings.booking', ['room_booking' => $room_booking,]);
    }

    public function create(Request $request){
        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }
        
        $num_rooms = explode(',', $request->query('num_rooms'));
        $roomIds = explode(',', $request->query('room_ids'));
        $checkInTime = $request->query('check_in_time');
        $checkOutTime = $request->query('check_out_time');
        $providerId = $request->query('pid');

        if ($roomIds && is_array($roomIds)) {
            // Fetch rooms based on the provided IDs
            $booking_rooms = Room::whereIn('id', $roomIds)->get();

            // You might want to handle the case where some rooms are not found
            if ($booking_rooms->count() !== count(array_unique($roomIds))) {
                return redirect()->back()->with('error', 'Some of the selected rooms are not available.');
            }

            return view('Booking.bookings.confirm_booking', [
                'providerId' => $providerId,
                'rooms' => $booking_rooms,
                'num_rooms' => $num_rooms,
                'check_in_time' => $checkInTime,
                'check_out_time' => $checkOutTime,
                'table' => 'Booking',
                'action' => 'Create',
            ]);
        }

        return redirect()->route('room.booking')->with('error', 'No rooms were selected.');
    }

    public function store(Request $request){

        // dd($request);
        try{
            $validationData = $request->validate([
                'check_in_time' => 'required|date',
                'check_out_time' => 'required|date|after:check_in_time',
                'booking_price' => 'integer',
            ]);

            $amount = $request->input('booking_price');

            if (!Auth::check()) {
                return redirect()->back()->with('error', 'You must be logged in to make a booking.');
            }

            $userId = Auth::id();
            $providerId = $request->input('pid');
            // This will be an array of room type IDs, repeated for each room selected
            // e.g., [1, 1, 2] for two rooms of type 1 and one of type 2.
            $roomTypes = $request->input('room_types',[]);
            //$roomTypeIds = $request->input('room_ids');
            $numRooms = $request->input('num_rooms');
            
            $validationData['users_id'] = $userId;
            $validationData['payment_status'] = 'pending payment'; 
            $latestBooking = RoomBooking::create($validationData);
            // dd($latestBooking);

            // dd([$latestBooking->id, $amount]);

            foreach($roomTypes as $index => $type){
                $roomIds = DB::select('SELECT rooms.id FROM rooms LEFT JOIN providers ON rooms.providers_id = providers.id WHERE rooms.room_type = ? AND providers.id = ? AND rooms.available = true', [$type, $providerId]);
                $roomIds = array_column($roomIds, 'id');

                // dd($roomIds);
                for($i = 0; $i < $numRooms[$index]; $i++){
                    if (!isset($roomIds[$i])) {
                        // Rollback: Delete the booking header if a room is not available
                        $latestBooking->delete(); 
                        
                        // Need to find which rooms were already reserved in this loop and un-reserve them
                        // This is a simplified rollback. For a production app, a database transaction is better.
                        DB::update('UPDATE rooms r
                            JOIN booking_rooms br ON r.id = br.rooms_id
                            SET r.available = 1 
                            WHERE br.bookings_id = ?', [$latestBooking->id]);
                        
                        // Delete the booking_rooms entries
                        BookingRooms::where('bookings_id', $latestBooking->id)->delete();
                        
                        return redirect()->route('room.booking')->with('error','Sorry, one of the selected rooms just became unavailable. Please try again.');
                    }
                    $booking_room = new BookingRooms();
                    $booking_room->rooms_id = $roomIds[$i];
                    $booking_room->bookings_id = $latestBooking->id;
                    $booking_room->save();

                    DB::update('UPDATE rooms SET available = 0 WHERE id = ?', [$roomIds[$i]]);
                }
                
            }

            $paymentMethod = $request->input('payment_method');

            if ($paymentMethod === 'payfast') {
                // Redirect to the PayFast controller route
                return redirect()->route('payfast.pay')->with('booking_data', ['booking_id' => $latestBooking->id, 'amount' => $amount]);
            } 
            elseif ($paymentMethod === 'paypal') {
                // Redirect to the existing PayPal route
                return redirect()->route('paypal.create')->with('booking_data', ['booking_id' => $latestBooking->id, 'amount' => $amount]);
            }
        }
        catch(Exception $ex) {
            return redirect()->route('room.booking')->with('error','unexpected error' . $ex->getMessage());
        }
        
    }

    public function edit(int $id) {
        $booking = RoomBooking::findOrFail($id);
        $users = DB::select('SELECT id, name from users');
        return view('Booking/booking_form', ['booking' => $booking, 'action' => 'update', 'users' => $users, 'table' => 'Booking', 'actionUrl' => route('room.booking.update', [$id])]);
    }

    public function update(int $id, Request $request){
        $booking = RoomBooking::findOrFail($id);
        $booking->status = $request->input('status');
        $booking->check_in_time = $request->input('check_in_time');
        $booking->check_out_time = $request->input('check_out_time');
        $booking->users_id = $request->input('users_id');

        $booking->save();
        return redirect()->route('room.booking.index')->with('success', 'successfully edited booking details');
    }

    public function delete(int $id){
        $booking = RoomBooking::findOrFail($id);
        $booking->delete();
        return redirect()->route('room.booking.index')->with('success', 'booking deleted successfully');
    }

    public function end_booking(int $id, Request $request){
        $booking = RoomBooking::findOrFail($id);
        $booking->status = "booking ended";

        $booking->save();

        DB::update(
            'Update rooms 
                JOIN booking_rooms ON rooms.id = booking_rooms.rooms_id
                SET available = true 
                WHERE booking_rooms.bookings_id = ?
            ', [$id]);
        return redirect()->route('room.booking.index')->with('success', 'successfully edited booking details');
    }

    public function cancel_booking(int $id, Request $request){
        $booking = RoomBooking::findOrFail($id);
        $booking->status = "booking canceled";

        $booking->save();

        DB::update(
            'Update rooms 
                JOIN booking_rooms ON rooms.id = booking_rooms.rooms_id
                SET available = true 
                WHERE booking_rooms.bookings_id = ?
            ', [$id]);
        return redirect()->route('room.booking.index')->with('success', 'successfully edited booking details');
    }
}
