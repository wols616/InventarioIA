<?php

namespace App\Http\Controllers;

use App\Models\TipoActivo;
use Illuminate\Http\Request;

class TipoActivoController extends Controller
{
    public function index()
    {
        $tipos = TipoActivo::all();
        if(request()->wantsJson()){
            return $tipos;
        }
        return view('tipos.index', compact('tipos'));
    }

    public function create()
    {
        $categorias = \App\Models\CategoriaActivo::all();
        return view('tipos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_categoria' => 'required|integer',
            'nombre' => 'required|string|max:100',
        ]);
        $tipo = TipoActivo::create($data);
        if($request->wantsJson()){
            return $tipo;
        }
        return redirect()->route('tipos.index')->with('success','Tipo creado correctamente');
    }

    public function show(TipoActivo $tipo)
    {
        if(request()->wantsJson()){
            return $tipo;
        }
        return view('tipos.show', compact('tipo'));
    }

    public function edit(TipoActivo $tipo)
    {
        $categorias = \App\Models\CategoriaActivo::all();
        return view('tipos.edit', compact('tipo','categorias'));
    }

    public function update(Request $request, TipoActivo $tipo)
    {
        $data = $request->validate([
            'id_categoria' => 'required|integer',
            'nombre' => 'required|string|max:100',
        ]);
        $tipo->update($data);
        if($request->wantsJson()){
            return $tipo;
        }
        return redirect()->route('tipos.index')->with('success','Tipo actualizado correctamente');
    }

    public function destroy(TipoActivo $tipo)
    {
        $tipo->delete();
        if(request()->wantsJson()){
            return response('',204);
        }
        return redirect()->route('tipos.index')->with('success','Tipo eliminado correctamente');
    }
}
