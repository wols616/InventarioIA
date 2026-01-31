@extends('layouts.app')

@section('content')
    <h1>Personas</h1>

    <p><a href="{{ route('personas.create') }}">Crear persona</a></p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DUI</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Departamento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personas as $p)
                <tr>
                    <td>{{ $p->id_persona }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->apellido ?? '-' }}</td>
                    <td>{{ $p->dui ?? '-' }}</td>
                    <td>{{ $p->correo ?? '-' }}</td>
                    <td>{{ $p->rol ? $p->rol->nombre : '-' }}</td>
                    <td>{{ $p->departamento ? $p->departamento->nombre : '-' }}</td>
                    <td>{{ isset($p->estado) ? ($p->estado ? 'Activo' : 'Inactivo') : '-' }}</td>
                    <td>
                        <a href="{{ route('personas.show', $p) }}">Ver</a>
                        <a href="{{ route('personas.edit', $p) }}">Editar</a>
                        <form action="{{ route('personas.destroy', $p) }}" method="POST" style="display:inline">
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
