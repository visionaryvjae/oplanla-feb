<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Booking\Avatar;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(): View
    {
        $avatar = Avatar::where('users_id', Auth::id());
        return view('components.user-profile', ['avatar' => $avatar]);
    }
    
     public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    public function update(Request $request) {
        
        if(!Auth::check()){

        }

        $userid = Auth::id();
        $photo = Avatar::where('users_id', $userid)->first();
        if(!$photo){
            $path = $request->file('avatar')->store('avatars','public');
            $pathArray = explode('/', $path);
            $imgPath = $pathArray[1];


            $photo = new Avatar();
            $photo->avatar = $imgPath;
            $photo->users_id = $userid;
            $photo->save();
        }

        if ($request->hasFile('avatar')) {
            // Get the old avatar path
            $oldavatarPath = public_path('avatars/' . $request['avatar']);

            // Delete the old avatar from storage if it exists
            if (file_exists($oldavatarPath)) {
                unlink($oldavatarPath);
            }

            // Store the new avatar
            $newavatar = $request->file('avatar');
            $path = $newavatar->store('avatars', 'public');

            
            $fullPath = Storage::disk('public')->path($path);
            OptimizerChainFactory::create()->optimize($fullPath);


            $imgPath = explode('/', $path)[1];

            $photo->avatar = $imgPath;
            $photo->users_id = $userid;
            $photo->save();
        }

        $profile = User::findOrFail($userid);
        $profile->name = $request->input('name');
        $profile->email = $request->input('email');
        $profile->save();
        return redirect()->route('dashboard')->with('success', 'successfully uploaded avatar');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
