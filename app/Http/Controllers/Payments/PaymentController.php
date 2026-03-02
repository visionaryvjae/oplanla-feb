<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Booking\BookingRooms;
use App\Models\Booking\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewBookingNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin\Admin;

class PaymentController extends Controller
{
    /**
     * Redirect the user to the Yoco payment page.
     * This is called by the HandlePayment middleware.
     */
    public function redirectToGateway()
    {
        // Retrieve the booking details and total amount from the session
        $bookingDetails = Session::get('booking_details');
        $totalAmount = Session::get('total_amount'); // Ensure this is in cents
        $bookingId = Session::get('booking_id');

        if (!$bookingDetails || !$totalAmount) {
            // Handle error: redirect back with an error message
            return redirect()->route('booking.form')->with('error', 'Booking details are missing. Please try again.');
        }

        // Prepare the data for the Yoco API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.yoco.secret_key')
        ])->post('https://online.yoco.com/v1/checkout/create', [
            'amount' => $totalAmount,
            'currency' => 'ZAR',
            'metadata' => [
                'booking_ref' => uniqid('booking_'), // Create a unique reference
            ],
            // These URLs must be publicly accessible for Yoco to reach them
            'successUrl' => route('payment.success'),
            'failureUrl' => route('payment.failure'),
        ]);

        if ($response->successful()) {
            $paymentData = $response->json();
            
            $booking = RoomBooking::FindOrFail($bookingId);
            
            if($lastBooking->bookingRoom->room->provider->user->first()){
               $lastBooking->bookingRoom->room->provider->user->first()->notify(new NewBookingNotification($bookingId)); 
            }
            
            $admins = Admin::all();
            Notification::send($admins, new NewBookingNotification($bookingId));
            
            // Store the unique payment ID from Yoco in the session
            // This is crucial for verifying the callback
            Session::put('yoco_payment_id', $paymentData['id']);

            // Redirect the user to the Yoco payment page
            return redirect()->away($paymentData['redirectUrl']);
        }

        // Handle API error
        return redirect()->route('room.booking.create')->with('error', 'Could not initiate payment. Please try again later.');
    }

    /**
     * Handle the successful payment callback from Yoco.
     */
    public function handleSuccess(Request $request)
    {
        $yocoPaymentId = Session::get('yoco_payment_id');
        $bookingDetails = Session::get('booking_details');

        // Basic validation
        if (!$yocoPaymentId || !$bookingDetails) {
            return redirect()->route('dashboard')->with('error', 'Payment session expired.');
        }

        $validationData = $request->validate([
            'check_in_time' => 'required|date',
            'check_out_time' => 'required|date|after:check_in_time',
            'booking_price' => 'integer',
        ]);

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
        RoomBooking::create($validationData);

        $latestBooking = RoomBooking::latest()->first();
        // dd($latestBooking);

        foreach($roomTypes as $index => $type){
            $roomIds = DB::select('SELECT rooms.id FROM rooms LEFT JOIN providers ON rooms.providers_id = providers.id WHERE rooms.room_type = ? AND providers.id = ? AND rooms.available = true', [$type, $providerId]);
            $roomIds = array_column($roomIds, 'id');

            // dd($roomIds);
            for($i = 0; $i < $numRooms[$index]; $i++){
                $booking_room = new BookingRooms();
                $booking_room->rooms_id = $roomIds[$i];
                $booking_room->bookings_id = $latestBooking->id;
                $booking_room->save();

                DB::update('UPDATE rooms SET available = 0 WHERE id = ?', [$roomIds[$i]]);
            }
            
        }
        // dd($roomIds);
        return redirect()->route('room.booking')->with('successful', 'successfully created booking');
    }

    /**
     * Handle the failed payment callback from Yoco.
     */
    public function handleFailure()
    {
        // Clear the session data
        Session::forget(['booking_details', 'total_amount', 'yoco_payment_id']);

        // Redirect with an error message
        return redirect()->route('dashboard')->with('error', 'Your payment failed. Please try again.');
    }
}
