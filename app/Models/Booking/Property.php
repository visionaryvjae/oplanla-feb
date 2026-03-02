<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'name',
        'address',
        'providers_id',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'property_id');
    }

    public function provider()
    {
        return $this->belongsTo(Providers::class, 'providers_id');
    }
}
