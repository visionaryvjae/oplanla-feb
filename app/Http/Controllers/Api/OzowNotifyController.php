<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Payment as RentPayment;

class OzowNotifyController extends Controller
{
    // App\Http\Controllers\Api\OzowNotifyController.php

    public function handleNotify(Request $request)
    {
        // Find the payment record
        $payment = RentPayment::where('invoice_number', $request->TransactionReference)->first();

        if (!$payment) return response('Record Not Found', 404);

        if ($request->Status === 'Complete') {
            \DB::transaction(function () use ($payment, $request) {
                // 1. Update the Payment Ledger
                $payment->update([
                    'status' => 'paid',
                    'verified_at' => now(),
                    'gateway_transaction_id' => $request->TransactionId,
                ]);

                // 2. Sync the Charges Table (The Invoicing side)
                if ($payment->payment_type === 'all') {
                    // If "Pay All" was used, mark all outstanding charges for this tenant as paid
                    RoomCharge::where('rooms_id', $payment->tenant->rooms_id)
                        ->where('is_paid', 0)
                        ->update(['is_paid' => 1]);
                } else {
                    // Mark the single corresponding charge as paid
                    RoomCharge::where('id', $payment->charge_id)
                        ->update(['is_paid' => 1]);
                }
            });

            return response('OK', 200);
        }

        return response('Processed', 200);
    }
}
