<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'user_id',
        'provider_id',
        'property_id',
        'room_id',
        'stay_start',
        'stay_end',
    ];

    protected function casts(): array{
        return [
            'stay_start' => 'datetime',
            'stay_end' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
