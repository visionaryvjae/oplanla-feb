<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    protected $fillable = [
        'rooms_id',
        'providers_id',
        'serial_number',
        'type',
        'multiplier'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }

    public function secondLastReading()
    {
        return $this->hasOne(MeterReading::class)->latest()->get()->skip(1)->first();
    }

    public function lastReading()
    {
        return $this->hasOne(MeterReading::class)->latestOfMany();
    }

    public function provider()
    {
        return $this->belongsTo(Providers::class, 'providers_id');
    }

    public function readings()
    {
        return $this->hasMany(MeterReading::class, 'meter_id');
    }
}
