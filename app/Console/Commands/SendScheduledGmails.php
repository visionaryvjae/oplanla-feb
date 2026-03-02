<?php

namespace App\Console\Commands;

use App\Models\ScheduledEmail;
use Illuminate\Console\Command;
use App\Services\GmailServices;

class SendScheduledGmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-scheduled-gmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all scheduled emails using Gmail API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $emails = ScheduledEmail::where('send_at', '<=', $now)->where('sent', false)->get();

        foreach ($emails as $email) {
            $gmail = new GmailServices();

            if ($gmail->sendEmail($email->to, $email->subject, $email->body)) {
                $email->update(['sent' => true]);
                $this->info("Sent email to {$email->to}");
            } else {
                $this->error("Failed to send email to {$email->to}");
            }
        }
    }
}
