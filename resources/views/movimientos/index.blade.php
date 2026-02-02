@extends('layouts.app')

@section('content')
    <h1>Movimientos de Activos</h1>

    <p><a href="{{ route('movimientos.create') }}">Crear movimiento</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Activo</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($movimientos as $m)
            <tr>
                <td>{{ $m->id_movimiento }}</td>
                <td>{{ $m->activo ? ($m->activo->codigo . ' - ' . trim(($m->activo->marca ?? '') . ' ' . ($m->activo->modelo ?? ''))) : $m->id_activo }}</td>
                <td>
                    @if($m->ubicacionOrigen)
                        {{ $m->ubicacionOrigen->nombre }} ({{ $m->ubicacionOrigen->codigo_interno ?? '-' }})
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($m->ubicacionDestino)
                        {{ $m->ubicacionDestino->nombre }} ({{ $m->ubicacionDestino->codigo_interno ?? '-' }})
                    @else
                        -
                    @endif
                </td>
                <td>{{ $m->fecha_movimiento ? \Carbon\Carbon::parse($m->fecha_movimiento)->format('Y-m-d') : '' }}</td>
                <td>{{ $m->motivo }}</td>
                <td>
                    <a href="{{ route('movimientos.show', $m) }}">Ver</a>
                    <a href="{{ route('movimientos.edit', $m) }}">Editar</a>
                    <form action="{{ route('movimientos.destroy', $m) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $movimientos->links() }}</div>
@endsection
