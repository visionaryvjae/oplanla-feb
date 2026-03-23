<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\MaintenanceTicket;
use App\Models\Booking\MaintenanceUser;
use App\Models\Booking\Property;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $providerId = Auth::guard('provider')->user()->provider->id;
        $query = MaintenanceTicket::query(); 
        $query->whereHas('job.room.provider', function($q) use($providerId){
            $q->where('id', $providerId);
        });

        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->whereHas('job', function($q) use($search) {
                $q->where('title', 'like', $search);
            });
        }

        if($request->filled('completed')){
            $query->where('status', $request->completed);
        }

        if($request->filled('category')){
            $query->whereHas('job', function($q) use($request) {
                $q->where('category', $request->category);
            });
        }

        if($request->filled('property')){
            $query->whereHas('job.room', function($q) use($request) {
                $q->where('property_id', $request->property);
            });
        }

        if($request->filled('tenant')){
            $query->whereHas('job.room.tenant', function($q) use($request) {
                $q->where('id', $request->tenant);
            });
        }

        

        // Categories
        $categories = ['Plumbing', 'Electrical', 'Structural', 'Appliances', 'Security', 'Other'];

        //properties Query
        $properties = Property::where('providers_id', $providerId)->get();

        // Tenants Query
        $tenantsQuery = User::query();
        $tenantsQuery->whereHas('room.provider', function($q) use($providerId) {
            $q->where('id', $providerId);
        });



        $tenants = $tenantsQuery->latest()->get();
        $tickets = $query->latest()->paginate(9);
        return view('providers.maintenance.tickets.index', compact('tickets', 'categories', 'properties', 'tenants'));
    }

    public function show(int $ticketId)
    {
        $ticket = MaintenanceTicket::findOrFail($ticketId);
        return view('providers.maintenance.tickets.show', compact('ticket'));
    }
}
