<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GmailServices
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $access_token;

    public function __construct()
    {
        $this->client_id = env('GMAIL_CLIENT_ID');
        $this->client_secret = env('GMAIL_CLIENT_SECRET');
        $this->redirect_uri = env('GMAIL_REDIRECT_URI');
        $this->access_token = env('GMAIL_ACCESS_TOKEN');
    }

    public function sendEmail($to, $subject, $body)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->access_token,
            'Content-Type' => 'application/json',
        ];

        $message = "To: $to\r\n";
        $message .= "Subject: " . mb_encode_mimeheader($subject, "UTF-8", "Q") . "\r\n";
        $message .= "MIME-Version: 1.0\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message .= $body;

        $raw = base64_encode($message);

        $response = Http::withHeaders($headers)->post('https://www.googleapis.com/gmail/v1/users/me/messages/send',  [
            'raw' => $raw
        ]);

        return $response->successful();
    }
}