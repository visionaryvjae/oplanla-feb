<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProviderPasswordResetController extends Controller
{
    
    public function create(Request $request){
        return view('providers.auth.forgot-password', ['request' => $request]);    
    }
    
    
    public function store(Request $request) {
        $status = Password::broker('provider')->sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
    
    public function edit(Request $request){
        return view('providers.auth.reset-password', ['request' => $request]);    
    }
    
    // 2. Resetting the password
    public function update(Request $request) {
        $status = Password::broker('provider')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
            }
        );
    
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('provider.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
