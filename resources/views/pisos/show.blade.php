@extends('layouts.app')

@section('content')
    <h1>Piso #{{ $piso->id_piso }}</h1>

    <ul>
        <li>Edificio: {{ $piso->edificio ? $piso->edificio->nombre : '-' }}</li>
        <li>Numero: {{ $piso->numero_piso }}</li>
    </ul>

    <p>
        <a href="{{ route('pisos.edit', $piso) }}">Editar</a>
        <a href="{{ route('pisos.index') }}">Volver</a>
    </p>

@endsection
