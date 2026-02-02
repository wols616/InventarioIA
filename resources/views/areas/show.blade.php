@extends('layouts.app')

@section('content')
    <h1>Área: {{ $area->nombre }}</h1>

    <p><strong>ID:</strong> {{ $area->id_area }}</p>
    <p><strong>Piso:</strong> {{ $area->piso ? $area->piso->numero_piso : '-' }}</p>
    <p><strong>Edificio:</strong> {{ $area->piso && $area->piso->edificio ? $area->piso->edificio->nombre : '-' }}</p>
    <p><strong>Tipo:</strong> {{ $area->tipo_area }}</p>
    <p><strong>Estado:</strong> {{ $area->estado ? 'Activo' : 'Inactivo' }}</p>

    <p>
        <a href="{{ route('areas.edit', $area) }}">Editar</a>
        <a href="{{ route('areas.index') }}">Volver</a>
    </p>

    <p>
        <a href="{{ route('pisos.index') }}">Gestionar Pisos</a>
        &nbsp;|&nbsp;
        <a href="{{ route('edificios.index') }}">Gestionar Edificios</a>
    </p>
@endsection
