@extends('layouts.app')

@section('content')
    <h1>Roles</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <a href="{{ route('roles.create') }}">Crear Rol</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $r)
                <tr>
                    <td>{{ $r->id_rol }}</td>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->descripcion }}</td>
                    <td>
                        <a href="{{ route('roles.show', $r) }}">Ver</a>
                        <a href="{{ route('roles.edit', $r) }}">Editar</a>
                        <form action="{{ route('roles.destroy', $r) }}" method="POST" style="display:inline">
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
