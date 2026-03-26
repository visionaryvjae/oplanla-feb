<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\GeneralBulkNotice;
use Illuminate\Support\Facades\Notification;

class SendBulkNotification implements ShouldQueue
{
    use Queueable;

    protected $tenantIds;
    protected $messageData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $tenantIds, string $messageData)
    {
        $this->tenantIds = $tenantIds;
        $this->messageData = $messageData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        $tenants = User::whereIn('id', $this->tenantIds)->get();
        
        // Using Notification::send for efficient batching
        Notification::send($tenants, new GeneralBulkNotice($this->messageData));
    }
}
