@extends('layouts.app')

@section('content')
    <h1>Editar Activo #{{ $activo->id_activo }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activos.update', $activo) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Tipo</label>
            <select name="id_tipo" required>
                <option value="">-- Seleccione tipo --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo }}" {{ (old('id_tipo', $activo->id_tipo) == $tipo->id_tipo) ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Estado</label>
            <select name="id_estado" required>
                <option value="">-- Seleccione estado --</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado->id_estado }}" {{ (old('id_estado', $activo->id_estado) == $estado->id_estado) ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Ubicación</label>
            <select name="id_ubicacion_actual">
                <option value="">-- Sin ubicación --</option>
                @foreach($ubicaciones as $ubicacion)
                    <option value="{{ $ubicacion->id_ubicacion }}" {{ (old('id_ubicacion_actual', $activo->id_ubicacion_actual) == $ubicacion->id_ubicacion) ? 'selected' : '' }}>
                        {{ $ubicacion->nombre }}@if($ubicacion->area) ({{ $ubicacion->area->nombre }})@endif
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>codigo</label>
            <input type="text" name="codigo" value="{{ old('codigo', $activo->codigo) }}" required>
        </div>
        <div>
            <label>marca</label>
            <input type="text" name="marca" value="{{ old('marca', $activo->marca) }}">
        </div>
        <div>
            <label>modelo</label>
            <input type="text" name="modelo" value="{{ old('modelo', $activo->modelo) }}">
        </div>
        <div>
            <label>numero_serie</label>
            <input type="text" name="numero_serie" value="{{ old('numero_serie', $activo->numero_serie) }}">
        </div>
        <div>
            <label>fecha_adquisicion</label>
            <input type="date" name="fecha_adquisicion" value="{{ old('fecha_adquisicion', optional($activo->fecha_adquisicion)->format('Y-m-d')) }}">
        </div>
        <div>
            <label>valor_adquisicion</label>
            <input type="number" step="0.01" name="valor_adquisicion" value="{{ old('valor_adquisicion', $activo->valor_adquisicion) }}">
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('activos.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
