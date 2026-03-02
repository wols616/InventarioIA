<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\AsignacionActivo;

class ReporteController extends Controller
{
    public function index()
    {
        $personas = Persona::orderBy('nombre')->get();
        return view('reportes.index', compact('personas'));
    }

    public function generar(Request $request)
    {
        $data = $request->validate([
            'persona_id' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $persona = Persona::findOrFail($data['persona_id']);

        $inicio = $data['fecha_inicio'];
        $fin = $data['fecha_fin'];

        $asignaciones = AsignacionActivo::with('activo')
            ->where('id_persona', $persona->id_persona)
            ->where('fecha_asignacion', '<=', $fin)
            ->where(function($q) use ($inicio) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', $inicio);
            })
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        return view('reportes.result', compact('persona','asignaciones','inicio','fin'));
    }

    /**
     * Devuelve una vista lista para impresión (el usuario puede guardar como PDF desde el navegador).
     */
    public function pdf(Request $request)
    {
        $data = $request->validate([
            'persona_id' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $persona = Persona::findOrFail($data['persona_id']);

        $inicio = $data['fecha_inicio'];
        $fin = $data['fecha_fin'];

        $asignaciones = AsignacionActivo::with(['activo','activo.tipo'])
            ->where('id_persona', $persona->id_persona)
            ->where('fecha_asignacion', '<=', $fin)
            ->where(function($q) use ($inicio) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', $inicio);
            })
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        return view('reportes.pdf', compact('persona','asignaciones','inicio','fin'));
    }
}
