<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HandlePayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Get validated booking data from the request.
        // It's assumed your BookingController's store method validates this first.
        $bookingDetails = $request->validated(); // Or $request->all() if not using form requests

        // 2. Calculate the total amount.
        // This logic will depend on your application.
        // EXAMPLE:
        // $nights = $check_out_date->diffInDays($check_in_date);
        // $totalAmount = $room->price * $nights;
        $totalAmountInCents = 1500 * 100; // Example: R1500.00 - Yoco requires the amount in cents.

        // 3. Store the details in the session.
        Session::put('booking_details', $bookingDetails);
        Session::put('total_amount', $totalAmountInCents);

        // 4. Redirect to the payment initiation route.
        return redirect()->route('payment.initiate');

        // The original $next($request) is never called, effectively
        // intercepting the request and rerouting it through the payment flow.
    }
}
