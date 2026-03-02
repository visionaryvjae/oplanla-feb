<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking\Maintenanceuser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MaintenanceUserController extends Controller
{
    public function index(Request $request)
    {
        $providerId = Auth::guard('provider')->user()->provider->id;
        // dd($providerId);
        $query = MaintenanceUser::query();
        
        $query->where('providers_id', $providerId);
        
        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->where('name', 'like', $search)
            ->orWhere('email', 'like', $search);
        }

        if($request->filled('specialty')){
            $query->where('specialty', $request->specialty);
        }
        
        $users = $query->latest()->paginate(10);
        return view('providers.maintenance_users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.maintenance_users.form', [
            'action' => 'Create',
            'user' => new MaintenanceUser(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.MaintenanceUser::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specialty' => ['required','string', ],
        ]);

        $providerId = Auth::guard('provider')->user()->provider->id;

        $user = MaintenanceUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'specialty' => $request->specialty,
            'providers_id' => $providerId,
        ]);

        // dd($user);

        return redirect()->route('provider.maintenance-users.index')->with('success', 'Provider user created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $userId)
    {
        $user = MaintenanceUser::findOrFail($userId);
        // dd($userId);
        return view('providers.maintenance_users.form', [
            'action' => 'Edit',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $userId)
    {
        // dd($request);
        $user = MaintenanceUser::findOrFail($userId);
        // dd($userId);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.MaintenanceUser::class.',email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'specialty' => ['required','string' ],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->specialty = $request->specialty;
        $user->providers_id = Auth::guard('provider')->user()->provider->id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('provider.maintenance-users.index')->with('success', 'Technician user updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceUser $user)
    {
        $user->softDelete();
        return redirect()->route('provider.maintenance-users.index')->with('success', 'Technician user deleted successfully.');
    }
}
