@extends('layouts.app')

@section('content')
<h1>Editar Movimiento #{{ $movimiento->id_movimiento ?? $movimiento->id }}</h1>

@if ($errors->any())
<div style="color:red">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('movimientos.update', $movimiento->id_movimiento ?? $movimiento->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Activo</label>
        <select name="id_activo" id="activo_select" required>
            <option value="">-- Seleccione activo --</option>
            @foreach($activos as $a)
            <option value="{{ $a->id_activo }}" data-ubicacion="{{ $a->id_ubicacion_actual }}" {{ (old('id_activo', $movimiento->id_activo) == $a->id_activo) ? 'selected' : '' }}>{{ $a->codigo }} - {{ $a->marca }} {{ $a->modelo }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Ubicación origen</label>
        <select name="id_ubicacion_origen" id="origen_select">
            <option value="">-- (se establecerá al elegir activo) --</option>
            @foreach($ubicaciones as $u)
            <option value="{{ $u->id_ubicacion }}" {{ old('id_ubicacion_origen', $movimiento->id_ubicacion_origen) == $u->id_ubicacion ? 'selected' : '' }}>{{ $u->nombre }} ({{ $u->codigo_interno ?? '' }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Ubicación destino</label>
        <select name="id_ubicacion_destino" required>
            <option value="">-- Seleccione destino --</option>
            @foreach($ubicaciones as $u)
            <option value="{{ $u->id_ubicacion }}" {{ old('id_ubicacion_destino', $movimiento->id_ubicacion_destino) == $u->id_ubicacion ? 'selected' : '' }}>{{ $u->nombre }} ({{ $u->codigo_interno ?? '' }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Fecha movimiento</label>
        <input type="date" name="fecha_movimiento" value="{{ old('fecha_movimiento', (isset($movimiento->fecha_movimiento) && $movimiento->fecha_movimiento) ? \Carbon\Carbon::parse($movimiento->fecha_movimiento)->format('Y-m-d') : date('Y-m-d')) }}" required>
    </div>

    <div>
        <label>Motivo</label>
        <textarea name="motivo">{{ old('motivo', $movimiento->motivo) }}</textarea>
    </div>

    <div>
        <button type="submit">Actualizar</button>
        <a href="{{ route('movimientos.index') }}">Cancelar</a>
    </div>
</form>

<script>
    (function() {
        const activoSel = document.getElementById('activo_select');
        const origenSel = document.getElementById('origen_select');

        function updateOrigen() {
            const o = activoSel.selectedOptions[0];
            if (!o || !o.value) {
                origenSel.value = '';
                return;
            }
            const ubic = o.dataset.ubicacion;
            if (ubic) {
                const opt = Array.from(origenSel.options).find(x => x.value == ubic);
                if (opt) opt.selected = true;
            }
        }
        activoSel.addEventListener('change', updateOrigen);
    })();
</script>

@endsection