<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditoriaInventario;
use App\Models\DetalleAuditoria;
use App\Models\Persona;
use App\Models\Activo;

class AuditoriaInventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditoriaInventario::with('persona');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('persona', function($q) use ($search) {
                $q->where('nombre', 'ilike', "%{$search}%")
                  ->orWhere('apellido', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_auditoria', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_auditoria', '<=', $request->fecha_hasta);
        }

        $auditorias = $query->orderBy('fecha_auditoria', 'desc')->paginate(15)->withQueryString();
        $filters = $request->only(['search', 'fecha_desde', 'fecha_hasta']);
        return view('auditorias.index', compact('auditorias', 'filters'));
    }

    public function create()
    {
        $personas = Persona::orderBy('nombre')->get();
        $activos = Activo::orderBy('codigo')->get();
        return view('auditorias.create', compact('personas','activos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'fecha_auditoria' => 'required|date',
            'id_activo' => 'array',
            'id_activo.*' => 'nullable|exists:activos,id_activo',
            'coincide' => 'array',
            'coincide.*' => 'nullable',
            'anotaciones' => 'array',
            'anotaciones.*' => 'nullable|string',
        ]);

        $auditoria = AuditoriaInventario::create([
            'id_persona' => $data['id_persona'],
            'fecha_auditoria' => $data['fecha_auditoria'],
        ]);

        if(!empty($data['id_activo'])){
            foreach($data['id_activo'] as $i => $id_activo){
                if(!$id_activo) continue;
                DetalleAuditoria::create([
                    'id_auditoria' => $auditoria->id_auditoria,
                    'id_activo' => $id_activo,
                    'coincide_con_sistema' => !empty($data['coincide'][$i]) ? true : false,
                    'anotaciones' => $data['anotaciones'][$i] ?? null,
                ]);
            }
        }

        return redirect()->route('auditorias.index')->with('success','Auditoría creada.');
    }

    public function show(AuditoriaInventario $auditoria)
    {
        $auditoria->load('persona','detalles.activo');
        return view('auditorias.show', compact('auditoria'));
    }

    public function edit(AuditoriaInventario $auditoria)
    {
        $personas = Persona::orderBy('nombre')->get();
        $activos = Activo::orderBy('codigo')->get();
        $auditoria->load('detalles');
        return view('auditorias.edit', compact('auditoria','personas','activos'));
    }

    public function update(Request $request, AuditoriaInventario $auditoria)
    {
        $data = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'fecha_auditoria' => 'required|date',
            'id_activo' => 'array',
            'id_activo.*' => 'nullable|exists:activos,id_activo',
            'coincide' => 'array',
            'coincide.*' => 'nullable',
            'anotaciones' => 'array',
            'anotaciones.*' => 'nullable|string',
        ]);

        $auditoria->update([
            'id_persona' => $data['id_persona'],
            'fecha_auditoria' => $data['fecha_auditoria'],
        ]);

        // replace detalles
        $auditoria->detalles()->delete();
        if(!empty($data['id_activo'])){
            foreach($data['id_activo'] as $i => $id_activo){
                if(!$id_activo) continue;
                DetalleAuditoria::create([
                    'id_auditoria' => $auditoria->id_auditoria,
                    'id_activo' => $id_activo,
                    'coincide_con_sistema' => !empty($data['coincide'][$i]) ? true : false,
                    'anotaciones' => $data['anotaciones'][$i] ?? null,
                ]);
            }
        }

        return redirect()->route('auditorias.index')->with('success','Auditoría actualizada.');
    }

    public function destroy(AuditoriaInventario $auditoria)
    {
        $auditoria->detalles()->delete();
        $auditoria->delete();
        return redirect()->route('auditorias.index')->with('success','Auditoría eliminada.');
    }
}
