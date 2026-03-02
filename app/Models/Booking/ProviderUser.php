<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderUser extends Authenticatable  implements MustVerifyEmail
{
    use HasFactory, Notifiable, CanResetPassword;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'provider_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the provider company that this user belongs to.
     */
    public function provider()
    {
        return $this->belongsTo(Providers::class);
    }
    
    public function partnerRequests()
    {
        return $this->hasOne(PartnerRequest::class, 'provider_user_id');
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ProviderResetPasswordNotification($token));
    }
}
