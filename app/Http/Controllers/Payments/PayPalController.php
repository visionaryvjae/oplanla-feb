<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Booking\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function create(Request $request)
    {
        // Retrieve the 'booking_data' array from the session
        $bookingData = $request->session()->get('booking_data');

        // Check if 'booking_data' exists in the session
        if (!$bookingData) {
            return redirect()->back()->withErrors(['error' => 'Booking data not found in session.']);
        }

        // Extract values from the booking_data array
        $bookingId = $bookingData['booking_id'];
        $amount = round($bookingData['amount'] / env('USD_TO_ZAR_RATE'));

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ],
                    "custom_id" => $bookingId
                ]
            ]
        ]);
        

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }
        $lastBooking = RoomBooking::latest()->first();

        $lastBooking->status = "booking canceled";

        $lastBooking->save();
        
        if($lastBooking->bookingRoom->room->provider->user->first()){
           $lastBooking->bookingRoom->room->provider->user->first()->notify(new NewBookingNotification($lastBooking->id)); 
        }
        
        $admins = Admin::all();
        Notification::send($admins, new NewBookingNotification($lastBooking->id));

        DB::update(
            'Update rooms 
                JOIN booking_rooms ON rooms.id = booking_rooms.rooms_id
                SET available = true 
                WHERE booking_rooms.bookings_id = ?
            ', [$lastBooking->id]);

        return redirect()->back()->with('error', 'Something went wrong.');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Get booking ID from transaction
            $bookingId = $response['purchase_units'][0]['payments']['captures'][0]['custom_id'];
            
            // Update booking status
            RoomBooking::find($bookingId)->update([
                'payment_status' => 'paid',
                'transaction_id' => $response['id']
            ]);

            return redirect()->route('room.booking')->with('success', 'booking successfully created');
        }

        return redirect()->route('room.booking')->with('error', 'Payment failed.');
    }

    public function cancel()
    {
        $lastBooking = RoomBooking::latest()->first();

        $lastBooking->status = "booking canceled";

        $lastBooking->save();

        DB::update(
            'Update rooms 
                JOIN booking_rooms ON rooms.id = booking_rooms.rooms_id
                SET available = true 
                WHERE booking_rooms.bookings_id = ?
            ', [$lastBooking->id]);

        return redirect()->route('room.booking')->with('error', 'Payment canceled.');
    }
}