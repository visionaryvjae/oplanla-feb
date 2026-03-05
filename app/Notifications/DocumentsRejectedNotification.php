<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking\TenantDocuments;

class DocumentsRejectedNotification extends Notification
{
    use Queueable;

    public $documents;

    /**
     * Create a new notification instance.
     */
    public function __construct(TenantDocuments $documents)
    {
        $this->documents = $documents;
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
            ->subject('Your submitted documents have not been verified')
            ->greeting('Greeting!')
            ->line('The property manager has taken a look at your documents and left the following message:')
            ->line($this->documents->comments . '.')
            ->action('View My Documents', url($url))
            ->line('Check your dashboard for more details on how to get listed as a resident.');
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
