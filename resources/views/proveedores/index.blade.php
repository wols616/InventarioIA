@extends('layouts.app')

@section('content')
    <h1>Proveedores</h1>

    <p><a href="{{ route('proveedores.create') }}">Crear proveedor</a></p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $p)
                <tr>
                    <td>{{ $p->id_proveedor }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->contacto }}</td>
                    <td>
                        <a href="{{ route('proveedores.show', $p) }}">Ver</a>
                        <a href="{{ route('proveedores.edit', $p) }}">Editar</a>
                        <form action="{{ route('proveedores.destroy', $p) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
