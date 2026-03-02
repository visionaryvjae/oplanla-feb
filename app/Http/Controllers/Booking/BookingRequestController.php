<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\RoomBooking;
use App\Models\Booking\BookingRequest;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{

    public function index()
    {
        // Eager load the required relationships
        $requests = BookingRequest::with([
            'booking.user', // Load the user associated with the booking
            'booking.bookingRooms.room.provider' // Load the provider through bookingRooms and room
        ])
        ->where('status', 'pending')
        ->get();

        // dd($requests);

        return view('admin.requests.booking_requests', compact('requests'));
    }
    
    public function show(int $id){
        $request = BookingRequest::findorfail($id);
        //dd($request->booking);
        return view('admin.requests.request-show', compact('request'));
    }

    public function approve(BookingRequest $request)
    {
        $request->update(['status' => 'approved']);
        $request->save();
        // Add logic here to notify the user or auto-update the booking if desired
        return back()->with('success', 'Request has been approved.');
    }

    public function reject(BookingRequest $request)
    {
        $request->update(['status' => 'rejected']);
        $request->save();
        // Add logic here to notify the user
        return back()->with('success', 'Request has been rejected.');
    }


    public function create(RoomBooking $booking)
    {
        // Authorization check: ensure the user owns this booking
        if (auth()->id() !== $booking->users_id) {
            abort(403);
        }
        return view('Booking.bookings.request_change_form', compact('booking'));
    }

    public function store(Request $request, RoomBooking $booking)
    {
        if (auth()->id() !== $booking->users_id) {
            abort(403);
        }
        
        $new_check_in_time = $request->input('check_in_time');

        $request->validate(['message' => 'required|string|min:20']);
        
        $message = $request->input('message') . "\tNew check in time\t\n" . $new_check_in_time;

        BookingRequest::create([
            'bookings_id' => $booking->id,
            'users_id' => auth()->id(),
            'type' => 'edit',
            'message' => $message,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.show.single', $booking->id)->with('success', 'Your change request has been sent to the admin for review.');
    }
    
    public function storeCancel(RoomBooking $booking)
    {
        if (auth()->id() !== $booking->users_id) {
            abort(403);
        }

        BookingRequest::create([
            'bookings_id' => $booking->id,
            'users_id' => auth()->id(),
            'type' => 'cancellation',
            'message' => 'User requested to cancel this booking.',
            'status' => 'pending',
        ]);

        return redirect()->route('booking.show.single', $booking->id)->with('success', 'Your cancellation request has been sent to the admin for review.');
    }
}