<?php

namespace App\Http\Controllers\Maintenance\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     // Allow guests to access login pages, but logged-in technicians are redirected
    //     $this->middleware('guest:technician')->except('logout');
    // }

    /**
     * Show the technician login form.
     */
    public function showLoginForm()
    {
        return view('technicians.auth.login');
    }

    /**
     * Handle a login request for the technician.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        

        if (Auth::guard('technician')->attempt($credentials, $request->boolean('remember'))) {
            // dd(session()->get('url.intended'));
            $request->session()->regenerate();
            return redirect()->intended(route('technician.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the technician out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('technician')->logout();
        return redirect('/');
    }
}
