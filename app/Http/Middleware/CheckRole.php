<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Uso en rutas: ->middleware('role:admin') o ->middleware('role:user')
     * Bloquea el acceso si el usuario autenticado no tiene ese rol.
     */
    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->hasRole($role)) {
            abort(403, 'Tu rol no tiene acceso a esta sección.');
        }

        return $next($request);
    }
}
