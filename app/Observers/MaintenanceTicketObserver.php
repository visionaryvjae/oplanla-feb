<?php

namespace App\Observers;

use App\Models\Booking\MaintenanceTicket;
use App\Notifications\MaintenanceTicketAssigned;
use App\Notifications\MaintenanceJobCompleted;
use Illuminate\Support\Facades\Notification;

class MaintenanceTicketObserver
{
    /**
     * Handle the MaintenanceTicket "created" event.
     */
    public function created(MaintenanceTicket $ticket)
    {
        // Notify the assigned technician [cite: 157]
        $ticket->user->notify(new MaintenanceTicketAssigned($ticket));
    }

    /**
     * Handle the MaintenanceTicket "updated" event.
     * Triggered when the status moves to 'completed'[cite: 160].
     */
    public function updated(MaintenanceTicket $ticket)
    {
        // Check if the status was changed to completed during this update [cite: 160]
        if ($ticket->isDirty('status') && $ticket->status === 'completed') {
            
            // 1. Notify the Provider/Owner [cite: 160]
            $ticket->job->room->provider->users()->first()->notify(new MaintenanceJobCompleted($ticket));

            // 2. Notify the Tenant [cite: 160]
            $ticket->job->room->tenant->notify(new MaintenanceJobCompleted($ticket));
        }
    }

    /**
     * Handle the MaintenanceTicket "deleted" event.
     */
    public function deleted(MaintenanceTicket $maintenanceTicket): void
    {
        //
    }

    /**
     * Handle the MaintenanceTicket "restored" event.
     */
    public function restored(MaintenanceTicket $maintenanceTicket): void
    {
        //
    }

    /**
     * Handle the MaintenanceTicket "force deleted" event.
     */
    public function forceDeleted(MaintenanceTicket $maintenanceTicket): void
    {
        //
    }
}
