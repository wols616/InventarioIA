<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Role;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        $personas = Persona::all();
        if ($request->wantsJson()) return $personas;
        return view('personas.index', compact('personas'));
    }

    public function create()
    {
        $roles = Role::all();
        $departamentos = Departamento::all();
        return view('personas.create', compact('roles', 'departamentos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_rol' => 'required|integer',
            'id_departamento' => 'required|integer',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dui' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:150',
        ]);
        $p = Persona::create($data);
        if ($request->wantsJson()) return $p;
        return Redirect::route('personas.index')->with('success', 'Persona creada');
    }

    public function show(Request $request, Persona $persona)
    {
        if ($request->wantsJson()) return $persona;
        $persona->load('rol', 'departamento');
        return view('personas.show', compact('persona'));
    }

    public function edit(Persona $persona)
    {
        $roles = Role::all();
        $departamentos = Departamento::all();
        return view('personas.edit', compact('persona', 'roles', 'departamentos'));
    }

    public function update(Request $request, Persona $persona)
    {
        $data = $request->validate([
            'id_rol' => 'required|integer',
            'id_departamento' => 'required|integer',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dui' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:150',
        ]);
        $persona->update($data);
        if ($request->wantsJson()) return $persona;
        return Redirect::route('personas.index')->with('success', 'Persona actualizada');
    }

    public function destroy(Persona $persona)
    {
        $persona->delete();
        if (request()->wantsJson()) return response('', 204);
        return Redirect::route('personas.index')->with('success', 'Persona eliminada');
    }
}
