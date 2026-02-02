@extends('layouts.app')

@section('content')
    <h1>Crear Estado</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('estados.store') }}" method="POST">
        @csrf
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label>Operativo</label>
            <select name="es_operativo" required>
                <option value="1" {{ old('es_operativo') === '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('es_operativo') === '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div>
            <label>Anotación</label>
            <textarea name="anotacion">{{ old('anotacion') }}</textarea>
        </div>
        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('estados.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
