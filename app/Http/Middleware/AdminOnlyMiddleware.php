<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnlyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('usuario_role') !== 'Admin') {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
