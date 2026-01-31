@extends('layouts.app')

@section('content')
    <h1>Crear Tipo</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tipos.store') }}" method="POST">
        @csrf
        <div>
            <label>Categoria</label>
            <select name="id_categoria" required>
                <option value="">-- Seleccione categoría --</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}" {{ (old('id_categoria') == $cat->id_categoria) ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('tipos.index') }}">Cancelar</a>
            <a href="{{ route('categorias.index') }}" style="margin-left:1rem">Gestionar Categorías</a>
        </div>
    </form>
@endsection
