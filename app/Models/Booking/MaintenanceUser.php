<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class MaintenanceUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'specialty',
        'providers_id'
    ];
    protected $hidden = [
        'password',
    ];

    public function provider()
    {
        return $this->belongsTo(Providers::class, 'providers_id');
    }

    public function tickets() {
        return $this->hasMany(MaintenanceTicket::class, 'maintenance_user_id');
    }
}
