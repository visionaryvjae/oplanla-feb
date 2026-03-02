<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    protected $markup;

    public function __construct()
    {
        // Initialize the static property in the constructor
         $this->markup = Config::get('app.markup', 1) - 1;
    }
    
    public function index(){

        $currentDate = now();

        $upcomingBookings = DB::table('room_bookings')
        ->leftJoin('booking_rooms', 'room_bookings.id', '=', 'booking_rooms.bookings_id')
        ->leftJoin('users', 'room_bookings.users_id', '=', 'users.id')
        ->leftJoin('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->leftJoin('photos', 'photos.providers_id', '=', 'providers.id')
        ->select(
            DB::raw('COUNT(DISTINCT room_bookings.id) as num_bookings'),
            DB::raw('SUM(DISTINCT room_bookings.booking_price) as payouts')
        )
        ->where('room_bookings.status', '=', 'pending check in')
        ->whereDate('room_bookings.check_in_time', '>=', $currentDate)
        ->get();
        
        $totalProfits = DB::select('
            SELECT 
                SUM(room_bookings.booking_price * ?) as profits
            from room_bookings
            where status = ?
        ', [$this->markup, 'booking ended']);


        $activeRooms = DB::table('rooms')
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->select(
            DB::raw('COUNT(rooms.id) as num_rooms'),
        )
        ->where('rooms.available', true)
        ->get();

        return view('admin.dashboard', ['activeRooms' => $activeRooms[0], 'upcomingBookings' => $upcomingBookings[0], 'totalProfits' => $totalProfits[0]]);
    }
}
