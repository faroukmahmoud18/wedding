<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // If not admin, redirect to home or a general access denied page
        // Optionally, flash a message to the session
        return redirect()->route('home')->with('error', __('Unauthorized access. You do not have admin privileges.'));
        // Or, for an API or if you prefer aborting:
        // abort(403, 'Unauthorized action.');
    }
}
