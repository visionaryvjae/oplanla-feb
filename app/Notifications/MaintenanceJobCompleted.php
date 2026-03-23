<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking\MaintenanceTicket;

class MaintenanceJobCompleted extends Notification
{
    use Queueable;


    public $ticket;
    /**
     * Create a new notification instance.
     */
    public function __construct(MaintenanceTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Work Complete: ' . $this->ticket->job->title)
            ->line('The maintenance work is now finished.')
            ->line('You can view the completion photo on your dashboard.') // [cite: 161]
            ->action('View Dashboard', url('/dashboard'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'job_title' => $this->ticket->job->title,
            'message' => "Work complete. View the photo on your dashboard.", // [cite: 161]
        ];
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
