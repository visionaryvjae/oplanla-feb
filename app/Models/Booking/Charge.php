<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable =[
        'rooms_id',
        'description',
        'amount',
        'type',
        'due_date',
        'is_paid',
        'reading_id'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }

    public function reading()
    {
        return $this->belongsTo(MeterReading::class, 'reading_id');
    }
}
