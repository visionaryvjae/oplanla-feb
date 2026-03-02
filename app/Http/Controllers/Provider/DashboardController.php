<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:provider');
    }

    public function index()
    {
        // Get the logged-in provider user
        $providerUser = Auth::guard('provider')->user();

        // Get the associated provider company and its name
        $partnerName = $providerUser->provider->provider_name;

        $partnerId = Auth::guard('provider')->user()->provider->id;
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
        ->where('providers.id', '=', $partnerId)
        ->where('room_bookings.status', '=', 'pending check in')
        ->whereDate('room_bookings.check_in_time', '>=', $currentDate)
        ->get();

        // dd($upcomingBookings);

        $avgReview = DB::table('reviews')
        ->leftjoin('providers', 'providers.id', '=', 'reviews.providers_id')
        ->select(
            DB::raw('AVG(reviews.rating) as avg_rating')
        )
        ->where('providers_id', '=', $partnerId)
        ->get();

        // dd($avgReview); 

        $activeRooms = DB::table('rooms')
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->select(
            DB::raw('COUNT(rooms.id) as num_rooms'),
        )
        ->where('providers.id', '=', $partnerId)
        ->where('rooms.available', true)
        ->get();

        // dd($activeRooms);

        return view('Booking.footer-components.partner-hub', ['partnerName' => $partnerName, 'avgReview' => $avgReview[0], 'activeRooms' => $activeRooms[0], 'upcomingBookings' => $upcomingBookings[0]]);
    }
}