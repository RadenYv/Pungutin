<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
  protected function redirectTo(Request $request): ?string
{
    if (! $request->expectsJson()) {

        // ADMIN AREA
        if ($request->is('admin/*') || $request->path() === 'dashboard') {
            session()->flash('error', 'Monggo login dulu!');
            return route('admin.login'); // balik ke admin login
        }

        // USER AREA
        if ($request->is('user/*')) {
            session()->flash('error', 'Monggo login dulu!');
            return route('user.login'); // balik ke user login
        }

        // Fallback (anggap user)
        session()->flash('error', 'Monggo login dulu!');
        return route('user.login');
    }

    return null;
}


}
