<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Piso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::with('piso.edificio')->get();
        if ($request->wantsJson()) return $areas;
        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        $pisos = Piso::with('edificio')->get();
        $edificios = \App\Models\Edificio::all();
        return view('areas.create', compact('pisos','edificios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_piso' => 'required|integer',
            'nombre' => 'required|string|max:150',
            'tipo_area' => 'nullable|string|max:50',
            'estado' => 'sometimes|boolean',
        ]);
        $a = Area::create($data);
        if ($request->wantsJson()) return $a;
        return Redirect::route('areas.index')->with('success', 'Area creada');
    }

    public function show(Request $request, Area $area)
    {
        $area->load('piso.edificio');
        if ($request->wantsJson()) return $area;
        return view('areas.show', compact('area'));
    }

    public function edit(Area $area)
    {
        $pisos = Piso::with('edificio')->get();
        $edificios = \App\Models\Edificio::all();
        return view('areas.edit', compact('area','pisos','edificios'));
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->validate([
            'id_piso' => 'required|integer',
            'nombre' => 'required|string|max:150',
            'tipo_area' => 'nullable|string|max:50',
            'estado' => 'sometimes|boolean',
        ]);
        $area->update($data);
        if ($request->wantsJson()) return $area;
        return Redirect::route('areas.index')->with('success', 'Area actualizada');
    }

    public function destroy(Area $area)
    {
        $area->delete();
        if (request()->wantsJson()) return response('',204);
        return Redirect::route('areas.index')->with('success','Area eliminada');
    }
}
