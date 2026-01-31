<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EdificioController extends Controller
{
    public function index(Request $request)
    {
        $edificios = Edificio::all();
        if ($request->wantsJson()) {
            return $edificios;
        }
        return view('edificios.index', compact('edificios'));
    }

    public function create()
    {
        return view('edificios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'nullable|string|max:50',
        ]);
        $ed = Edificio::create($data);
        if ($request->wantsJson()) return $ed;
        return Redirect::route('edificios.index')->with('success', 'Edificio creado');
    }

    public function show(Request $request, Edificio $edificio)
    {
        if ($request->wantsJson()) return $edificio;
        return view('edificios.show', compact('edificio'));
    }

    public function edit(Edificio $edificio)
    {
        return view('edificios.edit', compact('edificio'));
    }

    public function update(Request $request, Edificio $edificio)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'nullable|string|max:50',
        ]);
        $edificio->update($data);
        if ($request->wantsJson()) return $edificio;
        return Redirect::route('edificios.index')->with('success', 'Edificio actualizado');
    }

    public function destroy(Edificio $edificio)
    {
        $edificio->delete();
        if (request()->wantsJson()) return response('', 204);
        return Redirect::route('edificios.index')->with('success', 'Edificio eliminado');
    }
}
