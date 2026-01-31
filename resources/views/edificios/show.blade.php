@extends('layouts.app')

@section('content')
    <h1>Edificio #{{ $edificio->id_edificio }}</h1>

    <ul>
        <li>Nombre: {{ $edificio->nombre }}</li>
        <li>Codigo: {{ $edificio->codigo }}</li>
    </ul>

    <p>
        <a href="{{ route('edificios.edit', $edificio) }}">Editar</a>
        <a href="{{ route('edificios.index') }}">Volver</a>
    </p>

@endsection
