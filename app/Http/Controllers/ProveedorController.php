<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::all();
        if ($request->wantsJson()) return $proveedores;
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
        ]);
        $p = Proveedor::create($data);
        if ($request->wantsJson()) return $p;
        return Redirect::route('proveedores.index')->with('success', 'Proveedor creado');
    }

    public function show(Request $request, Proveedor $proveedor)
    {
        if ($request->wantsJson()) return $proveedor;
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
        ]);
        $proveedor->update($data);
        if ($request->wantsJson()) return $proveedor;
        return Redirect::route('proveedores.index')->with('success', 'Proveedor actualizado');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        if (request()->wantsJson()) return response('', 204);
        return Redirect::route('proveedores.index')->with('success', 'Proveedor eliminado');
    }
}
