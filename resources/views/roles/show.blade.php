@extends('layouts.app')

@section('content')
    <h1>Rol: {{ $role->nombre }}</h1>

    <p><strong>ID:</strong> {{ $role->id_rol }}</p>
    <p><strong>Descripción:</strong> {{ $role->descripcion }}</p>

    <p><strong>Estado:</strong> {{ $role->estado ? 'Activo' : 'Inactivo' }}</p>

    <a href="{{ route('roles.index') }}">Volver</a>
@endsection
