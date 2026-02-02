@extends('layouts.app')

@section('content')
    <h1>Inventario</h1>

    <p><a href="{{ route('inventario.create') }}">Agregar item</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Activo</th>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Min</th>
                <th>Max</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($inventarios as $i)
            <tr>
                <td>{{ $i->id_inventario }}</td>
                <td>{{ $i->activo ? ($i->activo->codigo . ' - ' . trim(($i->activo->marca ?? '') . ' ' . ($i->activo->modelo ?? ''))) : $i->id_activo }}</td>
                <td>{{ $i->cantidad }}</td>
                <td>{{ $i->descripcion }}</td>
                <td>{{ $i->cantidad_minima }}</td>
                <td>{{ $i->cantidad_maxima }}</td>
                <td>
                    <a href="{{ route('inventario.show', $i) }}">Ver</a>
                    <a href="{{ route('inventario.edit', $i) }}">Editar</a>
                    <form action="{{ route('inventario.destroy', $i) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $inventarios->links() }}</div>
@endsection
