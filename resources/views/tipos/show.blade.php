@extends('layouts.app')

@section('content')
    <h1>Tipo #{{ $tipo->id_tipo }}</h1>

    <ul>
        <li>Nombre: {{ $tipo->nombre }}</li>
        <li>Categoria: {{ $tipo->categoria ? $tipo->categoria->nombre : $tipo->id_categoria }}</li>
        <li>Descripcion: {{ $tipo->descripcion }}</li>
        <li>Requiere serie: {{ $tipo->requiere_serie ? 'Sí' : 'No' }}</li>
        <li>Requiere marca: {{ $tipo->requiere_marca ? 'Sí' : 'No' }}</li>
        <li>Requiere modelo: {{ $tipo->requiere_modelo ? 'Sí' : 'No' }}</li>
        <li>Requiere especificaciones: {{ $tipo->requiere_especificaciones ? 'Sí' : 'No' }}</li>
    </ul>

    <p>
        <a href="{{ route('tipos.edit', $tipo) }}">Editar</a>
        <a href="{{ route('tipos.index') }}">Volver</a>
    </p>
@endsection
