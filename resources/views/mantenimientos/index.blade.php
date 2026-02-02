@extends('layouts.app')

@section('content')
    <h1>Mantenimientos</h1>

    <p><a href="{{ route('mantenimientos.create') }}">Crear mantenimiento</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Activo</th>
                <th>Tipo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($mantenimientos as $m)
            <tr>
                <td>{{ $m->id_mantenimiento }}</td>
                <td>{{ $m->activo ? ($m->activo->codigo . ' - ' . trim(($m->activo->marca ?? '') . ' ' . ($m->activo->modelo ?? ''))) : $m->id_activo }}</td>
                <td>{{ $m->tipo_mantenimiento }}</td>
                <td>{{ $m->fecha_inicio ? \Carbon\Carbon::parse($m->fecha_inicio)->format('Y-m-d') : '' }}</td>
                <td>{{ $m->fecha_fin ? \Carbon\Carbon::parse($m->fecha_fin)->format('Y-m-d') : '' }}</td>
                <td>{{ $m->costo }}</td>
                <td>
                    <a href="{{ route('mantenimientos.show', $m) }}">Ver</a>
                    <a href="{{ route('mantenimientos.edit', $m) }}">Editar</a>
                    <form action="{{ route('mantenimientos.destroy', $m) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $mantenimientos->links() }}</div>
@endsection
