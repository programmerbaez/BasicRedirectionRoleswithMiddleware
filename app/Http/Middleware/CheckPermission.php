<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Uso en rutas: ->middleware('permission:manage_users')
     * Bloquea el acceso si el usuario no tiene ese permiso asignado en la BD.
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->hasPermission($permission)) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    }
}
