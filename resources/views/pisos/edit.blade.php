@extends('layouts.app')

@section('content')
    <h1>Editar Piso #{{ $piso->id_piso }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pisos.update', $piso) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Edificio</label>
            <select name="id_edificio" required>
                <option value="">-- Seleccione edificio --</option>
                @foreach($edificios as $e)
                    <option value="{{ $e->id_edificio }}" {{ (old('id_edificio', $piso->id_edificio) == $e->id_edificio) ? 'selected' : '' }}>{{ $e->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Numero Piso</label>
            <input type="number" name="numero_piso" value="{{ old('numero_piso', $piso->numero_piso) }}" required>
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('pisos.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
