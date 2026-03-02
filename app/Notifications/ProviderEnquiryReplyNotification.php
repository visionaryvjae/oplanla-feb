<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProviderEnquiryReplyNotification extends Notification
{
    use Queueable;
    
    public $reply;
    public $enquiry;

    /**
     * Create a new notification instance.
     */
    public function __construct($enquiry, $reply)
    {
        $this->enquiry = $enquiry;
        $this->reply = $reply;
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
        $url = route('provider.enquiry.show', $this->reply->id);
        return (new MailMessage)
            ->subject('New message regarding rental enquiry no.' . $this->enquiry->id)
            ->greeting('New response for: '. $this->enquiry->user->name .'\'s enquiry')
            ->line('**Message:** ' . $this->reply->message)
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
