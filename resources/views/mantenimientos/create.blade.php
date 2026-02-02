@extends('layouts.app')

@section('content')
    <h1>Crear Mantenimiento</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mantenimientos.store') }}" method="POST">
        @csrf
        <div>
            <label>Activo</label>
            <select name="id_activo" required>
                <option value="">-- Seleccione activo --</option>
                @foreach($activos as $a)
                    <option value="{{ $a->id_activo }}" {{ old('id_activo') == $a->id_activo ? 'selected' : '' }}>{{ $a->codigo }} - {{ $a->marca }} {{ $a->modelo }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Tipo mantenimiento</label>
            <input type="text" name="tipo_mantenimiento" value="{{ old('tipo_mantenimiento') }}">
        </div>

        <div>
            <label>Fecha inicio</label>
            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
        </div>

        <div>
            <label>Fecha fin</label>
            <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}">
        </div>

        <div>
            <label>Costo</label>
            <input type="number" step="0.01" name="costo" value="{{ old('costo') }}">
        </div>

        <div>
            <label>Anotacion</label>
            <textarea name="anotacion">{{ old('anotacion') }}</textarea>
        </div>

        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('mantenimientos.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
