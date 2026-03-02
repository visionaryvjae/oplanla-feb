<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Admin\Admin;

class EnquiryReply extends Model
{
    protected $fillable = [
        'enquiry_id',
        'provider_user_id',
        'user_id',
        'admin_id',
        'message'
    ];
    
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function provider_user() {
        return $this->belongsTo(ProviderUser::class, 'provider_user_id');
    }
    
    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    
    public function enquiry() {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }
}
