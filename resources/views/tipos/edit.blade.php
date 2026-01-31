<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Tipo</title>
</head>
<body>
@extends('layouts.app')

@section('content')
    <h1>Editar Tipo #{{ $tipo->id_tipo }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tipos.update', $tipo) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Categoria</label>
            <select name="id_categoria" required>
                <option value="">-- Seleccione categoría --</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}" {{ (old('id_categoria', $tipo->id_categoria) == $cat->id_categoria) ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $tipo->nombre) }}" required>
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('tipos.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
</body>
</html>
