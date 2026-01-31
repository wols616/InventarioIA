@extends('layouts.app')

@section('content')
    <h1>Edificios</h1>

    <p><a href="{{ route('edificios.create') }}">Crear edificio</a></p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($edificios as $e)
                <tr>
                    <td>{{ $e->id_edificio }}</td>
                    <td>{{ $e->nombre }}</td>
                    <td>{{ $e->codigo }}</td>
                    <td>
                        <a href="{{ route('edificios.show', $e) }}">Ver</a>
                        <a href="{{ route('edificios.edit', $e) }}">Editar</a>
                        <form action="{{ route('edificios.destroy', $e) }}" method="POST" style="display:inline">
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
