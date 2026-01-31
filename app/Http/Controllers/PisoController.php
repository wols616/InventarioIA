<?php

namespace App\Http\Controllers;

use App\Models\Piso;
use App\Models\Edificio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PisoController extends Controller
{
    public function index(Request $request)
    {
        $pisos = Piso::with('edificio')->get();
        if ($request->wantsJson()) return $pisos;
        return view('pisos.index', compact('pisos'));
    }

    public function create()
    {
        $edificios = Edificio::all();
        return view('pisos.create', compact('edificios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_edificio' => 'required|integer',
            'numero_piso' => 'required|integer',
        ]);
        $p = Piso::create($data);
        if ($request->wantsJson()) return $p;
        return Redirect::route('pisos.index')->with('success', 'Piso creado');
    }

    public function show(Request $request, Piso $piso)
    {
        $piso->load('edificio');
        if ($request->wantsJson()) return $piso;
        return view('pisos.show', compact('piso'));
    }

    public function edit(Piso $piso)
    {
        $edificios = Edificio::all();
        return view('pisos.edit', compact('piso', 'edificios'));
    }

    public function update(Request $request, Piso $piso)
    {
        $data = $request->validate([
            'id_edificio' => 'required|integer',
            'numero_piso' => 'required|integer',
        ]);
        $piso->update($data);
        if ($request->wantsJson()) return $piso;
        return Redirect::route('pisos.index')->with('success', 'Piso actualizado');
    }

    public function destroy(Piso $piso)
    {
        $piso->delete();
        if (request()->wantsJson()) return response('', 204);
        return Redirect::route('pisos.index')->with('success', 'Piso eliminado');
    }
}
