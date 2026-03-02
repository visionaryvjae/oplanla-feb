<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class MaintenanceTicket extends Model
{
    protected $fillable = [
        'maintenance_job_id',
        'maintenance_user_id',
        'earliest_started_date',
        'latest_completion_date',
        'completed_at',
        'photo_url',
        'status',
        'completion_photo_path',
    ];

    protected function casts(): array
    {
        return [
            'earliest_start_date' => 'datetime',
            'latest_completion_date' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function job() {
        return $this->belongsTo(MaintenanceJob::class, 'maintenance_job_id');
    }

    public function user() {
        return $this->belongsTo(MaintenanceUser::class, 'maintenance_user_id');
    }
}
