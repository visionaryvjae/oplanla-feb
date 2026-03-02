<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $providerId = Auth::guard('provider')->user()->provider->id;

        $query = User::query();
        
        $query->whereHas('room.provider', function($query) use($providerId)  {
                $query->where('id', $providerId);
        });

        if($request->filled('search')){
            $search = '%' . $request->search. '%';
            $query->where('name', 'like', $search);
        }

        if($request->filled('room_num')){
            $query->whereHas('room', function($q) use($request) {
                $q->where('room_number', $request->room_num);
            });
        }

        if($request->filled('owing')){
            $query->whereHas('room.charges', function($q) use($request) {
                $q->where('is_paid', $request->owing);
            });
        }

        if($request->filled('start_date')){
            $query->whereHas('tenant', function($q) use($request) {
                $q->where('stay_start', '>=', $request->start_date);
            });
        }

        if($request->filled('end_date')){
            $query->whereHas('tenant', function($q) use($request) {
                $q->where('stay_start', '<=', $request->end_date);
            });
        }

        // dd($tenants->latest()->get());
        $tenants = $query->latest()->paginate(10);

        return view('providers.tenants.index', compact('tenants'));
    }

    public function show(int $tenantId) 
    {
        $tenant = User::findOrFail($tenantId);

        return view('providers.tenants.show', compact('tenant'));
    }
}
