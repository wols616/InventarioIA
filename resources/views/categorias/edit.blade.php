@extends('layouts.app')

@section('content')
    <h1>Editar Categoría</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categorias.update', $categoria) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        </div>
        <div>
            <label>Vida útil estimada (meses)</label>
            <input type="number" name="vida_util_estimada_meses" value="{{ old('vida_util_estimada_meses', $categoria->vida_util_estimada_meses) }}" min="0">
        </div>
        <div>
            <label><input type="checkbox" name="depreciable" {{ old('depreciable', $categoria->depreciable) ? 'checked' : '' }}> Depreciable</label>
        </div>
        <div>
            <label><input type="checkbox" name="activo" {{ old('activo', $categoria->activo) ? 'checked' : '' }}> Activo</label>
        </div>
        <div>
            <button type="submit">Guardar</button>
            <a href="{{ route('categorias.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
