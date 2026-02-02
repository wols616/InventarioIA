@extends('layouts.app')

@section('content')
    <h1>Categoria: {{ $categoria->nombre }}</h1>

    <p><strong>ID:</strong> {{ $categoria->id_categoria }}</p>
    <p><strong>Descripción:</strong> {{ $categoria->descripcion }}</p>

    <p><strong>Vida útil estimada (meses):</strong> {{ $categoria->vida_util_estimada_meses ?? '-' }}</p>
    <p><strong>Depreciable:</strong> {{ $categoria->depreciable ? 'Sí' : 'No' }}</p>
    <p><strong>Activo:</strong> {{ $categoria->activo ? 'Sí' : 'No' }}</p>

    <a href="{{ route('categorias.index') }}">Volver</a>
@endsection
