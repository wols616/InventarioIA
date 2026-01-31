<?php

namespace App\Http\Controllers;

use App\Models\EstadoActivo;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class EstadoActivoController extends Controller
{
    public function index(Request $request)
    {
        $estados = EstadoActivo::all();
        if ($request->wantsJson()) {
            return $estados;
        }
        return view('estados.index', compact('estados'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50',
            'es_operativo' => 'required|boolean',
        ]);
        $estado = EstadoActivo::create($data);
        if ($request->wantsJson()) {
            return $estado;
        }
        return Redirect::route('estados.index')->with('success', 'Estado creado');
    }

    public function show(Request $request, EstadoActivo $estado)
    {
        if ($request->wantsJson()) {
            return $estado;
        }
        return view('estados.show', compact('estado'));
    }

    public function update(Request $request, EstadoActivo $estado)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50',
            'es_operativo' => 'required|boolean',
        ]);
        $estado->update($data);
        if ($request->wantsJson()) {
            return $estado;
        }
        return Redirect::route('estados.index')->with('success', 'Estado actualizado');
    }

    public function destroy(EstadoActivo $estado)
    {
        $estado->delete();
        if (request()->wantsJson()) {
            return response('', 204);
        }
        return Redirect::route('estados.index')->with('success', 'Estado eliminado');
    }

    public function create()
    {
        return view('estados.create');
    }

    public function edit(EstadoActivo $estado)
    {
        return view('estados.edit', compact('estado'));
    }
}
