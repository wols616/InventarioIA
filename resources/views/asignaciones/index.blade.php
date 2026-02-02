@extends('layouts.app')

@section('content')
    <h1>Asignaciones</h1>
    <a href="{{ route('asignaciones.create') }}">Crear asignación</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Activo</th>
                <th>Persona</th>
                <th>Fecha asignación</th>
                <th>Fecha fin</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $a)
                <tr>
                    <td>{{ $a->id_asignacion }}</td>
                    <td>{{ optional($a->activo)->codigo }} {{ optional($a->activo)->marca }} {{ optional($a->activo)->modelo }}</td>
                    <td>{{ optional($a->persona)->nombre }} {{ optional($a->persona)->apellido }}</td>
                    <td>{{ optional($a->fecha_asignacion)->format('Y-m-d') }}</td>
                    <td>{{ optional($a->fecha_fin)->format('Y-m-d') }}</td>
                    <td>{{ $a->es_responsable_principal ? 'Sí' : 'No' }}</td>
                    <td>{{ $a->estado ? 'Activa' : 'Inactiva' }}</td>
                    <td>
                        <a href="{{ route('asignaciones.show', $a->id_asignacion) }}">Ver</a>
                        <a href="{{ route('asignaciones.edit', $a->id_asignacion) }}">Editar</a>
                        <form action="{{ route('asignaciones.destroy', $a->id_asignacion) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Desactivar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $asignaciones->links() }}
@endsection
