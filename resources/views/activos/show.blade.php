@extends('layouts.app')

@section('content')
    <h1>Activo #{{ $activo->id_activo }}</h1>

    <ul>
        <li>Codigo: {{ $activo->codigo }}</li>
        <li>Marca: {{ $activo->marca }}</li>
        <li>Modelo: {{ $activo->modelo }}</li>
        <li>Numero de serie: {{ $activo->numero_serie }}</li>
        <li>Estado: {{ $activo->estado ? $activo->estado->nombre : '-' }}</li>
        <li>Ubicación: 
            @if($activo->ubicacion)
                {{ $activo->ubicacion->nombre }} ({{ $activo->ubicacion->codigo_interno ?? '-' }})
                <div style="font-size:0.9em;color:#444">{{ $activo->ubicacion->area ? $activo->ubicacion->area->nombre : '-' }}
                @if(optional($activo->ubicacion->area)->piso)
                    / Piso {{ optional($activo->ubicacion->area->piso)->numero_piso }}
                @endif
                @if(optional(optional($activo->ubicacion->area)->piso)->edificio)
                    / {{ optional(optional($activo->ubicacion->area)->piso->edificio)->nombre }}
                @endif
                </div>
            @else
                -
            @endif
        </li>
        <li>Fecha adquisicion: {{ optional($activo->fecha_adquisicion)->format('Y-m-d') }}</li>
        <li>Valor adquisicion: {{ $activo->valor_adquisicion }}</li>
    </ul>

    <p>
        <a href="{{ route('activos.edit', $activo) }}">Editar</a>
        <a href="{{ route('activos.index') }}">Volver</a>
    </p>
@endsection
