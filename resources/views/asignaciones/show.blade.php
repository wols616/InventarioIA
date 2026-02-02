@extends('layouts.app')

@section('content')
    <h1>Asignación #{{ $asignacion->id_asignacion }}</h1>

    <p><strong>Activo:</strong> {{ optional($asignacion->activo)->codigo }} {{ optional($asignacion->activo)->marca }} {{ optional($asignacion->activo)->modelo }}</p>
    <p><strong>Persona:</strong> {{ optional($asignacion->persona)->nombre }} {{ optional($asignacion->persona)->apellido }}</p>
    <p><strong>Fecha asignación:</strong> {{ optional($asignacion->fecha_asignacion)->format('Y-m-d') }}</p>
    <p><strong>Fecha fin:</strong> {{ optional($asignacion->fecha_fin)->format('Y-m-d') }}</p>
    <p><strong>Responsable principal:</strong> {{ $asignacion->es_responsable_principal ? 'Sí' : 'No' }}</p>
    <p><strong>Estado:</strong> {{ $asignacion->estado ? 'Activa' : 'Inactiva' }}</p>

    <a href="{{ route('asignaciones.index') }}">Volver</a>
@endsection
