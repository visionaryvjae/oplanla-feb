<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingRequest extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\BookingRequestFactory> */
    use HasFactory;

    protected $fillable = [
       'bookings_id',
       'users_id',
       'type',
       'message',
       'status', 
    ];

    // Relationship with RoomBooking
    public function booking()
    {
        return $this->belongsTo(RoomBooking::class, 'bookings_id');
    }
}
