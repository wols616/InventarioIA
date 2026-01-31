<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use Illuminate\Http\Request;

class ActivoController extends Controller
{
    public function index()
    {
        $activos = Activo::orderBy('id_activo', 'desc')->paginate(15);
        return view('activos.index', compact('activos'));
    }

    public function create()
    {
        $tipos = \App\Models\TipoActivo::all();
        $estados = \App\Models\EstadoActivo::all();
        $ubicaciones = \App\Models\UbicacionFisica::with('area')->get();
        return view('activos.create', compact('tipos', 'estados', 'ubicaciones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_tipo' => 'required|integer',
            'id_estado' => 'required|integer',
            'id_ubicacion_actual' => 'nullable|integer',
            'codigo' => 'required|string|max:50|unique:activos,codigo',
            'codigo_barra' => 'nullable|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'fecha_adquisicion' => 'nullable|date',
            'valor_adquisicion' => 'nullable|numeric',
        ]);

        Activo::create($data);
        return redirect()->route('activos.index')->with('success', 'Activo creado correctamente');
    }

    public function show(Activo $activo)
    {
        return view('activos.show', compact('activo'));
    }

    public function edit(Activo $activo)
    {
        $tipos = \App\Models\TipoActivo::all();
        $estados = \App\Models\EstadoActivo::all();
        $ubicaciones = \App\Models\UbicacionFisica::with('area')->get();
        return view('activos.edit', compact('activo', 'tipos', 'estados', 'ubicaciones'));
    }

    public function update(Request $request, Activo $activo)
    {
        $data = $request->validate([
            'id_tipo' => 'required|integer',
            'id_estado' => 'required|integer',
            'id_ubicacion_actual' => 'nullable|integer',
            'codigo' => 'required|string|max:50|unique:activos,codigo,' . $activo->id_activo . ',id_activo',
            'codigo_barra' => 'nullable|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'fecha_adquisicion' => 'nullable|date',
            'valor_adquisicion' => 'nullable|numeric',
        ]);

        $activo->update($data);
        return redirect()->route('activos.index')->with('success', 'Activo actualizado correctamente');
    }

    public function destroy(Activo $activo)
    {
        $activo->delete();
        return redirect()->route('activos.index')->with('success', 'Activo eliminado correctamente');
    }
}
