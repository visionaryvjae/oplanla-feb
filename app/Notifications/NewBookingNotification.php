<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification
{
    use Queueable;
    
    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
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
    
    public function toDatabase($notifiable)
    {
        return [
            // Crucial: This determines which tab gets the red dot
            'category' => 'bookings', 
            'enquiry_id' => $this->booking->id,
            'message' => 'New booking made.',
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('room.booking.index.provider', $this->booking->id);
        return (new MailMessage)
            ->line('A new booking has been made for room at:' . $this->booking->bookingRooms->room->provider->provider_name)
            ->action('View Booking', url($url))
            ->line('Thank you for using OPLANLA!');
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
