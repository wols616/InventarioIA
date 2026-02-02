@extends('layouts.app')

@section('content')
    <h1>Crear Categoría</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion') }}</textarea>
        </div>
        <div>
            <label>Vida útil estimada (meses)</label>
            <input type="number" name="vida_util_estimada_meses" value="{{ old('vida_util_estimada_meses') }}" min="0">
        </div>
        <div>
            <label><input type="checkbox" name="depreciable" {{ old('depreciable', '1') ? 'checked' : '' }}> Depreciable</label>
        </div>
        <div>
            <label><input type="checkbox" name="activo" {{ old('activo', '1') ? 'checked' : '' }}> Activo</label>
        </div>
        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('categorias.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
