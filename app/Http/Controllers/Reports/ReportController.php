<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Booking\Providers;
use App\Models\Booking\Room;
use App\Models\Booking\RoomBooking;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display the main admin reporting dashboard.
     */
    public function adminReports()
    {
        // General App-Wide Statistics
        $totalUsers = User::count();
        $totalProviders = Providers::count();
        $totalRooms = Room::count();
        $totalBookings = RoomBooking::count();

        // Financial Reports
        $totalRevenue = RoomBooking::whereIn('status', ['confirmed', 'booking ended', 'pending check in'])->sum('booking_price');
        $monthlyRevenue = RoomBooking::select(
                DB::raw('SUM(booking_price) as revenue'),
                DB::raw("DATE_FORMAT(check_in_time, '%Y-%m') as month")
            )
            ->whereIn('status', ['confirmed', 'booking ended', 'pending check in'])
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        // Provider Focused Reports
        $topProviders = Providers::query()
            ->select('providers.provider_name', 'providers.id', DB::raw('count(distinct booking_rooms.id) as bookings_count'))
            ->join('rooms', 'providers.id', '=', 'rooms.providers_id')
            ->join('booking_rooms', 'rooms.id', '=', 'booking_rooms.rooms_id')
            ->groupBy('providers.id', 'providers.provider_name')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();
    

        // Room Focused Reports
        $mostBookedRooms = Room::query()
             ->select('rooms.room_number', 'rooms.room_type', 'providers.provider_name', DB::raw('count(distinct booking_rooms.id) as bookings_count'))
             ->join('providers', 'rooms.providers_id', '=', 'providers.id')
             ->join('booking_rooms', 'rooms.id', '=', 'booking_rooms.rooms_id')
             ->groupBy('rooms.id', 'rooms.room_number', 'rooms.room_type', 'providers.provider_name')
             ->orderBy('bookings_count', 'desc')
             ->limit(5)
             ->get();
            //  dd($mostBookedRooms);

        // Booking Status Distribution
        $bookingStatusDistribution = RoomBooking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.reports.index', compact(
            'totalUsers',
            'totalProviders',
            'totalRooms',
            'totalBookings',
            'totalRevenue',
            'monthlyRevenue',
            'topProviders',
            'mostBookedRooms',
            'bookingStatusDistribution'
        ));
    }

    /**
     * Display a reporting dashboard scoped to the logged-in provider user.
     */
    public function providerReports()
    {
        $providerId = Auth::guard('provider')->user()->provider_id;

        if (!$providerId) {
            return redirect()->route('provider.dashboard')->with('error', 'You are not assigned to a provider.');
        }

        // General Provider Statistics
        $totalRooms = Room::where('providers_id', $providerId)->count();
        $totalBookings = DB::table('booking_rooms')
            ->join('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
            ->where('rooms.providers_id', $providerId)
            ->distinct('booking_rooms.id')
            ->count('booking_rooms.id');

        // Financial Reports
        $baseFinancialQuery = RoomBooking::query()
            ->join('booking_rooms', 'room_bookings.id', '=', 'booking_rooms.bookings_id')
            ->join('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
            ->where('rooms.providers_id', $providerId)
            ->whereIn('room_bookings.status', ['confirmed', 'booking ended', 'pending check in']);
            
        $totalRevenue = (clone $baseFinancialQuery)->sum('room_bookings.booking_price');
        
        $monthlyRevenue = (clone $baseFinancialQuery)
            ->select(
                DB::raw('SUM(room_bookings.booking_price) as revenue'),
                DB::raw("DATE_FORMAT(room_bookings.check_in_time, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        // Room Focused Reports for this Provider
        $mostBookedRooms = Room::query()
            ->select('rooms.room_number', 'rooms.room_type', DB::raw('count(distinct booking_rooms.id) as bookings_count'))
            ->join('booking_rooms', 'rooms.id', '=', 'booking_rooms.rooms_id')
            ->where('rooms.providers_id', $providerId)
            ->groupBy('rooms.id', 'rooms.room_number', 'rooms.room_type')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();
            
        // Booking Status Distribution for this Provider
        $bookingStatusDistribution = RoomBooking::query()
            ->join('booking_rooms', 'room_bookings.id', '=', 'booking_rooms.bookings_id')
            ->join('rooms', 'booking_rooms.rooms_id', '=', 'rooms.id')
            ->where('rooms.providers_id', $providerId)
            ->select('room_bookings.status', DB::raw('count(*) as count'))
            ->groupBy('room_bookings.status')
            ->pluck('count', 'status');

        return view('providers.reports.index', compact(
            'totalRooms',
            'totalBookings',
            'totalRevenue',
            'monthlyRevenue',
            'mostBookedRooms',
            'bookingStatusDistribution'
        ));
    }
}
