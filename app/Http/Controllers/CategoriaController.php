<?php

namespace App\Http\Controllers;

use App\Models\CategoriaActivo as Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'vida_util_estimada_meses' => 'nullable|integer|min:0',
        ]);

        $data['vida_util_estimada_meses'] = $request->input('vida_util_estimada_meses');
        $data['depreciable'] = $request->has('depreciable') ? true : false;
        $data['activo'] = $request->has('activo') ? true : false;

        Categoria::create($data);
        return redirect()->route('categorias.index')->with('success', 'Categoria creada.');
    }

    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'vida_util_estimada_meses' => 'nullable|integer|min:0',
        ]);

        $data['vida_util_estimada_meses'] = $request->input('vida_util_estimada_meses');
        $data['depreciable'] = $request->has('depreciable') ? true : false;
        $data['activo'] = $request->has('activo') ? true : false;

        $categoria->update($data);
        return redirect()->route('categorias.index')->with('success', 'Categoria actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoria eliminada.');
    }
}
