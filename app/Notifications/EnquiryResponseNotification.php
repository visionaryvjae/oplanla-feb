<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquiryResponseNotification extends Notification
{
    use Queueable;
    
    public $enquiry;
    public $reply;

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
    public function toMail($notifiable): MailMessage
    {
        $url = route('client.enquiry.show', $this->reply->id);
        return (new MailMessage)
            ->subject('New message regarding your rental enquiry')
            ->greeting('Good news!')
            ->line('The property manager or admin has responded to your enquiry.')
            ->line('**Their Message:** ' . $this->reply->message)
            ->action('View My Dashboard', url($url))
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
