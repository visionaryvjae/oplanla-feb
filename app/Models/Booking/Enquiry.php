<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Enquiry extends Model
{
    protected $fillable = [
        'users_id',
        'rooms_id',
        'message'
    ];
    
    
    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    
    public function replies()
    {
        return $this->hasMany(EnquiryReply::class, 'enquiry_id')->orderBy('created_at','asc');
    }
}
