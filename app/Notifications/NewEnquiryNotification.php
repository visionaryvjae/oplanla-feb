<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEnquiryNotification extends Notification
{
    use Queueable;
    
    public $enquiryId;

    /**
     * Create a new notification instance.
     */
    public function __construct($enquiryId)
    {
        $this->enquiryId = $enquiryId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {
        return [
            // Crucial: This determines which tab gets the red dot
            'category' => 'enquiries', 
            'enquiry_id' => $this->enquiryId,
            'message' => 'New enquiry received.',
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
