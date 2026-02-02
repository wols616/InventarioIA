<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthenticateUsuario
{
    public function handle(Request $request, Closure $next)
    {
        $usuarioId = $request->session()->get('usuario_id');
        if (!$usuarioId) {
            return redirect()->route('login');
        }

        $usuario = Usuario::with('persona.rol')->find($usuarioId);
        if (!$usuario) {
            $request->session()->forget(['usuario_id', 'usuario_role']);
            return redirect()->route('login');
        }

        // Share authenticated user with views
        view()->share('authUser', $usuario);

        return $next($request);
    }
}
