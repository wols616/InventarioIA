<?php

namespace App\Http\Controllers;

use App\Models\AsignacionActivo;
use App\Models\Activo;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class AsignacionActivoController extends Controller
{
    public function index(Request $request)
    {
        $query = AsignacionActivo::with(['activo', 'persona']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('activo', function($aq) use ($search) {
                    $aq->where('codigo', 'ilike', "%{$search}%")
                       ->orWhere('marca', 'ilike', "%{$search}%")
                       ->orWhere('modelo', 'ilike', "%{$search}%");
                })->orWhereHas('persona', function($pq) use ($search) {
                    $pq->where('nombre', 'ilike', "%{$search}%")
                       ->orWhere('apellido', 'ilike', "%{$search}%");
                });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado === 'activa' ? true : false);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_asignacion', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_asignacion', '<=', $request->fecha_hasta);
        }

        $asignaciones = $query->orderBy('fecha_asignacion', 'desc')->paginate(20)->withQueryString();
        $filters = $request->only(['search', 'estado', 'fecha_desde', 'fecha_hasta']);
        return view('asignaciones.index', compact('asignaciones', 'filters'));
    }

    public function create()
    {
        // Excluir activos cuyo estado tenga es_operativo = true
        $activos = Activo::whereHas('estado', function($q){
            $q->where('es_operativo', true);
        })->orderBy('codigo')->get();
        $personas = Persona::orderBy('nombre')->get();
        return view('asignaciones.create', compact('activos', 'personas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_activo' => 'required|exists:activos,id_activo',
            'id_persona' => 'required|exists:personas,id_persona',
            'fecha_asignacion' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'es_responsable_principal' => 'sometimes|boolean',
            'estado' => 'sometimes|boolean',
        ]);

        // Verificar que el activo seleccionado sea asignable (estado.es_operativo != true)
        try {
            $activo = Activo::with('estado')->find($data['id_activo']);
        } catch (QueryException $e) {
            Log::error('DB error fetching activo for assignment: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error al acceder a la base de datos. Revisa la conexión.'])->withInput();
        } catch (\Exception $e) {
            Log::error('Error fetching activo: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error inesperado al verificar el activo.'])->withInput();
        }

        // Permitir asignación solo si el estado indica que está operativo
        if($activo && $activo->estado && !$activo->estado->es_operativo){
            return back()->withErrors(['id_activo' => 'El activo seleccionado no está disponible para asignación (estado no operativo).'])->withInput();
        }

        $data['es_responsable_principal'] = $request->boolean('es_responsable_principal');
        $data['estado'] = $request->boolean('estado', true);

        try{
            AsignacionActivo::create($data);
        } catch (QueryException $e) {
            Log::error('DB error creating asignacion: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error al guardar la asignación en la base de datos.'])->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating asignacion: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error inesperado al crear la asignación.'])->withInput();
        }

        return redirect()->route('asignaciones.index')->with('success', 'Asignación creada correctamente');
    }

    public function show(AsignacionActivo $asignacion)
    {
        $asignacion->load(['activo', 'persona']);
        return view('asignaciones.show', compact('asignacion'));
    }

    public function edit(AsignacionActivo $asignacion)
    {
        // Excluir activos cuyo estado tenga es_operativo = true
        $activos = Activo::whereHas('estado', function($q){
            $q->where('es_operativo', true);
        })->orderBy('codigo')->get();
        $personas = Persona::orderBy('nombre')->get();
        return view('asignaciones.edit', compact('asignacion', 'activos', 'personas'));
    }

    public function update(Request $request, AsignacionActivo $asignacion)
    {
        $data = $request->validate([
            'id_activo' => 'required|exists:activos,id_activo',
            'id_persona' => 'required|exists:personas,id_persona',
            'fecha_asignacion' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'es_responsable_principal' => 'sometimes|boolean',
            'estado' => 'sometimes|boolean',
        ]);

        // Verificar que el activo seleccionado sea asignable
        try {
            $activo = Activo::with('estado')->find($data['id_activo']);
        } catch (QueryException $e) {
            Log::error('DB error fetching activo for assignment update: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error al acceder a la base de datos. Revisa la conexión.'])->withInput();
        } catch (\Exception $e) {
            Log::error('Error fetching activo for update: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error inesperado al verificar el activo.'])->withInput();
        }

        // Permitir asignación solo si el estado indica que está operativo
        if($activo && $activo->estado && !$activo->estado->es_operativo){
            return back()->withErrors(['id_activo' => 'El activo seleccionado no está disponible para asignación (estado no operativo).'])->withInput();
        }

        $data['es_responsable_principal'] = $request->boolean('es_responsable_principal');
        $data['estado'] = $request->boolean('estado', true);

        try{
            $asignacion->update($data);
        } catch (QueryException $e) {
            Log::error('DB error updating asignacion: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error al actualizar la asignación en la base de datos.'])->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating asignacion: '.$e->getMessage());
            return back()->withErrors(['general' => 'Error inesperado al actualizar la asignación.'])->withInput();
        }

        return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada');
    }

    public function destroy(AsignacionActivo $asignacion)
    {
        // Marcamos como inactiva en lugar de borrar físicamente
        $asignacion->estado = false;
        $asignacion->save();

        return redirect()->route('asignaciones.index')->with('success', 'Asignación desactivada');
    }
}
