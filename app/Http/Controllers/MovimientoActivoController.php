<?php

namespace App\Http\Controllers;

use App\Models\MovimientoActivo;
use App\Models\Activo;
use App\Models\UbicacionFisica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MovimientoActivoController extends Controller
{
    public function index()
    {
        $movimientos = MovimientoActivo::with(['activo', 'ubicacionOrigen.area.piso.edificio', 'ubicacionDestino.area.piso.edificio'])
            ->orderBy('fecha_movimiento', 'desc')
            ->paginate(20);
        return view('movimientos.index', compact('movimientos'));
    }

    public function create(Request $request)
    {
        $activos = Activo::with('ubicacion')->get();
        $ubicaciones = UbicacionFisica::with('area.piso.edificio')->get();
        $presetActivo = $request->query('activo');
        return view('movimientos.create', compact('activos', 'ubicaciones', 'presetActivo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_activo' => 'required|integer',
            'id_ubicacion_origen' => 'nullable|integer',
            'id_ubicacion_destino' => 'required|integer',
            'fecha_movimiento' => 'required|date',
            'motivo' => 'nullable|string',
        ]);

        // if origin missing, try to use activo current location
        if (empty($data['id_ubicacion_origen'])) {
            $activo = Activo::find($data['id_activo']);
            $data['id_ubicacion_origen'] = $activo ? $activo->id_ubicacion_actual : null;
        }

        $mov = MovimientoActivo::create($data);

        // update activo current location to destination
        if ($mov && $data['id_ubicacion_destino']) {
            $activo = Activo::find($data['id_activo']);
            if ($activo) {
                $activo->id_ubicacion_actual = $data['id_ubicacion_destino'];
                $activo->save();
            }
        }

        return Redirect::route('movimientos.index')->with('success', 'Movimiento creado');
    }

    public function show(MovimientoActivo $movimiento)
    {
        return view('movimientos.show', compact('movimiento'));
    }

    public function edit(MovimientoActivo $movimiento)
    {
        $activos = Activo::with('ubicacion')->get();
        $ubicaciones = UbicacionFisica::with('area.piso.edificio')->get();
        return view('movimientos.edit', compact('movimiento', 'activos', 'ubicaciones'));
    }

    public function update(Request $request, MovimientoActivo $movimiento)
    {
        $data = $request->validate([
            'id_activo' => 'required|integer',
            'id_ubicacion_origen' => 'nullable|integer',
            'id_ubicacion_destino' => 'required|integer',
            'fecha_movimiento' => 'required|date',
            'motivo' => 'nullable|string',
        ]);

        $movimiento->update($data);

        // Keep activo current location in sync with movimiento
        $activo = Activo::find($data['id_activo']);
        if ($activo) {
            $activo->id_ubicacion_actual = $data['id_ubicacion_destino'];
            $activo->save();
        }

        return Redirect::route('movimientos.index')->with('success', 'Movimiento actualizado');
    }

    public function destroy(MovimientoActivo $movimiento)
    {
        $movimiento->delete();
        return Redirect::route('movimientos.index')->with('success', 'Movimiento eliminado');
    }
}
