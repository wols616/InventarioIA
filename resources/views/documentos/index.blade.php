@extends('layouts.app')

@section('content')
    <h1>Documentos {{ $activoId ? ('del Activo #' . $activoId) : '' }}</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    @if($activoId)
        <p>
            <a href="{{ route('documentos.create', ['activo' => $activoId]) }}">Agregar documento</a>
            &nbsp;|&nbsp;
            <a href="{{ route('activos.show', $activoId) }}">Volver al Activo</a>
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentos as $d)
                <tr>
                    <td>{{ $d->id_documento }}</td>
                    <td>{{ $d->tipo_documento }}</td>
                    <td>
                        @if($d->ruta_archivo)
                            <a href="{{ $d->ruta_archivo }}" target="_blank">Ver/Descargar</a>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('documentos.destroy', $d) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
