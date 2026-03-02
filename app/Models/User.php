<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Booking\Avatar;
use App\Models\Booking\Enquiry;
use App\Models\Booking\RoomBooking;
use App\Models\Booking\Room;
use App\Models\Booking\TenantDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Booking\Tenant;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'room_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function avatar(){
        return $this->hasOne(Avatar::class, 'users_id');
    }
    
    public function enquiries(){
        return $this->hasMany(Enquiry::class, 'users_id');
    }
    
    public function bookings(){
        return $this->hasMany(RoomBooking::class, 'users_id');
    }

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function documents()
    {
        return $this->hasOne(TenantDocuments::class, 'users_id');
    }

    public function tenant() 
    {
        return $this->hasOne(Tenant::class, 'user_id');
    }
    

    public function isTenant()
    {
        return $this->role === 'tenant';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
