@extends('layouts.app')

@section('content')
    <h1>Ubicación #{{ $ubicacion->id_ubicacion }}</h1>

    <ul>
        <li>Nombre: {{ $ubicacion->nombre }}</li>
        <li>Area: {{ $ubicacion->area ? $ubicacion->area->nombre : '-' }}</li>
        <li>Piso: {{ $ubicacion->area && $ubicacion->area->piso ? $ubicacion->area->piso->numero_piso : '-' }}</li>
        <li>Edificio: {{ $ubicacion->area && $ubicacion->area->piso && $ubicacion->area->piso->edificio ? $ubicacion->area->piso->edificio->nombre : '-' }}</li>
    </ul>

    <p>
        <a href="{{ route('ubicaciones.edit', $ubicacion) }}">Editar</a>
        <a href="{{ route('ubicaciones.index') }}">Volver</a>
    </p>

    <p>
        <a href="{{ route('edificios.index') }}">Ver/gestionar Edificios</a>
        &nbsp;|&nbsp;
        <a href="{{ route('pisos.index') }}">Ver/gestionar Pisos</a>
    </p>

@endsection
