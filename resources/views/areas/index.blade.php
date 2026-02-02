@extends('layouts.app')

@section('content')
    <h1>Áreas</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <p>
        <a href="{{ route('areas.create') }}">Crear Área</a>
        &nbsp;|&nbsp;
        <a href="{{ route('pisos.index') }}">Gestionar Pisos</a>
        &nbsp;|&nbsp;
        <a href="{{ route('edificios.index') }}">Gestionar Edificios</a>
    </p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Piso</th>
                <th>Edificio</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $a)
                <tr>
                    <td>{{ $a->id_area }}</td>
                    <td>{{ $a->nombre }}</td>
                    <td>{{ $a->piso ? $a->piso->numero_piso : '-' }}</td>
                    <td>{{ $a->piso && $a->piso->edificio ? $a->piso->edificio->nombre : '-' }}</td>
                    <td>{{ $a->tipo_area }}</td>
                    <td>{{ $a->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('areas.show', $a) }}">Ver</a>
                        <a href="{{ route('areas.edit', $a) }}">Editar</a>
                        <form action="{{ route('areas.destroy', $a) }}" method="POST" style="display:inline">
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
