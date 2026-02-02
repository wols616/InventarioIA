<?php

namespace App\Http\Controllers;

use App\Models\UbicacionFisica;
use Illuminate\Http\Request;
use App\Models\Area;
use Illuminate\Support\Facades\Redirect;

class UbicacionFisicaController extends Controller
{
    public function index(Request $request)
    {
        $ubicaciones = UbicacionFisica::with('area')->get();
        if ($request->wantsJson()) {
            return $ubicaciones;
        }
        return view('ubicaciones.index', compact('ubicaciones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_area' => 'required|integer',
            'nombre' => 'nullable|string|max:100',
            'codigo_interno' => 'nullable|string|max:50',
            'descripcion_detallada' => 'nullable|string',
            'estado' => 'nullable|boolean',
        ]);
        $data['estado'] = $request->boolean('estado');
        $ubic = UbicacionFisica::create($data);
        if ($request->wantsJson()) {
            return $ubic;
        }
        return Redirect::route('ubicaciones.index')->with('success', 'Ubicación creada');
    }

    public function show(Request $request, UbicacionFisica $ubicacion)
    {
        $ubicacion->load('area');
        if ($request->wantsJson()) {
            return $ubicacion;
        }
        return view('ubicaciones.show', compact('ubicacion'));
    }

    public function update(Request $request, UbicacionFisica $ubicacion)
    {
        $data = $request->validate([
            'id_area' => 'required|integer',
            'nombre' => 'nullable|string|max:100',
            'codigo_interno' => 'nullable|string|max:50',
            'descripcion_detallada' => 'nullable|string',
            'estado' => 'nullable|boolean',
        ]);
        $data['estado'] = $request->boolean('estado');
        $ubicacion->update($data);
        if ($request->wantsJson()) {
            return $ubicacion;
        }
        return Redirect::route('ubicaciones.index')->with('success', 'Ubicación actualizada');
    }

    public function destroy(UbicacionFisica $ubicacion)
    {
        $ubicacion->delete();
        if (request()->wantsJson()) {
            return response('', 204);
        }
        return Redirect::route('ubicaciones.index')->with('success', 'Ubicación eliminada');
    }

    public function create()
    {
        $areas = Area::with('piso.edificio')->get();
        return view('ubicaciones.create', compact('areas'));
    }

    public function edit(UbicacionFisica $ubicacion)
    {
        $areas = Area::with('piso.edificio')->get();
        $ubicacion->load('area.piso.edificio');
        return view('ubicaciones.edit', compact('ubicacion', 'areas'));
    }
}
