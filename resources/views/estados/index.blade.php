@extends('layouts.app')

@section('content')
    <h1>Estados de Activos</h1>

    <p><a href="{{ route('estados.create') }}">Crear estado</a></p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Operativo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estados as $estado)
                <tr>
                    <td>{{ $estado->id_estado }}</td>
                    <td>{{ $estado->nombre }}</td>
                    <td>{{ $estado->es_operativo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('estados.show', $estado) }}">Ver</a>
                        <a href="{{ route('estados.edit', $estado) }}">Editar</a>
                        <form action="{{ route('estados.destroy', $estado) }}" method="POST" style="display:inline">
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
