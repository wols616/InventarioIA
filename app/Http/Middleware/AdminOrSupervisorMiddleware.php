<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrSupervisorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $role = $request->session()->get('usuario_role');
        if (! in_array($role, ['Admin', 'Supervisor'])) {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
