@extends('layouts.app')

@section('content')
    <h1>Editar Estado #{{ $estado->id_estado }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('estados.update', $estado) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $estado->nombre) }}" required>
        </div>
        <div>
            <label>Operativo</label>
            <select name="es_operativo" required>
                <option value="1" {{ (old('es_operativo', $estado->es_operativo) == 1) ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ (old('es_operativo', $estado->es_operativo) == 0) ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('estados.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
