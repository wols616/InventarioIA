@extends('layouts.app')

@section('content')
    <h1>Departamentos</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <p>
        <a href="{{ route('departamentos.create') }}">Crear Departamento</a>
        <a href="{{ route('roles.index') }}" style="margin-left:1rem">Gestionar Roles</a>
    </p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departamentos as $d)
                <tr>
                    <td>{{ $d->id_departamento }}</td>
                    <td>{{ $d->nombre }}</td>
                    <td>{{ $d->descripcion }}</td>
                    <td>{{ $d->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('departamentos.show', $d) }}">Ver</a>
                        <a href="{{ route('departamentos.edit', $d) }}">Editar</a>
                        <form action="{{ route('departamentos.destroy', $d) }}" method="POST" style="display:inline">
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
