@extends('layouts.app')

@section('content')
    <h1>Estado #{{ $estado->id_estado }}</h1>

    <ul>
        <li>Nombre: {{ $estado->nombre }}</li>
        <li>Anotación: {{ $estado->anotacion ?? '-' }}</li>
        <li>Operativo: {{ $estado->es_operativo ? 'Sí' : 'No' }}</li>
    </ul>

    <p>
        <a href="{{ route('estados.edit', $estado) }}">Editar</a>
        <a href="{{ route('estados.index') }}">Volver</a>
    </p>

@endsection
