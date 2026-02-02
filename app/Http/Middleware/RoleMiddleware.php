<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $role = $request->session()->get('usuario_role');

        if (!$role) {
            return redirect()->route('login');
        }

        if (!in_array($role, $roles)) {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
