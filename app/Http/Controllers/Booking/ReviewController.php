<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\Providers;
use App\Models\Booking\Review;
use App\Models\Booking\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\View\View
     */
    public function create(int $pid)
    {
        $booking = DB::select('
            SELECT 
                room_bookings.id,
                providers.id AS provider_id,
                providers.provider_name
            FROM 
                room_bookings
            INNER JOIN 
                booking_rooms ON booking_rooms.bookings_id = room_bookings.id
            INNER JOIN 
                rooms ON rooms.id = booking_rooms.rooms_id
            INNER JOIN 
                providers ON providers.id = rooms.providers_id
            WHERE 
                room_bookings.id = ?;
        ', [$pid]);

        // dd($booking);

        // You might want to pass the provider's details to the view
        return view('Booking.bookings.create_review', ['booking' => $booking[0]]);
    }

    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'bookings_id' => 'required|integer',
            'providers_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'users_id' => Auth::id(),
            'providers_id' => $request->providers_id,
            'bookings_id' => $request->bookings_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('dashboard')->with('success', 'Thank you for your review!');
    }
}
