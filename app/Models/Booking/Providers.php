<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Providers extends Model
{
    /** @use HasFactory<\Database\Factories\ProvidersFactory> */
    use HasFactory;
    // use SoftDeletes;

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    protected $fillable = [
        'provider_name',
        'booking_address',
        'description',
        'provider_facilities'
    ];

    // A Provider can have many Rooms
    public function rooms()
    {
        return $this->hasMany(Room::class, 'providers_id'); // 'providers_id' is the foreign key in Rooms table
    }

    public function users()
    {
        return $this->hasMany(ProviderUser::class, 'provider_id');
    }
    
    public function review()
    {
        return $this->hasMany(Review::class, 'providers_id');
    }
    
    public function contacts()
    {
        return $this->hasOne(ProviderContacts::class, 'providers_id');
    }

    public function  technicians()
    {
        return $this->hasMany(MaintenanceUser::class, 'providers_id');
    }
}
