@extends('layouts.app')

@section('content')
    <h1>Activos</h1>

    <p>
        <a href="{{ route('activos.create') }}">Crear activo</a>
    </p>

    <form method="GET" action="{{ route('activos.index') }}" style="margin-bottom:1rem"> 
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
            <input type="text" name="codigo" placeholder="Código" value="{{ request('codigo') }}">
            <input type="text" name="marca" placeholder="Marca" value="{{ request('marca') }}">
            <input type="text" name="modelo" placeholder="Modelo" value="{{ request('modelo') }}">
            <select name="id_tipo">
                <option value="">-- Tipo --</option>
                @foreach($tipos as $t)
                    <option value="{{ $t->id_tipo }}" {{ request('id_tipo') == $t->id_tipo ? 'selected' : '' }}>{{ $t->nombre }}</option>
                @endforeach
            </select>
            <select name="id_estado">
                <option value="">-- Estado --</option>
                @foreach($estados as $e)
                    <option value="{{ $e->id_estado }}" {{ request('id_estado') == $e->id_estado ? 'selected' : '' }}>{{ $e->nombre }}</option>
                @endforeach
            </select>
            <select name="id_ubicacion_actual">
                <option value="">-- Ubicación --</option>
                @foreach($ubicaciones as $u)
                    <option value="{{ $u->id_ubicacion }}" {{ request('id_ubicacion_actual') == $u->id_ubicacion ? 'selected' : '' }}>{{ $u->nombre }}</option>
                @endforeach
            </select>
            <label style="display:flex;align-items:center"><input type="checkbox" name="include_deleted" value="1" {{ request()->boolean('include_deleted') ? 'checked' : '' }}> Incluir Eliminados</label>
            <button type="submit">Filtrar</button>
            <a href="{{ route('activos.index') }}">Limpiar</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Estado</th>
                <th>Ubicación</th>
                <th>Fecha Adquisición</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($activos as $activo)
            <tr>
                <td>{{ $activo->id_activo }}</td>
                <td>{{ $activo->codigo }}</td>
                <td>{{ $activo->marca }}</td>
                <td>{{ $activo->modelo }}</td>
                <td>{{ $activo->estado ? $activo->estado->nombre : '-' }}</td>
                <td>
                    @if($activo->ubicacion)
                        <div>{{ $activo->ubicacion->nombre }}</div>
                        <div style="font-size:0.9em;color:#666">{{ $activo->ubicacion->codigo_interno ?? '' }}</div>
                        <div style="font-size:0.8em;color:#444">{{ $activo->ubicacion->area ? $activo->ubicacion->area->nombre : '' }}
                        @if(optional($activo->ubicacion->area)->piso)
                            / Piso {{ optional($activo->ubicacion->area->piso)->numero_piso }}
                        @endif
                        @if(optional(optional($activo->ubicacion->area)->piso)->edificio)
                            / {{ optional(optional($activo->ubicacion->area)->piso->edificio)->nombre }}
                        @endif
                        </div>
                    @else
                        -
                    @endif
                </td>
                <td>{{ optional($activo->fecha_adquisicion)->format('Y-m-d') }}</td>
                <td>{{ $activo->valor_adquisicion }}</td>
                <td>
                    <a href="{{ route('activos.show', $activo) }}">Ver</a>
                    <a href="{{ route('documentos.index', ['activo' => $activo->id_activo]) }}" style="margin-left:0.5rem">Documentos</a>
                    <a href="{{ route('inventario.index') }}?activo={{ $activo->id_activo }}" style="margin-left:0.5rem">Inventario</a>
                    <a href="{{ route('activos.edit', $activo) }}">Editar</a>
                    <form action="{{ route('activos.destroy', $activo) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $activos->links() }}</div>
@endsection
