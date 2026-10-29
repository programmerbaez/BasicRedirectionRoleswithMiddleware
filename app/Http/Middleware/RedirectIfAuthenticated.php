<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Si un usuario ya autenticado entra a /login o /register,
     * se le envía a su dashboard según su rol.
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(Auth::guard($guard)->user()->dashboardRoute());
        }

        return $next($request);
    }
}
