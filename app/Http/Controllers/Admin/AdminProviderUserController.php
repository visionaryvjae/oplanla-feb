<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking\ProviderUser;
use App\Models\Booking\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminProviderUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProviderUser::query();
        
        $query->whereNotNull('provider_id');
        
        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->where('name', 'like', $search)
            ->orWhere('email', 'like', $search);
        }
        
        $providerUsers = $query->with('provider')->latest()->paginate(10);
        return view('admin.provider_users.index', compact('providerUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = Providers::all();
        return view('admin.provider_users.form', [
            'action' => 'Create',
            'user' => new ProviderUser(),
            'providers' => $providers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.ProviderUser::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'provider_id' => ['required', 'exists:providers,id'],
        ]);

        ProviderUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'provider_id' => $request->provider_id,
        ]);

        return redirect()->route('admin.provider-users.index')->with('success', 'Provider user created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $userId)
    {
        $user = ProviderUser::findOrFail($userId);
        // dd($userId);
        $providers = Providers::all();
        return view('admin.provider_users.form', [
            'action' => 'Edit',
            'user' => $user,
            'providers' => $providers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $userId)
    {
        $user = ProviderUser::findOrFail($userId);
        // dd($userId);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.ProviderUser::class.',email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'provider_id' => ['required', 'exists:providers,id'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->provider_id = $request->provider_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.provider-users.index')->with('success', 'Provider user updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProviderUser $user)
    {
        $user->softDelete();
        return redirect()->route('admin.provider-users.index')->with('success', 'Provider user deleted successfully.');
    }
}
