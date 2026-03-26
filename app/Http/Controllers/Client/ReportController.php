<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking\Payment as RentPayment;

class ReportController extends Controller
{
    // App\Http\Controllers\Client\ReportController.php
    public function downloadStatement()
    {
        $tenant = auth()->user();
        
        $payments = RentPayment::where('tenant_id', $tenant->id)
            ->where('status', 'paid')
            ->latest()
            ->get();

        $data = [
            'tenant' => $tenant,
            'room' => $tenant->room,
            'payments' => $payments,
            'total_paid' => $payments->sum('amount'),
        ];

        $pdf = Pdf::loadView('pdf.client.room-statement', $data);
        return $pdf->download('My-OPLANLA-Statement.pdf');
    }
}
