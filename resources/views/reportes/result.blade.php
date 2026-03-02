@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-lg font-semibold mb-4">Reporte de asignaciones - {{ $persona->nombre }} {{ $persona->apellido }}</h2>

        <p class="text-sm text-gray-600 mb-4">Período: {{ $inicio }} — {{ $fin }}</p>

        <div class="mb-4 flex items-center space-x-2">
            <form action="{{ route('reportes.pdf') }}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="persona_id" value="{{ $persona->id_persona }}">
                <input type="hidden" name="fecha_inicio" value="{{ $inicio }}">
                <input type="hidden" name="fecha_fin" value="{{ $fin }}">
                <button type="submit" class="bg-gray-800 text-white px-3 py-1 rounded">Descargar PDF</button>
            </form>
            <a href="{{ route('reportes.index') }}" class="text-sm text-gray-600">Volver</a>
        </div>

        @if($asignaciones->isEmpty())
            <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400">No se encontraron asignaciones en el período seleccionado.</div>
            <div class="mt-4"><a href="{{ route('reportes.index') }}" class="text-brand-700">Volver</a></div>
            @return
        @endif

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Activo (código)</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Descripción</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Fecha asignación</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Fecha fin</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($asignaciones as $asig)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $asig->activo->codigo ?? '—' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <div class="font-medium">{{ $asig->activo->marca ?? '' }} {{ $asig->activo->modelo ?? '' }}</div>
                            <div class="text-xs text-gray-500">S/N: {{ $asig->activo->numero_serie ?? '-' }} — Tipo: {{ $asig->activo->tipo->nombre ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ optional($asig->fecha_asignacion)->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ optional($asig->fecha_fin)->format('Y-m-d') ?? 'Activo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4"></div>
    </div>
@endsection
