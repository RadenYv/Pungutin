<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {

            // 🟥 USER trying to access ADMIN → CAT MEME
            if (
                auth()->guard('web')->check() &&
                ($request->is('admin/*') || $request->path() === 'dashboard')
            ) {
                abort(401);
            }

            // 🟪 PETUGAS trying to access ADMIN → CAT MEME
            if (
                auth()->guard('petugas')->check() &&
                ($request->is('admin/*') || $request->path() === 'dashboard')
            ) {
                abort(401);
            }

            // 🟦 ADMIN trying to access USER route (optional)
            if (auth()->guard('admin')->check() && $request->is('user/*')) {
                abort(401);
            }

            // 🟩 NOT LOGGED IN — redirect normally
            if ($request->is('admin/*') || $request->path() === 'dashboard') {
                session()->flash('error', 'Monggo login dulu!');
                return route('admin.login');
            }

            if ($request->is('user/*')) {
                session()->flash('error', 'Monggo login dulu!');
                return route('user.login');
            }

            return route('user.login');
        }

        return null;
    }
}
