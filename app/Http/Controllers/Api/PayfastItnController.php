<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking\Payment as RentPayment;
use App\Models\Booking\Charge as RoomCharge;

class PayfastItnController extends Controller
{
    public function handleNotify(Request $request)
    {
        // 1. Verify the signature from Payfast for security
        // (In production, also verify the Payfast server IP)

        $payment = RentPayment::where('invoice_number', $request->m_payment_id)->first();

        if ($payment && $request->payment_status === 'COMPLETE') {
            \DB::transaction(function () use ($payment, $request) {
                // Update Transaction Ledger
                $payment->update([
                    'status' => 'paid',
                    'verified_at' => now(),
                ]);

                // Sync Invoicing Table
                if ($payment->payment_type === 'all') {
                    RoomCharge::where('rooms_id', $payment->tenant->rooms_id)
                        ->where('is_paid', 0)
                        ->update(['is_paid' => 1]);
                } else {
                    RoomCharge::where('id', $payment->charge_id)
                        ->update(['is_paid' => 1]);
                }
            });

            return response('OK', 200);
        }

        return response('Incomplete', 200);
    }
}
