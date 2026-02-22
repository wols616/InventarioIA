<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Activo;
use App\Models\AsignacionActivo;
use App\Models\MovimientoActivo;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventario::with('activo');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('activo', function($aq) use ($search) {
                    $aq->where('codigo', 'ilike', "%{$search}%")
                       ->orWhere('marca', 'ilike', "%{$search}%")
                       ->orWhere('modelo', 'ilike', "%{$search}%");
                })->orWhere('descripcion', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'bajo') {
                $query->whereColumn('cantidad', '<', 'cantidad_minima')->whereNotNull('cantidad_minima');
            } elseif ($request->stock === 'normal') {
                $query->where(function($q) {
                    $q->whereColumn('cantidad', '>=', 'cantidad_minima')->orWhereNull('cantidad_minima');
                });
            }
        }

        if ($request->filled('activo')) {
            $query->where('id_activo', $request->activo);
        }

        $inventarios = $query->paginate(20)->withQueryString();
        $filters = $request->only(['search', 'stock', 'activo']);
        return view('inventario.index', compact('inventarios', 'filters'));
    }

    public function create()
    {
        $activos = Activo::orderBy('codigo')->get();
        return view('inventario.create', compact('activos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_activo' => 'required|exists:activos,id_activo',
            'cantidad' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'cantidad_minima' => 'nullable|integer|min:0',
            'cantidad_maxima' => 'nullable|integer|min:0',
        ]);

        Inventario::create($data);
        return redirect()->route('inventario.index')->with('success','Item de inventario creado.');
    }

    public function show(Inventario $inventario)
    {
        // Eager load related activo details
        $inventario->load('activo.tipo', 'activo.estado', 'activo.ubicacion.area.piso.edificio');

        // Todas las asignaciones para este activo
        $asignaciones = AsignacionActivo::with('persona')
            ->where('id_activo', $inventario->id_activo)
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        // Movimientos de ubicación para este activo
        $movimientos = MovimientoActivo::with(['ubicacionOrigen.area.piso.edificio', 'ubicacionDestino.area.piso.edificio'])
            ->where('id_activo', $inventario->id_activo)
            ->orderBy('fecha_movimiento', 'desc')
            ->get();

        return view('inventario.show', compact('inventario', 'asignaciones', 'movimientos'));
    }

    public function edit(Inventario $inventario)
    {
        $activos = Activo::orderBy('codigo')->get();
        return view('inventario.edit', compact('inventario','activos'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $data = $request->validate([
            'id_activo' => 'required|exists:activos,id_activo',
            'cantidad' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'cantidad_minima' => 'nullable|integer|min:0',
            'cantidad_maxima' => 'nullable|integer|min:0',
        ]);

        $inventario->update($data);
        return redirect()->route('inventario.index')->with('success','Item de inventario actualizado.');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success','Item de inventario eliminado.');
    }
}
