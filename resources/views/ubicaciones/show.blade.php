@extends('layouts.app')

@section('content')
    <h1>Ubicación #{{ $ubicacion->id_ubicacion }}</h1>

    <ul>
        <li>Nombre: {{ $ubicacion->nombre }}</li>
        <li>Código interno: {{ $ubicacion->codigo_interno ?? '-' }}</li>
        <li>Area: {{ $ubicacion->area ? $ubicacion->area->nombre : '-' }}</li>
        <li>Piso: {{ $ubicacion->area && $ubicacion->area->piso ? $ubicacion->area->piso->numero_piso : '-' }}</li>
        <li>Edificio: {{ $ubicacion->area && $ubicacion->area->piso && $ubicacion->area->piso->edificio ? $ubicacion->area->piso->edificio->nombre : '-' }}</li>
        <li>Descripción detallada: {{ $ubicacion->descripcion_detallada ?? '-' }}</li>
        <li>Estado: {{ $ubicacion->estado ? 'Activo' : 'Inactivo' }}</li>
    </ul>

    <p>
        <a href="{{ route('ubicaciones.edit', $ubicacion) }}">Editar</a>
        <a href="{{ route('ubicaciones.index') }}">Volver</a>
    </p>

    <p>
        <a href="{{ route('areas.index') }}">Ver/gestionar Áreas</a>
    </p>

@endsection
