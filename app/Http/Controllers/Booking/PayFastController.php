<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayFast\PayFast as PayFastSDK;
use PayFast\PayFastPayment;
use Illuminate\Support\Facades\Auth;

class PayFastController extends Controller
{
    /**
     * Generates the security signature for PayFast.
     *
     * @param array $data The data to be sent to PayFast
     * @param string|null $passphrase Your PayFast passphrase
     * @return string The MD5 signature
     */
    private function generateSignature($data, $passphrase = null)
    {
        // Add passphrase to data if provided
        if ($passphrase !== null) {
            $data['passphrase'] = $passphrase;
        }

        // Create a query string from the data
        $queryString = http_build_query($data);

        // Generate and return the MD5 hash
        return md5($queryString);
    }

    /**
     * Gets the PayFast URL (Sandbox or Production).
     */
    private function getPayFastUrl()
    {
        $isSandbox = config('services.payfast.sandbox', env('PAYFAST_SANDBOX', true));
        return $isSandbox ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process';
    }

    /**
     * Show the auto-redirecting payment form.
     */
    public function showPaymentForm(Request $request)
    {
        if (!$request->session()->has('booking_data')) {
            return redirect()->route('room.booking')->with('error', 'Booking details not found. Please try again.');
        }

        $bookingData = $request->session()->get('booking_data');
        $bookingId = $bookingData['booking_id'];
        $amount = $bookingData['amount'];
        $user = Auth::user();

        // 1. Get all config values
        $merchantId = config('services.payfast.merchant_id', env('PAYFAST_MERCHANT_ID'));
        // dd($merchantId);
        $merchantKey = config('services.payfast.merchant_key', env('PAYFAST_MERCHANT_KEY'));
        $passphrase = config('services.payfast.passphrase', env('PAYFAST_PASSPHRASE'));
        $payfastUrl = $this->getPayFastUrl();

        // 2. Prepare the data array
        // This array contains all fields required for the form submission
        $data = [
            'merchant_id'   => $merchantId,
            'merchant_key'  => $merchantKey,
            'amount'        => number_format($amount, 2, '.', ''),
            'item_name'     => 'Room Booking #' . $bookingId,
            'return_url'    => route('payfast.success'),
            'cancel_url'    => route('payfast.cancel'),
            'notify_url'    => route('payfast.notify'),
            'name_first'    => $user->name, // Assuming 'name' field, split if you have first/last
            'name_last'     => $user->last_name ?? 'User', // Use a default if no last name
            'email_address' => $user->email,
            'm_payment_id'  => $bookingId,
            
        ];

        // 3. Generate the signature
        // We pass the data array AND the passphrase to our helper function
        $signature = $this->generateSignature($data, $passphrase);

        // Add the signature to the data array
        // $data['signature'] = $signature;

        // 4. Return the view with all the data
        return view('Booking.bookings.payfast_redirect', [
            'payfastUrl' => $payfastUrl,
            'formData' => $data,
        ]);
    }

    /**
     * Handles the ITN (Instant Transaction Notification) from PayFast.
     * This is the most important method for confirming payment.
     */
    public function notify(Request $request)
    {
        Log::info('PayFast ITN Received (Manual)', $request->all());

        $itnData = $request->all();
        $passphrase = env('PAYFAST_PASSPHRASE');

        // 1. Generate a signature from the received data (excluding the received signature)
        $receivedSignature = $itnData['signature'];
        unset($itnData['signature']);
        
        $generatedSignature = $this->generateSignature($itnData, $passphrase);

        // 2. Compare generated signature with received signature
        if ($generatedSignature !== $receivedSignature) {
            Log::error('PayFast ITN: Signature mismatch.');
            return response('Signature mismatch', 400);
        }

        // 3. (Optional but Recommended) Verify the payment with PayFast directly
        $payfastUrl = $this->getPayFastUrl();
        $response = Http::post($payfastUrl . '/validate', $itnData);
        
        if (!$response->successful() || $response->body() !== 'VALID') {
            Log::error('PayFast ITN: Invalid response from PayFast validation.');
            return response('Invalid payment', 400);
        }

        // 4. Signatures match and payment is valid. Update the booking.
        $bookingId = $itnData['m_payment_id'];
        $booking = RoomBooking::find($bookingId);

        if (!$booking) {
            Log::error("PayFast ITN: Booking not found for ID: " . $bookingId);
            return response('Booking not found', 404);
        }

        if ($itnData['payment_status'] === 'COMPLETE') {
            $booking->status = 'pending check in';
            $booking->save();
            Log::info("PayFast ITN: Payment COMPLETE for Booking ID: " . $bookingId);
        } elseif ($itnData['payment_status'] === 'FAILED') {
            $booking->status = 'payment failed';
            $booking->save();
            Log::error("PayFast ITN: Payment FAILED for Booking ID: " . $bookingId);
        }

        return response('OK', 200);
    }

    /**
     * Handles the successful return from PayFast.
     */
    public function success(Request $request)
    {
        return redirect()->route('dashboard')->with('success', 'Payment was successful! Your booking is confirmed.');
    }

    /**
     * Handles the user cancelling the payment.
     */
    public function cancel(Request $request)
    {
        return redirect()->route('room.booking')->with('error', 'You have cancelled the payment process.');
    }
}
