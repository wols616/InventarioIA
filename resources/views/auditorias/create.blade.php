@extends('layouts.app')

@section('content')
    <h1>Crear Auditoría</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('auditorias.store') }}" method="POST">
        @csrf

        <div>
            <label>Persona</label>
            <select name="id_persona" required>
                <option value="">-- Seleccione persona --</option>
                @foreach($personas as $p)
                    <option value="{{ $p->id_persona }}" {{ old('id_persona') == $p->id_persona ? 'selected' : '' }}>{{ $p->nombre }} {{ $p->apellido }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Fecha auditoría</label>
            <input type="date" name="fecha_auditoria" value="{{ old('fecha_auditoria', date('Y-m-d')) }}" required>
        </div>

        <h3>Detalle</h3>
        <div id="detalles">
            <div class="detalle-row">
                <select name="id_activo[]">
                    <option value="">-- Seleccione activo --</option>
                    @foreach($activos as $act)
                        <option value="{{ $act->id_activo }}">{{ $act->codigo }} - {{ $act->marca }} {{ $act->modelo }}</option>
                    @endforeach
                </select>
                <label>
                    <input type="checkbox" name="coincide[]" value="1"> Coincide
                </label>
                <input type="text" name="anotaciones[]" placeholder="Anotaciones">
                <button type="button" class="remove">Eliminar</button>
            </div>
        </div>
        <p><button type="button" id="addDetalle">Agregar detalle</button></p>

        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('auditorias.index') }}">Cancelar</a>
        </div>
    </form>

    <script>
        (function(){
            const activesHtml = `@foreach($activos as $act)<option value="{{ $act->id_activo }}">{{ addslashes($act->codigo . ' - ' . ($act->marca ?? '') . ' ' . ($act->modelo ?? '')) }}</option>@endforeach`;
            document.getElementById('addDetalle').addEventListener('click', function(){
                const c = document.createElement('div');
                c.className='detalle-row';
                c.innerHTML = `<select name="id_activo[]"><option value="">-- Seleccione activo --</option>${activesHtml}</select> <label><input type="checkbox" name="coincide[]" value="1"> Coincide</label> <input type="text" name="anotaciones[]" placeholder="Anotaciones"> <button type="button" class="remove">Eliminar</button>`;
                document.getElementById('detalles').appendChild(c);
            });
            document.getElementById('detalles').addEventListener('click', function(e){
                if(e.target.matches('.remove')) e.target.parentNode.remove();
            });
        })();
    </script>

@endsection
