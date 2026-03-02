<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    protected $fillable = [
        'meter_id',
        'reading_value',
        'consumption',
        'reading_date',
        'source'
    ];

    public function meter()
    {
        return $this->belongsTo(Meter::class, 'meter_id');
    }

    public function charge()
    {
        return $this->hasOne(Charge::class, 'reading_id');
    }
}
