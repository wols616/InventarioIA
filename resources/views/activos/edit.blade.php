<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Activo</title>
</head>
<body>
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
            <label>id_tipo (int)</label>
            <input type="number" name="id_tipo" value="{{ old('id_tipo', $activo->id_tipo) }}" required>
        </div>
        <div>
            <label>id_estado (int)</label>
            <input type="number" name="id_estado" value="{{ old('id_estado', $activo->id_estado) }}" required>
        </div>
        <div>
            <label>id_ubicacion_actual (int)</label>
            <input type="number" name="id_ubicacion_actual" value="{{ old('id_ubicacion_actual', $activo->id_ubicacion_actual) }}">
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
</body>
</html>
