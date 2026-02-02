@extends('layouts.app')

@section('content')
    <h1>Mantenimiento #{{ $mantenimiento->id_mantenimiento ?? $mantenimiento->id }}</h1>

    <p><strong>Activo:</strong> {{ $mantenimiento->activo ? ($mantenimiento->activo->codigo . ' - ' . trim(($mantenimiento->activo->marca ?? '') . ' ' . ($mantenimiento->activo->modelo ?? ''))) : '' }}</p>
    <p><strong>Tipo:</strong> {{ $mantenimiento->tipo_mantenimiento }}</p>
    <p><strong>Fecha inicio:</strong> {{ $mantenimiento->fecha_inicio ? \Carbon\Carbon::parse($mantenimiento->fecha_inicio)->format('Y-m-d') : '' }}</p>
    <p><strong>Fecha fin:</strong> {{ $mantenimiento->fecha_fin ? \Carbon\Carbon::parse($mantenimiento->fecha_fin)->format('Y-m-d') : '' }}</p>
    <p><strong>Costo:</strong> {{ $mantenimiento->costo }}</p>
    <p><strong>Anotacion:</strong> {{ $mantenimiento->anotacion }}</p>

    <a href="{{ route('mantenimientos.index') }}">Volver</a>
@endsection
