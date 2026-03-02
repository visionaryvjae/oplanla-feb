<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   

class BookingRooms extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\BookingRoomsFactory> */
    use HasFactory;

    protected $fillable = [
        'rooms_id',
        'bookings_id'
    ];

    public function roomBooking()
    {
        return $this->belongsTo(RoomBooking::class, 'room_booking_id'); // 'room_booking_id' is the foreign key in BookingRooms table
    }

    // Relationship with Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }
}
