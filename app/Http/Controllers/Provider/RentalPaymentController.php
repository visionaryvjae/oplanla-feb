<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Payment as RentPayment;
use App\Models\Booking\Charge as RoomCharge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RentalPaymentController extends Controller
{

    public function index(Request $request){
        $providerId = Auth::guard('provider')->user()->provider->id;

        $query = RentPayment::query();
        $query->where('provider_id', $providerId)->orderBy('uploaded_at', 'desc');

        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->whereHas('tenant', function($q) use($search) {
                $q->where('name', 'like', $search);
            })->orWhereHas('tenant.room.property', function($q) use($search) {
                $q->where('name', 'like', $search);
            })->orWhere('invoice_number', 'like', $search);
        }

        // Date Range
        if ($request->filled('date_from')) {
            $query->whereHas('charge', function($q) use($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            });
        }
        if ($request->filled('date_to')) {
            $query->whereHas('charge', function($q) use($request) {
                $q->whereDate('created_at', '=<', $request->date_to);
            });
        }

        // Amount Range
        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }
        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        if($request->filled('type')){
            $query->where('type', $request->type);
        }

        if($request->filled('status')){
            $query->Where('status', $request->status);
        }

        $tenants = User::whereHas('room', function($q) use($providerId) {
            $q->where('providers_id', $providerId);
        })->get();

        // dd($tenants);

        $payments = $query->latest()->paginate(9);
        return view('providers.payments.index', compact('payments', 'tenants'));
    }

    public function show(int $id) 
    {
        $provider = Auth::guard('provider')->user()->provider;
        // Eager load relationships for the audit trail
        $payment = RentPayment::findOrFail($id);
        // dd($payment);

        // Security: Only the owner of this property can view the record
        if ($payment->provider_id !== $provider->id) {
            abort(403, 'Unauthorized accounting access.');
        }

        return view('providers.payments.show', compact('payment'));
    }

    public function view($id)
    {
        $provider = Auth::guard('provider')->user()->provider;
        $payment = RentPayment::with(['tenant', 'charge'])->findOrFail($id);
        
        // Security: Ensure this provider owns the property linked to this payment
        if ($payment->provider_id !== $provider->id) {
            abort(403, 'Unauthorized access to this payment record.');
        }

        return view('providers.payments.view', compact('payment'));
    }

    public function pending()
    {
        $providerId = Auth::guard('provider')->user()->provider->id;

        $pendingPayments = RentPayment::with(['tenant', 'charge'])
            ->where('provider_id', $providerId)
            ->where('status', 'pending_verification')
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return view('providers.payments.pending', compact('pendingPayments'));
    }

    /**
     * Verify the payment and sync the charges table.
     */
    public function verify(Request $request, $id)
    {
        $provider = Auth::guard('provider')->user()->provider;
        $payment = RentPayment::findOrFail($id);

        // Security check: Ensure this provider owns the record
        if ($payment->provider_id !== $provider->id) {
            abort(403);
        }

        DB::transaction(function () use ($payment) {
            // 1. Update the Transaction Ledger
            $payment->update([
                'status' => 'paid',
                'verified_at' => now(),
            ]);

            // 2. Sync the Invoicing Table (Room Charges)
            if ($payment->payment_type === 'all') {
                // Mark all currently unpaid charges for this room as paid
                RoomCharge::where('rooms_id', $payment->tenant->rooms_id)
                    ->where('is_paid', 0)
                    ->update(['is_paid' => 1]);
            } else {
                // Mark the specific linked charge as paid
                RoomCharge::where('id', $payment->charge_id)
                    ->update(['is_paid' => 1]);
            }
        });

        return back()->with('success', 'Payment verified. Invoices have been updated.');
    }

    /**
     * Reject a payment if the PoP is invalid or funds haven't cleared.
     */
    public function reject(Request $request, $id)
    {
        $payment = RentPayment::findOrFail($id);

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason, // Optional: add this column to your migration
        ]);

        // Note: RoomCharge stays 'is_paid = 0', so the tenant still sees the debt.
        return back()->with('error', 'Payment rejected. The tenant has been notified.');
    }

    /**
     * Securely serve the PoP file from the private vault.
     */
    public function viewPoP($id)
    {
        $payment = RentPayment::findOrFail($id);
        
        if (!Storage::disk('local')->exists($payment->pop_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($payment->pop_path);
    }

    public function streamPoP($id) 
    {
        $provider = Auth::guard('provider')->user()->provider;
        $payment = RentPayment::findOrFail($id);
        
        if ($payment->provider_id !== $provider->id) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($payment->pop_path)) {
            abort(404, 'File not found in the vault.');
        }

        // Returns the file with correct headers (PDF or Image)
        return Storage::disk('local')->response($payment->pop_path);
    }
}
