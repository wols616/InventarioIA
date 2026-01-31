@extends('layouts.app')

@section('content')
    <h1>Activo #{{ $activo->id_activo }}</h1>

    <ul>
        <li>Codigo: {{ $activo->codigo }}</li>
        <li>Marca: {{ $activo->marca }}</li>
        <li>Modelo: {{ $activo->modelo }}</li>
        <li>Numero de serie: {{ $activo->numero_serie }}</li>
        <li>Fecha adquisicion: {{ optional($activo->fecha_adquisicion)->format('Y-m-d') }}</li>
        <li>Valor adquisicion: {{ $activo->valor_adquisicion }}</li>
    </ul>

    <p>
        <a href="{{ route('activos.edit', $activo) }}">Editar</a>
        <a href="{{ route('activos.index') }}">Volver</a>
    </p>
@endsection
