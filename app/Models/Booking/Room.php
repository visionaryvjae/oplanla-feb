<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'available',
        'price',
        'num_people',
        'room_type',
        'stay_start_date',
        'stay_end_date',
        'room_number',
        'property_type',
        'room_facilities',
        'providers_id',
        'property_id',
        'rental' => 'boolean',
        'num_beds',
        'num_bathrooms',
        'rental_price',
        'furnishing',
    ];

    // Relationship with Provider
    public function provider()
    {
        return $this->belongsTo(Providers::class, 'providers_id');
    }

    // A Room can have many BookingRooms entries
    public function bookingRooms()
    {
        return $this->belongsTo(BookingRooms::class, 'rooms_id'); // 'rooms_id' is the foreign key in BookingRooms table
    }

    public function facilities()
    {
        return $this->hasMany(RoomFacilities::class, 'rooms_id');
    }

    public function meters()
    {
        return $this->hasMany(Meter::class, 'rooms_id');
    }

    public function electricityMeter()
    {
        return $this->hasOne(Meter::class, 'rooms_id')->where('type', 'electricity');
    }

    public function waterMeter()
    {
        return $this->hasOne(Meter::class, 'rooms_id')->where('type', 'water');
    }

    public function charges()
    {
        return $this->hasMany(Charge::class, 'rooms_id');
    }

    public function totalCharges()
    {
        return $this->charges()->where('is_paid', false)->sum('amount');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'rooms_id');
    }

    public function maintenanceJobs()
    {
        return $this->hasMany(MaintenanceJob::class, 'room_id');
    }

    public function tenant()
    {
        return $this->hasOne(User::class, 'room_id');
    }

}
