@extends('layouts.app')

@section('content')
    <h1>Proveedor #{{ $proveedor->id_proveedor }}</h1>

    <ul>
        <li>Nombre: {{ $proveedor->nombre }}</li>
        <li>Contacto: {{ $proveedor->contacto }}</li>
        <li>Descripcion: {{ $proveedor->descripcion }}</li>
    </ul>

    <p>
        <a href="{{ route('proveedores.edit', $proveedor) }}">Editar</a>
        <a href="{{ route('proveedores.index') }}">Volver</a>
    </p>

@endsection
