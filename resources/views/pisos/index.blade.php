@extends('layouts.app')

@section('content')
    <h1>Pisos</h1>

    <p><a href="{{ route('pisos.create') }}">Crear piso</a></p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Edificio</th>
                <th>Numero</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pisos as $p)
                <tr>
                    <td>{{ $p->id_piso }}</td>
                    <td>{{ $p->edificio ? $p->edificio->nombre : '-' }}</td>
                    <td>{{ $p->numero_piso }}</td>
                    <td>
                        <a href="{{ route('pisos.show', $p) }}">Ver</a>
                        <a href="{{ route('pisos.edit', $p) }}">Editar</a>
                        <form action="{{ route('pisos.destroy', $p) }}" method="POST" style="display:inline">
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
