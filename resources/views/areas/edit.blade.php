@extends('layouts.app')

@section('content')
    <h1>Editar Área #{{ $area->id_area }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('areas.update', $area) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Edificio</label>
            <select id="edificio_select" required>
                <option value="">-- Seleccione Edificio --</option>
                @foreach($edificios as $ed)
                    <option value="{{ $ed->id_edificio }}" {{ (optional($area->piso)->id_edificio == $ed->id_edificio) ? 'selected' : '' }}>{{ $ed->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Piso</label>
            <select name="id_piso" id="piso_select" required>
                <option value="">-- Seleccione Piso --</option>
                @foreach($pisos as $p)
                    <option value="{{ $p->id_piso }}" data-edificio-id="{{ $p->id_edificio }}" {{ (old('id_piso', $area->id_piso) == $p->id_piso) ? 'selected' : '' }}>{{ optional($p->edificio)->nombre }} - Piso {{ $p->numero_piso }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $area->nombre) }}" required>
        </div>
        <div>
            <label>Tipo de Área</label>
            <input type="text" name="tipo_area" value="{{ old('tipo_area', $area->tipo_area) }}">
        </div>
        <div>
            <label>Estado</label>
            <select name="estado">
                <option value="1" {{ $area->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$area->estado ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div style="margin-top:8px">
            <a href="{{ route('pisos.index') }}">Gestionar Pisos</a>
            &nbsp;|&nbsp;
            <a href="{{ route('edificios.index') }}">Gestionar Edificios</a>
        </div>
        <div>
            <button type="submit">Guardar</button>
            <a href="{{ route('areas.index') }}">Cancelar</a>
        </div>
    </form>
    <script>
        (function(){
            const edSelect = document.getElementById('edificio_select');
            const pisoSelect = document.getElementById('piso_select');

            function filterPisos(){
                const eid = edSelect.value;
                for(const opt of pisoSelect.options){
                    if(!opt.value) continue;
                    const match = opt.dataset.edificioId === eid;
                    opt.style.display = match ? '' : 'none';
                    if(!match) opt.selected = false;
                }
            }

            edSelect.addEventListener('change', filterPisos);
            (function init(){
                const selectedPiso = pisoSelect.querySelector('option[selected]');
                if(selectedPiso){
                    const edid = selectedPiso.dataset.edificioId;
                    if(edid){ edSelect.value = edid; }
                }
                filterPisos();
            })();
        })();
    </script>
@endsection
