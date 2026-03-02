<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\MaintenanceJob;
use App\Models\Booking\MaintenanceTicket;

class MaintenanceController extends Controller
{
    public function completeTicket(Request $request, MaintenanceTicket $ticket)
    {
        $ticket->update([
            'completed_at' => now(),
            'price_charged' => $request->price,
            'status' => 'completed'
        ]);

        // Update the parent job
        $ticket->job->update(['status' => 'completed']);

        // Optional: Trigger notification to landlord for payment approval
        return redirect()->route('maintenance.dashboard');
    }
}
