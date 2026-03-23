<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\MaintenanceJob;
use App\Models\Booking\MaintenanceTicket;
use App\Models\Booking\MaintenanceUser;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{

    public function index(Request $request)
    {
        $providerId = Auth::guard('provider')->user()->provider->id;

        $query = MaintenanceJob::query();
        $query->whereHas('room.provider', function($q) use($providerId) {
            $q->where('id', $providerId);
        });


        $query->orderBy('status', 'desc');

        $jobs = $query->latest()->paginate(9);
        return view('providers.maintenance.jobs.index', compact('jobs'));
    }

    public function show(int $jobId)
    {
        $job = MaintenanceJob::findOrFail($jobId);
        $technicians = MaintenanceUser::where('providers_id', Auth::guard('provider')->user()->provider->id)->get();
        return view('providers.maintenance.jobs.show', compact('job', 'technicians'));
    }

    public function createTicket(int $jobId)
    {
        $job = MaintenanceJob::findOrFail($jobId);
        $ticket = new MaintenanceTicket();

        $technicians = MaintenanceUser::all();

        return view('provider.maintenance.tickets.form', ['job' => $job, 'ticket' => $ticket, 'users' => $technicians, 'action' => 'Create', 'actionUrl' => route('provider.maintenance.assign', $job->id)]);
    }

    public function assignTicket(Request $request, MaintenanceJob $job)
    {
        // dd($request);
        $job->update(['status' => 'assigned']);

        MaintenanceTicket::create([
            'maintenance_job_id' => $job->id,
            'maintenance_user_id' => $request->maintenance_user_id,
            'earliest_start_date' => $request->input('earliest_start_date'),
            'latest_completion_date' => $request->input('latest_completion_date'),
            'tenant_estimate' => $request->input('tenant_estimate'),
            'started_at' => now(),
            'status' => 'in_progress'
        ]);

        return redirect()->route('provider.maintenance.jobs.index')->with('success', 'Job assigned to maintenance staff.');
    }
}
