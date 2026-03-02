<?php

namespace App\Http\Controllers\Provider\Auth;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        // Allow guests to access login pages, but logged-in providers are redirected
        $this->middleware('guest:provider')->except('logout');
    }

    /**
     * Show the provider login form.
     */
    public function showLoginForm()
    {
        return view('providers.auth.login');
    }

    /**
     * Handle a login request for the provider.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        

        if (Auth::guard('provider')->attempt($credentials, $request->boolean('remember'))) {
            // dd(session()->get('url.intended'));
            $request->session()->regenerate();
            return redirect()->intended(route('provider.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the provider out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('provider')->logout();
        return redirect('/');
    }
}
