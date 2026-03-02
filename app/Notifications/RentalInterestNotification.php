<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking\Room;
use App\Models\Booking\Enquiry;

class RentalInterestNotification extends Notification
{
    use Queueable;

    public $room;
    public $enquiry;

    public function __construct($room, $enquiry)
    {
        // Pass the property and enquiry data to the notification
        $this->room = $room;
        $this->enquiry = $enquiry;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        // Generate a signed or standard URL to the response page
        $responseUrl = route('provider.enquiry.respond', $this->enquiry);
    
        return (new MailMessage)
            ->subject('New Rental Enquiry: ' . $this->room->provider->provider_name . ' ' .$this->room->room_number)
            ->line('A user has sent an enquiry regarding: ' . $this->room->provider->provider_name . '   ' .$this->room->room_number)
            ->line('**Client Message:** ' . $this->enquiry->message)
            ->action('Respond to Client', $responseUrl) // The new button
            ->line('Click the button above to let them know availability.');
    }
}