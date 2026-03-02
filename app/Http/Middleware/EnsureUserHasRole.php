<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // dd(Auth::guard('web')->user()->role, $role);
        $userRole = Auth::guard('web')->user()->role;
        if ($userRole !== $role) {
            return redirect('/')->with('error', 'You do not have access to this area.');
        }

        return $next($request);
    }
}
