<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking\MaintenanceTicket;
use App\Models\Booking\MaintenanceJob;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $maintenanceUser = Auth::user();
        
        // 1. Upcoming: Jobs scheduled for the future or newly assigned
        $upcoming = MaintenanceTicket::where('maintenance_user_id', $maintenanceUser->id)
            ->whereHas('job', function($q){
                $q->where('status', ['assigned', 'scheduled']);
            })
            ->orderBy('latest_completion_date', 'asc')
            ->take(5)->get();

        // 2. Missing Details: Jobs marked 'done' but missing notes, costs, or photos
        $missingDetails = MaintenanceTicket::where('maintenance_user_id', $maintenanceUser->id)
            ->where('status', 'in_progress')
            // ->where(function($query) {
            //     $query->whereNull('completion_notes')
            //         ->orWhereNull('actual_cost');
            // })-
            ->get();

        // 3. Stats
        $stats = [
            'upcoming_count' => $upcoming->count(),
            'completed_this_month' => MaintenanceTicket::where('maintenance_user_id', $maintenanceUser->id)
                ->where('status', 'completed')
                ->where('updated_at', '>=', now()->startOfMonth())
                ->count(),
            'pending_actions' => $missingDetails->count()
        ];

        return view('technicians.dashboard', compact('upcoming', 'missingDetails', 'stats'));
    }
}
