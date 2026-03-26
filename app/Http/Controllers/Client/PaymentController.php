<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Payment as RentPayment;
use App\Models\Booking\Charge as RoomCharge; 
use Illuminate\Support\Str;
use App\Models\Booking\BankDetail as ProviderBankDetail;
use Illuminate\Support\Facades\Auth;
use App\Services\OzowService;

class PaymentController extends Controller
{
    // App\Http\Controllers\Client\PaymentController.php

    public function checkout(Request $request)
    {
        // dd($request);
        $tenant = Auth::guard('web')->user();
        $amount = 0;
        $reference = 'OPL-' . strtoupper(Str::random(5)); // Laravel 12 fix

        if ($request->payment_type === 'all') {
            // Aggregate all unpaid charges
            $amount = RoomCharge::where('rooms_id', $tenant->rooms_id)
                ->where('is_paid', 0)
                ->sum('amount');
            $reference = 'ALL-' . $tenant->id . '-' . date('my');
        } else {
            // Individual charge selection
            $charge = RoomCharge::findOrFail($request->charge_id);
            $amount = $charge->amount;
            $reference = 'INV-' . $charge->id;
        }

        // Link or create the transaction record in the payments table
        $payment = RentPayment::updateOrCreate(
            ['invoice_number' => $reference],
            [
                'tenant_id' => $tenant->id,
                'provider_id' => $tenant->room->provider->id, // Hierarchy [cite: 240, 358]
                'charge_id' => $request->charge_id ?? null,
                'amount' => $amount,
                'status' => 'unpaid',
                'payment_type' => $request->payment_type ?? 'single'
            ]
        );

        $providerId = $tenant->room->provider->id; 
        $bankDetails = ProviderBankDetail::where('providers_id', $providerId)->first();

        return view('clients.payments.checkout', compact('amount', 'reference', 'bankDetails'));
    }

    public function uploadPoP(Request $request)
    {
        $request->validate([
            'pop_file' => 'required|mimes:pdf,jpg,png|max:2048',
        ]);

        $user = Auth::guard('web')->user();

        // If paying "All", we update all unpaid records to 'pending_verification'
        // Otherwise, update the specific record.
        // Logic depends on your preference for record keeping:
        
        $path = $request->file('pop_file')->store('tenant/docs/' . $user->id, 'local');

        // Update records to pending
        RentPayment::where('tenant_id', $user->id)
            ->where('status', 'unpaid')
            ->update([
                'pop_path' => $path,
                'status' => 'pending_verification',
                'uploaded_at' => now()
        ]);

        return redirect()->route('tenant.billings.index')->with('success', 'Your Proof of Payment has been submitted to the owner.');
    }
    
    // App\Http\Controllers\Client\PaymentController.php
    public function processOzow(Request $request, OzowService $ozow)
    {
        dd($request);
        $tenant = Auth::guard('web')->user();
        
        // Logic to calculate amount (same as checkout logic)
        $amount = $request->amount;
            
        $reference = 'OPL' . $tenant->id . time();
        
        
        // Get the specific owner's bank details [cite: 199]
        $providerId = $tenant->room->property->user_id; 
        $bankDetails = ProviderBankDetail::where('provider_id', $providerId)->first();

        $paymentUrl = $ozow->generatePaymentUrl($bankDetails, $amount, $reference);

        return redirect()->away($paymentUrl);
    }

    // App\Http\Controllers\Client\PaymentController.php

    public function processPayfast(Request $request, PayfastService $payfast)
    {
        $tenant = Auth::user();
        
        // 1. Get the aggregate amount and reference (your existing logic)
        $payment = RentPayment::where('tenant_id', $tenant->id)
            ->where('status', 'unpaid')
            ->latest()
            ->first();

        // 2. Get the Provider (Owner) linked to this room
        $provider = $tenant->room->property->user; 

        // 3. Generate the redirect URL
        $paymentUrl = $payfast->generatePaymentUrl($provider, $payment->amount, $payment->invoice_number);

        return redirect()->away($paymentUrl);
    }
}
