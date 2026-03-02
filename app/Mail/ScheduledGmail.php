<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledGmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct($data)
    {
        $this->emailData = $data;
    }

    public function build()
    {
        return $this->from($this->emailData['from'] ?? config('mail.from.address'))
                    ->subject($this->emailData['subject'])
                    ->text($this->emailData['body']); // or ->view() for HTML templates
    }
}