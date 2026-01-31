@extends('layouts.app')

@section('content')
    <h1>Categorías</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categorias.create') }}">Crear Categoría</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $cat)
                <tr>
                    <td>{{ $cat->id_categoria }}</td>
                    <td>{{ $cat->nombre }}</td>
                    <td>{{ $cat->descripcion }}</td>
                    <td>
                        <a href="{{ route('categorias.show', $cat) }}">Ver</a>
                        <a href="{{ route('categorias.edit', $cat) }}">Editar</a>
                        <form action="{{ route('categorias.destroy', $cat) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
