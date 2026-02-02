<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $personas = Persona::with('usuario')->get();
        return view('usuarios.index', compact('personas'));
    }

    public function create($personaId)
    {
        $persona = Persona::findOrFail($personaId);
        $defaultUsername = strtolower(mb_substr($persona->nombre, 0, 1) . $persona->apellido);
        return view('usuarios.create', compact('persona', 'defaultUsername'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona|unique:usuarios,id_persona',
            'username' => 'required|string|max:50|unique:usuarios,username',
            'password' => 'required|string|min:6',
        ]);

        $usuario = Usuario::create([
            'id_persona' => $data['id_persona'],
            'username' => $data['username'],
            'password_hash' => Hash::make($data['password']),
            'estado' => true,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'username' => 'required|string|max:50|unique:usuarios,username,' . $usuario->id_usuario . ',id_usuario',
            'password' => 'nullable|string|min:6',
        ]);

        $usuario->username = $data['username'];
        if (!empty($data['password'])) {
            $usuario->password_hash = Hash::make($data['password']);
        }
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->estado = false;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado correctamente.');
    }
}
