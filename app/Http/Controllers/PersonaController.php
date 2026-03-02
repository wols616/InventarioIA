<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Role;
use App\Models\Departamento;
use App\Models\AsignacionActivo;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        $query = Persona::with('rol', 'departamento');

        if ($request->filled('buscar')) {
            $q = strtolower($request->buscar);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(nombre) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(apellido) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(dui) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(correo) LIKE ?', ["%{$q}%"]);
            });
        }

        if ($request->filled('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('id_rol')) {
            $query->where('id_rol', $request->id_rol);
        }

        if ($request->filled('id_departamento')) {
            $query->where('id_departamento', $request->id_departamento);
        }

        $personas      = $query->get();
        $roles         = Role::all();
        $departamentos = Departamento::all();

        if ($request->wantsJson()) return $personas;

        return view('personas.index', compact('personas', 'roles', 'departamentos'));
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
            'estado' => 'required|boolean',
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
        $persona->estado = 0;
        $persona->save();

        // inactivate active assignments and return activos to inventory
        $asignaciones = AsignacionActivo::where('id_persona', $persona->id_persona)->where('estado', 1)->get();
        foreach($asignaciones as $asig){
            // mark assignment inactive
            $asig->estado = 0;
            // optionally set fecha_fin to today if column exists
            if($asig->fecha_fin === null && property_exists($asig, 'fecha_fin')){
                $asig->fecha_fin = date('Y-m-d');
            }
            $asig->save();

            // add the activo back to inventory (increment by 1)
            $inv = Inventario::where('id_activo', $asig->id_activo)->first();
            if($inv){
                $inv->cantidad = intval($inv->cantidad) + 1;
                $inv->save();
            } else {
                Inventario::create([
                    'id_activo' => $asig->id_activo,
                    'cantidad' => 1,
                    'descripcion' => null,
                    'cantidad_minima' => 0,
                    'cantidad_maxima' => 0,
                ]);
            }
        }

        if (request()->wantsJson()) return response('', 200);
        return Redirect::route('personas.index')->with('success', 'Persona inactivada y asignaciones actualizadas');
    }
}
