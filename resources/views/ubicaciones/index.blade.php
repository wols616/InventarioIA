@extends('layouts.app')

@section('content')
    <h1>Ubicaciones</h1>

    <p>
        <a href="{{ route('ubicaciones.create') }}">Crear ubicación</a>
        &nbsp;|&nbsp;
        <a href="{{ route('areas.index') }}">Gestionar Áreas</a>
    </p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Código interno</th>
                <th>Área</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ubicaciones as $u)
                <tr>
                    <td>{{ $u->id_ubicacion }}</td>
                    <td>{{ $u->nombre }}</td>
                    <td>{{ $u->codigo_interno ?? '-' }}</td>
                    <td>{{ $u->area ? $u->area->nombre : '-' }}</td>
                    <td>{{ $u->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('ubicaciones.show', $u) }}">Ver</a>
                        <a href="{{ route('ubicaciones.edit', $u) }}">Editar</a>
                        <form action="{{ route('ubicaciones.destroy', $u) }}" method="POST" style="display:inline">
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
