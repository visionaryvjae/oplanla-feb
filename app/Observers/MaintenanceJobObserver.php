<?php

namespace App\Observers;

use App\Models\Booking\MaintenanceJob;
use App\Notifications\MaintenanceJobSubmitted;

class MaintenanceJobObserver
{
    /**
     * Handle the MaintenanceJob "created" event.
     */
    public function created(MaintenanceJob $maintenanceJob): void
    {
        // Access the provider through the relationship defined in your hierarchy mapping [cite: 17]
        $provider = $maintenanceJob->room->provider->users()->first();

        if ($provider) {
            $provider->notify(new MaintenanceJobSubmitted($maintenanceJob));
        }
    }

    /**
     * Handle the MaintenanceJob "updated" event.
     */
    public function updated(MaintenanceJob $maintenanceJob): void
    {
        //
    }

    /**
     * Handle the MaintenanceJob "deleted" event.
     */
    public function deleted(MaintenanceJob $maintenanceJob): void
    {
        //
    }

    /**
     * Handle the MaintenanceJob "restored" event.
     */
    public function restored(MaintenanceJob $maintenanceJob): void
    {
        //
    }

    /**
     * Handle the MaintenanceJob "force deleted" event.
     */
    public function forceDeleted(MaintenanceJob $maintenanceJob): void
    {
        //
    }
}
