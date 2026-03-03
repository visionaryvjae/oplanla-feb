<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking\TenantDocuments;

class UploadDocumentsNotification extends Notification
{
    use Queueable;

    public $docs;
    /**
     * Create a new notification instance.
     */
    public function __construct(TenantDocuments $docs)
    {
        $this->docs = $docs;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('tenant.documents.upload');
        return (new MailMessage)
            ->subject('Document upload promt')
            ->greeting('Greetings: '. $this->docs->tenant->name . '! ')
            ->line('Congratulations!! The property owner would like to move on to the next steps of your rental proposal! Please upload the following documents on your portal to contiue:')
            ->line('• Clear copy of SA ID')
            ->line('• Latest 3 month\'s pay slips')
            ->line('• Latest 3 month\'s bank statement (same bank account as salary payment received  & same as debit order to run from)')
            ->line('• Current proof of residence (not older than 3 month\'s)')
            ->line('• Marriage Certificate (if applying as a joint application)')
            ->line('For Foreign Nationals')
            ->line('')
            ->line('• Clear copy of Passport')
            ->line('• Work permit valid for a minimum of 12 months  post commencement of lease agreement')
             ->line('• Latest 3 month\'s pay slips')
            ->line('• Latest 3 month\'s bank statement (same bank account as salary payment received  & same as debit order to run from)')
            ->line('• Current proof of residence (not older than 3 month\'s)')
            ->line('• Marriage Certificate (if applying as a joint application)')
            ->action('View on your Dashboard', url($url))
            ->line('Check your dashboard for more detail.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
