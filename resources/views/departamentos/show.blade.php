@extends('layouts.app')

@section('content')
    <h1>Departamento: {{ $departamento->nombre }}</h1>

    <p><strong>ID:</strong> {{ $departamento->id_departamento }}</p>
    <p><strong>Descripción:</strong> {{ $departamento->descripcion }}</p>

    <p>
        <a href="{{ route('departamentos.index') }}">Volver</a>
        <a href="{{ route('roles.index') }}" style="margin-left:1rem">Gestionar Roles</a>
    </p>
@endsection
