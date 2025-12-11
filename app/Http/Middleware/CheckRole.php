<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        // If authenticated via specific guard, use it
        // This lets admin guard also read from same users table.
        if (!$user) {
            // Try active guard context
            if (Auth::guard('admin')->check()) {
                $user = Auth::guard('admin')->user();
            } elseif (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();
            }
        }

        if (!$user || ($user->role ?? 'user') !== $role) {
            // Unauthorized: show custom 401 view with image
            return response()->view('Errors.401', [], 401);
        }

        return $next($request);
    }
}
