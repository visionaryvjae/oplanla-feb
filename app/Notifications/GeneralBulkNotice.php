<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralBulkNotice extends Notification
{
    use Queueable;

    protected $messageContent;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $messageContent)
    {
        $this->messageContent = $messageContent;
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
    public function toMail($notifiable): MailMessage
    {
        $url = route('dashboard');
        return (new MailMessage)
            ->subject('Important Property Announcement')
            ->greeting('Hello ' . ($notifiable->name ?? 'Valued Tenant') . ',')
            ->line('Your property provider has sent a new announcement regarding your residence:')
            ->line($this->messageContent)
            ->action('View Details on Dashboard', $url)
            ->salutation('Regards, The OPLANLA Team')
            // Note: Customizing the mail theme colors usually happens in the 
            // vendor:publish-ed mail templates or via a custom theme.
            ->level('info'); 
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'type' => 'bulk_notice',
            'title' => 'New Property Announcement',
            'message' => $this->messageContent,
            'action_url' => route('dashboard'),
            'color_hex' => '#ad68e4', // OPLANLA Purple
        ];
    }
}
