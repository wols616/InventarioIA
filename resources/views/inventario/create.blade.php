@extends('layouts.app')

@section('content')
    <h1>Agregar Item de Inventario</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventario.store') }}" method="POST">
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
            <label>Cantidad</label>
            <input type="number" name="cantidad" value="{{ old('cantidad', 0) }}" required>
        </div>

        <div>
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion') }}</textarea>
        </div>

        <div>
            <label>Cantidad mínima</label>
            <input type="number" name="cantidad_minima" value="{{ old('cantidad_minima') }}">
        </div>

        <div>
            <label>Cantidad máxima</label>
            <input type="number" name="cantidad_maxima" value="{{ old('cantidad_maxima') }}">
        </div>

        <div>
            <button type="submit">Agregar</button>
            <a href="{{ route('inventario.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
