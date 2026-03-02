<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class MaintenanceJob extends Model
{
    protected $fillable = [
        'room_id',
        'category', // Plumbing, Electrical, etc.
        'title',
        'description',
        'photo_url',
        'status'
    ];

    public function room() {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }

    public function ticket() {
        return $this->hasOne(MaintenanceTicket::class);
    }
}
