<?php

namespace App\Models\Booking;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'users_id',
        'bookings_id',
        'providers_id',
        'rating',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Get the provider that is being reviewed.
     */
    public function provider()
    {
        return $this->belongsTo(Providers::class, 'providers_id');
    }
}
