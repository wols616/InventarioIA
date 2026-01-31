<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ver Tipo</title>
</head>
<body>
@extends('layouts.app')

@section('content')
    <h1>Tipo #{{ $tipo->id_tipo }}</h1>

    <ul>
        <li>Nombre: {{ $tipo->nombre }}</li>
        <li>Categoria ID: {{ $tipo->id_categoria }}</li>
        <li>Descripcion: {{ $tipo->descripcion }}</li>
    </ul>

    <p>
        <a href="{{ route('tipos.edit', $tipo) }}">Editar</a>
        <a href="{{ route('tipos.index') }}">Volver</a>
    </p>
@endsection
</body>
</html>
