<?php

namespace App\Services;

class PayfastService
{
    public function generatePaymentUrl($provider, $amount, $reference)
    {
        // Payfast Base URL (Use 'sandbox.payfast.co.za' for testing)
        $baseUrl = config('services.payfast.env') === 'production' 
            ? 'https://www.payfast.co.za/eng/process' 
            : 'https://sandbox.payfast.co.za/eng/process';

        $data = [
            // Provider's specific credentials
            'merchant_id'   => $provider->bankDetails->payfast_merchant_id,
            'merchant_key'  => $provider->bankDetails->payfast_merchant_key,
            
            // Return URLs
            'return_url'    => route('tenant.billings.index'),
            'cancel_url'    => route('tenant.billings.index'),
            'notify_url'    => route('api.payfast.itn'), // The webhook

            // Transaction Details
            'm_payment_id'  => $reference, 
            'amount'        => number_format($amount, 2, '.', ''),
            'item_name'     => 'OPLANLA - Property Payment',
        ];

        // Generate Security Signature
        $passphrase = $provider->bankDetails->payfast_passphrase;
        $data['signature'] = $this->generateSignature($data, $passphrase);

        return $baseUrl . '?' . http_build_query($data);
    }

    private function generateSignature($data, $passphrase = null)
    {
        $queryString = http_build_query($data);
        if ($passphrase) {
            $queryString .= '&passphrase=' . urlencode($passphrase);
        }
        return md5($queryString);
    }
}