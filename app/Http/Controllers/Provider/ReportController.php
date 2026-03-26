<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking\Payment as RentPayment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function downloadPaymentReport(Request $request)
    {
        $providerId = Auth::guard('provider')->user()->provider->id;
        
        $query = RentPayment::with(['tenant', 'tenant.room'])
            ->where('provider_id', $providerId)
            ->where('status', 'paid');

        // Filter by Tenant if provided
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        // Filter by Month/Year if provided
        if ($request->filled('month')) {
            $query->whereMonth('verified_at', $request->month)
                  ->whereYear('verified_at', $request->year ?? now()->year);
        }

        $payments = $query->latest('verified_at')->get();
        $totalCollected = $payments->sum('amount');

        $data = [
            'title' => 'Payment History Report',
            'date' => now()->format('d M Y'),
            'payments' => $payments,
            'total' => $totalCollected,
            'filter_tenant' => $request->filled('tenant_id') ? User::find($request->tenant_id)->name : 'All Tenants',
        ];
        // dd($data);

        $pdf = Pdf::loadView('pdf.provider.payment-report', $data);
        return $pdf->download('OPLANLA-Payment-Report-'.now()->format('Y-m-d').'.pdf');
    }
}
