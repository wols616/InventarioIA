@extends('layouts.app')

@section('content')
    <h1>Categoria: {{ $categoria->nombre }}</h1>

    <p><strong>ID:</strong> {{ $categoria->id_categoria }}</p>
    <p><strong>Descripción:</strong> {{ $categoria->descripcion }}</p>

    <a href="{{ route('categorias.index') }}">Volver</a>
@endsection
