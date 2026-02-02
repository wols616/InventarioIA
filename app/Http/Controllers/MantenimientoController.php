<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Activo;

class MantenimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = Mantenimiento::with('activo')->orderBy('fecha_inicio', 'desc')->paginate(15);
        return view('mantenimientos.index', compact('mantenimientos'));
    }

    public function create()
    {
        $activos = Activo::orderBy('codigo')->get();
        return view('mantenimientos.create', compact('activos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_activo' => 'required|exists:activos,id_activo',
            'tipo_mantenimiento' => 'nullable|string|max:50',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'costo' => 'nullable|numeric',
            'anotacion' => 'nullable|string',
        ]);

        Mantenimiento::create($data);

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento creado.');
    }

    public function show(Mantenimiento $mantenimiento)
    {
        return view('mantenimientos.show', ['mantenimiento' => $mantenimiento]);
    }

    public function edit(Mantenimiento $mantenimiento)
    {
        $activos = Activo::orderBy('codigo')->get();
        return view('mantenimientos.edit', compact('mantenimiento', 'activos'));
    }

    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $data = $request->validate([
            'id_activo' => 'required|exists:activos,id_activo',
            'tipo_mantenimiento' => 'nullable|string|max:50',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'costo' => 'nullable|numeric',
            'anotacion' => 'nullable|string',
        ]);

        $mantenimiento->update($data);

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento actualizado.');
    }

    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->delete();
        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento eliminado.');
    }
}
