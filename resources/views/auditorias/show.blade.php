@extends('layouts.app')

@section('content')
    <h1>Auditoría #{{ $auditoria->id_auditoria }}</h1>

    <p><strong>Persona:</strong> {{ $auditoria->persona ? ($auditoria->persona->nombre . ' ' . $auditoria->persona->apellido) : $auditoria->id_persona }}</p>
    <p><strong>Fecha:</strong> {{ $auditoria->fecha_auditoria ? \Carbon\Carbon::parse($auditoria->fecha_auditoria)->format('Y-m-d') : '' }}</p>

    <h3>Detalles</h3>
    <table>
        <thead>
            <tr>
                <th>Activo</th>
                <th>Coincide</th>
                <th>Anotaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($auditoria->detalles as $d)
                <tr>
                    <td>{{ $d->activo ? ($d->activo->codigo . ' - ' . trim(($d->activo->marca ?? '') . ' ' . ($d->activo->modelo ?? ''))) : $d->id_activo }}</td>
                    <td>{{ $d->coincide_con_sistema ? 'Sí' : 'No' }}</td>
                    <td>{{ $d->anotaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('auditorias.index') }}">Volver</a>
@endsection
