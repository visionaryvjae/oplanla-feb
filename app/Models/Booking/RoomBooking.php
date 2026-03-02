<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class RoomBooking extends Model
{
    /** @use HasFactory<\Database\Factories\RoomBookingFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'check_in_time',
        'check_out_time',
        'booking_price',
        'payment_status',
        'transaction_id',
        'users_id'
    ];

    public function bookingRooms()
    {
        return $this->hasOne(BookingRooms::class, 'bookings_id'); // 'room_booking_id' is the foreign key in BookingRooms table
    }
    
    public function requests()
    {
        return $this->hasMany(BookingRequest::class, 'bookings_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
