<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking\Meter;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $room = $user->room;

        // 1. Calculate the Projected End Date
        $startDate = $user->tenant->stay_start;
        $stayLengthMonths = $user->tenant->stay_length ?? 12; // Default to 12 if empty
        $expectedEndDate = $startDate->copy()->addMonths($stayLengthMonths);

        // 2. Time Calculations
        $daysStayed = $startDate->diffInDays(now());
        $totalContractDays = $startDate->diffInDays($expectedEndDate);
        
        // Ensure we don't divide by zero and cap at 100%
        $leaseProgress = $totalContractDays > 0 
            ? min(100, round(($daysStayed / $totalContractDays) * 100)) 
            : 0;

        $daysRemaining = now()->diffInDays($expectedEndDate, false);
        

        return view('clients.dashboard', [
            'daysStayed' => $daysStayed,
            'daysRemaining' => max(0, $daysRemaining), // Don't show negative days
            'leaseProgress' => $leaseProgress,
            'expectedEndDate' => $expectedEndDate,
            'stayLength' => $stayLengthMonths,
            'waterUsage' => $room->meters()->where('type', 'water')->first()->lastReading->consumption ?? 0,
            'powerUsage' => $room->meters()->where('type', 'water')->first()->lastReading->consumption ?? 0,
            'recentJobs' => $room->maintenanceJobs()->latest()->take(3)->get(),
            'balance' => $room->totalCharges(),
            // ... rest of your utility/billing variables
        ]);
    }
}
