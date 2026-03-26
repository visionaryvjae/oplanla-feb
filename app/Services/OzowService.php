<?php 

namespace App\Services;
use Illuminate\Support\Facades\Http;

class OzowService
{
    // App\Services\OzowService.php

    public function generatePaymentUrl($bankDetails, $amount, $reference)
    {
        $data = [
            'SiteCode' => config('services.ozow.site_code'),
            'CountryCode' => 'ZA',
            'CurrencyCode' => 'ZAR',
            'Amount' => number_format($amount, 2, '.', ''),
            'TransactionReference' => $reference, // Ties back to your invoice_number
            'BankReference' => $reference,
            'CancelUrl' => route('tenant.billings.index'),
            'ErrorUrl' => route('tenant.billings.index'),
            'SuccessUrl' => route('tenant.billings.index'),
            'NotifyUrl' => route('api.ozow.notify'),
            // Settlement to Property Owner
            'BankAccountNumber' => $bankDetails->account_number,
            'BankCode' => $bankDetails->branch_code,
        ];

        $hashString = implode('', $data) . config('services.ozow.private_key');
        $data['HashCheck'] = strtolower(hash('sha512', $hashString));

        return "https://pay.ozow.com/?" . http_build_query($data);
    }
}