@extends('layouts.app')

@section('content')
    <h1>Auditorías</h1>

    <p><a href="{{ route('auditorias.create') }}">Crear auditoría</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Persona</th>
                <th>Fecha</th>
                <th>Detalles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($auditorias as $a)
            <tr>
                <td>{{ $a->id_auditoria }}</td>
                <td>{{ $a->persona ? ($a->persona->nombre . ' ' . $a->persona->apellido) : $a->id_persona }}</td>
                <td>{{ $a->fecha_auditoria ? \Carbon\Carbon::parse($a->fecha_auditoria)->format('Y-m-d') : '' }}</td>
                <td>{{ $a->detalles()->count() }}</td>
                <td>
                    <a href="{{ route('auditorias.show', $a) }}">Ver</a>
                    <a href="{{ route('auditorias.edit', $a) }}">Editar</a>
                    <form action="{{ route('auditorias.destroy', $a) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $auditorias->links() }}</div>
@endsection
