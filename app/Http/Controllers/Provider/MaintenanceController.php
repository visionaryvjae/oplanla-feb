<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\MaintenanceJob;
use App\Models\Booking\MaintenanceTicket;
use App\Models\Booking\MaintenanceUser;

class MaintenanceController extends Controller
{

    public function index()
    {
        $jobs = MaintenanceJob::where('status', 'pending')->get();
        $tickets = MaintenanceTicket::all();   
        return view('providers.maintenance.jobs.index', compact('jobs', 'tickets'));
    }

    public function createTicket(int $jobId)
    {
        $job = MaintenanceJob::findOrFail($jobId);
        $ticket = new MaintenanceTicket();

        $technicians = MaintenanceUser::all();

        return view('providers.maintenance.tickets.form', ['job' => $job, 'ticket' => $ticket, 'users' => $technicians, 'action' => 'Create', 'actionUrl' => route('provider.maintenance.assign', $job->id)]);
    }

    public function assignTicket(Request $request, MaintenanceJob $job)
    {
        $job->update(['status' => 'assigned']);

        MaintenanceTicket::create([
            'maintenance_job_id' => $job->id,
            'maintenance_user_id' => $request->maintenance_user_id,
            'started_at' => now(),
            'status' => 'in_progress'
        ]);

        return redirect()->route('providers.maintenance.index')->with('success', 'Job assigned to maintenance staff.');
    }
}
