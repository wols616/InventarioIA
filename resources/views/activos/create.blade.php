@extends('layouts.app')

@section('content')
    <h1>Crear Activo</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activos.store') }}" method="POST">
        @csrf
        <div>
            <label>Tipo</label>
            <select name="id_tipo" required>
                <option value="">-- Seleccione Tipo --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo }}" {{ (old('id_tipo') == $tipo->id_tipo) ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Estado</label>
            <select name="id_estado" required>
                <option value="">-- Seleccione Estado --</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado->id_estado }}" {{ (old('id_estado') == $estado->id_estado) ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Ubicacion Actual</label>
            <select name="id_ubicacion_actual" required>
                <option value="">-- Seleccione Ubicacion --</option>
                @foreach($ubicaciones as $ubic)
                    <option value="{{ $ubic->id_ubicacion }}" {{ (old('id_ubicacion_actual') == $ubic->id_ubicacion) ? 'selected' : '' }}>{{ $ubic->area ? $ubic->area->nombre : $ubic->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Codigo</label>
            <input type="text" name="codigo" value="{{ old('codigo') }}" required>
        </div>
        <div>
            <label>Codigo Barra</label>
            <input type="text" name="codigo_barra" value="{{ old('codigo_barra') }}">
        </div>
        <div>
            <label>Marca</label>
            <input type="text" name="marca" value="{{ old('marca') }}">
        </div>
        <div>
            <label>Modelo</label>
            <input type="text" name="modelo" value="{{ old('modelo') }}">
        </div>
        <div>
            <label>Numero Serie</label>
            <input type="text" name="numero_serie" value="{{ old('numero_serie') }}">
        </div>
        <div>
            <label>Fecha Adquisicion</label>
            <input type="date" name="fecha_adquisicion" value="{{ old('fecha_adquisicion') }}">
        </div>
        <div>
            <label>Valor Adquisicion</label>
            <input type="number" step="0.01" name="valor_adquisicion" value="{{ old('valor_adquisicion') }}">
        </div>
        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('activos.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
