@extends('layouts.app')

@section('content')
    <h1>Persona #{{ $persona->id_persona }}</h1>

    <ul>
        <li>Nombre: {{ $persona->nombre }} {{ $persona->apellido }}</li>
        <li>DUI: {{ $persona->dui ?? '-' }}</li>
        <li>Correo: {{ $persona->correo ?? '-' }}</li>
        <li>Rol: {{ $persona->rol ? $persona->rol->nombre : '-' }}</li>
        <li>Departamento: {{ $persona->departamento ? $persona->departamento->nombre : '-' }}</li>
        <li>Estado: {{ isset($persona->estado) ? ($persona->estado ? 'Activo' : 'Inactivo') : '-' }}</li>
    </ul>

    <p>
        <a href="{{ route('personas.edit', $persona) }}">Editar</a>
        <a href="{{ route('personas.index') }}">Volver</a>
    </p>

@endsection
