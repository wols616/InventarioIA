@extends('layouts.app')

@section('content')
    <h1>Tipos de Activos</h1>

    <p>
        <a href="{{ route('tipos.create') }}">Crear tipo</a>
        <a href="{{ route('categorias.index') }}" style="margin-left:1rem">Gestionar Categorías</a>
    </p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Requiere serie</th>
                <th>Requiere marca</th>
                <th>Requiere modelo</th>
                <th>Requiere especificaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->id_tipo }}</td>
                    <td>{{ $tipo->categoria ? $tipo->categoria->nombre : '-' }}</td>
                    <td>{{ $tipo->nombre }}</td>
                    <td>{{ $tipo->descripcion }}</td>
                    <td>{{ $tipo->requiere_serie ? 'S' : 'N' }}</td>
                    <td>{{ $tipo->requiere_marca ? 'S' : 'N' }}</td>
                    <td>{{ $tipo->requiere_modelo ? 'S' : 'N' }}</td>
                    <td>{{ $tipo->requiere_especificaciones ? 'S' : 'N' }}</td>
                    <td>
                        <a href="{{ route('tipos.show', $tipo) }}">Ver</a>
                        <a href="{{ route('tipos.edit', $tipo) }}">Editar</a>
                        <form action="{{ route('tipos.destroy', $tipo) }}" method="POST" style="display:inline">
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
