@extends('layouts.app')

@section('content')
    <h1>Editar Ubicación #{{ $ubicacion->id_ubicacion }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ubicaciones.update', $ubicacion) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Area</label>
            <select name="id_area" id="area_select" required>
                <option value="">-- Seleccione área --</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id_area }}"
                        data-piso-num="{{ optional($area->piso)->numero_piso }}"
                        data-piso-id="{{ optional($area->piso)->id_piso }}"
                        data-edificio-nombre="{{ optional(optional($area->piso)->edificio)->nombre }}"
                        {{ (old('id_area', $ubicacion->id_area) == $area->id_area) ? 'selected' : '' }}>
                        {{ $area->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div id="area_info" style="margin-top:8px">
            <strong>Area pertenece a:</strong>
            <div>Edificio: <span id="ai_edificio">{{ optional(optional($ubicacion->area)->piso->edificio)->nombre ?? '-' }}</span></div>
            <div>Piso: <span id="ai_piso">{{ optional(optional($ubicacion->area)->piso)->numero_piso ?? '-' }}</span></div>
        </div>

        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $ubicacion->nombre) }}">
        </div>
        <div style="margin-top:8px">
            <a href="{{ route('edificios.index') }}">Ver/gestionar Edificios</a>
            &nbsp;|&nbsp;
            <a href="{{ route('pisos.index') }}">Ver/gestionar Pisos</a>
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('ubicaciones.index') }}">Cancelar</a>
        </div>
    </form>

    <script>
        (function(){
            const sel = document.getElementById('area_select');
            const ed = document.getElementById('ai_edificio');
            const pi = document.getElementById('ai_piso');
            function update(){
                const o = sel.selectedOptions[0];
                if(!o || !o.value){ ed.textContent = '-'; pi.textContent = '-'; return; }
                ed.textContent = o.dataset.edificioNombre || '-';
                pi.textContent = o.dataset.pisoNum || '-';
            }
            sel.addEventListener('change', update);
            update();
        })();
    </script>

@endsection
