<?php

namespace App\Notifications;

use App\Models\Booking\MaintenanceJob;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceJobSubmitted extends Notification
{
    use Queueable;

    protected $job;

    /**
     * Create a new notification instance.
     */
    public function __construct(MaintenanceJob $job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        // Defaulting to Mail and Database as per roadmap priority [cite: 176]
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = route('provider.maintenance.jobs.show', $this->job->id);
        return (new MailMessage)
            ->subject('New Maintenance Request')
            ->greeting('Hello Property Manager,')
            ->line("A new maintenance request has been received for Room: {$this->job->room->room_number}.") //[cite: 154]
            ->line("Issue: {$this->job->title}")
            ->action('Review and Assign Technician', $url) //[cite: 154]
            ->line('Please assign a technician to begin the verification loop.'); //[cite: 137]
    }

    public function toArray($notifiable)
    {
        return [
            'job_id' => $this->job->id,
            'title' => $this->job->title,
            'message' => "New maintenance request received for Room {$this->job->room->room_number}.", //[cite: 154]
        ];
    }
}
