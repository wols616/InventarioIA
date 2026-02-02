<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('username', $data['username'])->where('estado', true)->with('persona.rol')->first();

        if (!$usuario || !Hash::check($data['password'], $usuario->password_hash)) {
            return back()->withErrors(['username' => 'Credenciales inválidas'])->withInput();
        }

        $request->session()->put('usuario_id', $usuario->id_usuario);
        $request->session()->put('usuario_role', $usuario->persona->rol->nombre ?? null);

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['usuario_id', 'usuario_role']);
        return redirect()->route('login');
    }
}
