<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking\Tenant;

class MakeTenantNotification extends Notification
{
    use Queueable;

    public $tenant;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
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
        $url = route('dashboard');
        return (new MailMessage)
            ->subject('Welcome to ' . $this->tenant->user->room->provider->provider_name . '!')
            ->greeting('Great news!')
            ->line('The property manager has reviewed your documents and happy with how you proceeded through the process and picked you to become the the tenant of room number ' . $this->tenant->user->room->room_number . '!')
            ->action('View Dashboard', url($url))
            ->line('Take a look at your new dashbaord options!');
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
