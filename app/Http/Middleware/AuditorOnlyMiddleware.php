<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuditorOnlyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('usuario_role') !== 'Auditor') {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
