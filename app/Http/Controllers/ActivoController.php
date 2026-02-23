<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Edificio;
use App\Models\Area;
use App\Models\UbicacionFisica;

class ActivoController extends Controller
{
    public function index()
    {
        $query = Activo::with(['tipo', 'estado', 'ubicacion.area.piso.edificio'])->orderBy('id_activo', 'desc');

        // filters
        if(request()->filled('codigo')){
            $query->where('codigo', 'ilike', '%'.request('codigo').'%');
        }
        if(request()->filled('marca')){
            $query->where('marca', 'ilike', '%'.request('marca').'%');
        }
        if(request()->filled('modelo')){
            $query->where('modelo', 'ilike', '%'.request('modelo').'%');
        }
        if(request()->filled('id_tipo')){
            $query->where('id_tipo', request('id_tipo'));
        }
        if(request()->filled('id_estado')){
            $query->where('id_estado', request('id_estado'));
        }
        if(request()->filled('id_ubicacion_actual')){
            $query->where('id_ubicacion_actual', request('id_ubicacion_actual'));
        }

        // filter by edificio (through ubicacion -> area -> piso)
        if(request()->filled('id_edificio')){
            $edificioId = request('id_edificio');
            $query->whereHas('ubicacion.area.piso', function($q) use ($edificioId){
                $q->where('id_edificio', $edificioId);
            });
        }

        // by default exclude estado 9 (Eliminado) unless include_deleted param set
        if(!request()->boolean('include_deleted')){
            $query->where('id_estado', '!=', 9);
        }

        $activos = $query->paginate(15)->appends(request()->all());

        // provide lists for filter selects
        $tipos = \App\Models\TipoActivo::orderBy('nombre')->get();
        $estados = \App\Models\EstadoActivo::orderBy('nombre')->get();
        $ubicaciones = \App\Models\UbicacionFisica::with('area.piso')->orderBy('nombre')->get();
        $edificios = Edificio::orderBy('nombre')->get();

        return view('activos.index', compact('activos','tipos','estados','ubicaciones','edificios'));
    }

    public function create()
    {
        $tipos = \App\Models\TipoActivo::all();
        $estados = \App\Models\EstadoActivo::all();
        $ubicaciones = \App\Models\UbicacionFisica::with('area')->get();
        $edificios = Edificio::orderBy('nombre')->get();
        $areas = Area::with('piso')->orderBy('nombre')->get();
        return view('activos.create', compact('tipos', 'estados', 'ubicaciones', 'edificios', 'areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_tipo' => 'required|integer',
            'id_estado' => 'required|integer',
            'id_ubicacion_actual' => 'nullable|integer',
            'codigo' => 'required|string|max:50|unique:activos,codigo',
            'codigo_barra' => 'nullable|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'fecha_adquisicion' => 'nullable|date',
            'valor_adquisicion' => 'nullable|numeric',
        ]);

        Activo::create($data);
        return redirect()->route('activos.index')->with('success', 'Activo creado correctamente');
    }

    public function show(Activo $activo)
    {
        return view('activos.show', compact('activo'));
    }

    public function edit(Activo $activo)
    {
        $tipos = \App\Models\TipoActivo::all();
        $estados = \App\Models\EstadoActivo::all();
        $ubicaciones = \App\Models\UbicacionFisica::with('area')->get();
        $edificios = Edificio::orderBy('nombre')->get();
        $areas = Area::with('piso')->orderBy('nombre')->get();
        return view('activos.edit', compact('activo', 'tipos', 'estados', 'ubicaciones', 'edificios', 'areas'));
    }

    public function update(Request $request, Activo $activo)
    {
        $data = $request->validate([
            'id_tipo' => 'required|integer',
            'id_estado' => 'required|integer',
            'id_ubicacion_actual' => 'nullable|integer',
            'codigo' => 'required|string|max:50|unique:activos,codigo,' . $activo->id_activo . ',id_activo',
            'codigo_barra' => 'nullable|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'fecha_adquisicion' => 'nullable|date',
            'valor_adquisicion' => 'nullable|numeric',
        ]);

        $oldEstado = $activo->id_estado;
        // if estado changed, record historial
        if(isset($data['id_estado']) && $data['id_estado'] != $oldEstado){
            HistorialEstado::create([
                'id_activo' => $activo->id_activo,
                'id_estado_anterior' => $oldEstado,
                'id_estado_nuevo' => $data['id_estado'],
                'fecha_cambio' => Carbon::now()->format('Y-m-d'),
            ]);
        }

        $activo->update($data);
        return redirect()->route('activos.index')->with('success', 'Activo actualizado correctamente');
    }

    public function destroy(Activo $activo)
    {
        $oldEstado = $activo->id_estado;
        if($oldEstado != 9){
            $activo->id_estado = 9; // set to Eliminado
            $activo->save();

            // record historial
            HistorialEstado::create([
                'id_activo' => $activo->id_activo,
                'id_estado_anterior' => $oldEstado,
                'id_estado_nuevo' => 9,
                'fecha_cambio' => Carbon::now()->format('Y-m-d'),
            ]);
        }

        return redirect()->route('activos.index')->with('success', 'Activo marcado como Eliminado');
    }
}
