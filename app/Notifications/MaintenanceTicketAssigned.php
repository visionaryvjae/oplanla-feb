<?php

namespace App\Notifications;

use App\Models\Booking\MaintenanceTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceTicketAssigned extends Notification
{
    use Queueable;

    protected $ticket;

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
        $url = route('technician.tickets.show', $this->ticket->id);
        return (new MailMessage)
            ->subject('New Maintenance Ticket Assigned')
            ->line("New ticket assigned: {$this->ticket->job->title}.") //[cite: 158]
            ->line("Deadline for completion: " . $this->ticket->latest_completion_date->format('d M Y')) //[cite: 158]
            ->action('View Ticket Details', $url)
            ->line('Remember to upload photographic evidence to complete the job.'); //[cite: 137, 145]
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'job_title' => $this->ticket->job->title,
            'deadline' => $this->ticket->latest_completion_date->toDateTimeString(), //[cite: 158]
            'message' => "New ticket assigned: {$this->ticket->job->title}. Check your dashboard for details.", //[cite: 158]
        ];
    }
}
