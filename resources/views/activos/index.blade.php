@extends('layouts.app')

@section('content')
    <h1>Activos</h1>

    <p><a href="{{ route('activos.create') }}">Crear activo</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Fecha Adquisición</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($activos as $activo)
            <tr>
                <td>{{ $activo->id_activo }}</td>
                <td>{{ $activo->codigo }}</td>
                <td>{{ $activo->marca }}</td>
                <td>{{ $activo->modelo }}</td>
                <td>{{ optional($activo->fecha_adquisicion)->format('Y-m-d') }}</td>
                <td>{{ $activo->valor_adquisicion }}</td>
                <td>
                    <a href="{{ route('activos.show', $activo) }}">Ver</a>
                    <a href="{{ route('activos.edit', $activo) }}">Editar</a>
                    <form action="{{ route('activos.destroy', $activo) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $activos->links() }}</div>
@endsection
