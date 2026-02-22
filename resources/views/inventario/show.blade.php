@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Item de Inventario #{{ $inventario->id_inventario }}</h1>
                <a href="{{ route('inventario.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                    Volver
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Activo</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $inventario->activo ? ($inventario->activo->codigo . ' - ' . trim(($inventario->activo->marca ?? '') . ' ' . ($inventario->activo->modelo ?? ''))) : $inventario->id_activo }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Ubicación actual</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($inventario->activo && $inventario->activo->ubicacion)
                                @php $ub = $inventario->activo->ubicacion; @endphp
                                {{ $ub->nombre }}@if($ub->codigo_interno) ({{ $ub->codigo_interno }})@endif
                                @if($ub->area)
                                    · {{ $ub->area->nombre }}
                                    @if($ub->area->piso)
                                        · {{ $ub->area->piso->nombre ?? '' }}
                                        @if($ub->area->piso->edificio)
                                            · {{ $ub->area->piso->edificio->nombre ?? '' }}
                                        @endif
                                    @endif
                                @endif
                            @else
                                <span class="text-gray-500">No establecida</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Cantidad Actual</label>
                        <p class="mt-1">
                            <span class="inline-flex px-3 py-1 text-lg font-semibold rounded-full {{ $inventario->cantidad < ($inventario->cantidad_minima ?: 0) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $inventario->cantidad }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Descripción</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $inventario->descripcion ?: 'Sin descripción' }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Cantidad Mínima</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $inventario->cantidad_minima ?: 'No establecida' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Cantidad Máxima</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $inventario->cantidad_maxima ?: 'No establecida' }}</p>
                    </div>

                    @if($inventario->cantidad_minima && $inventario->cantidad < $inventario->cantidad_minima)
                        <div class="p-4 bg-red-50 border-l-4 border-red-400">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        <strong>Stock bajo:</strong> La cantidad actual está por debajo del mínimo establecido.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="p-6 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Asignaciones del activo</h2>
                    @if(isset($asignaciones) && $asignaciones->count())
                        <ul class="divide-y divide-gray-100">
                            @foreach($asignaciones as $as)
                                <li class="py-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $as->persona ? ($as->persona->nombre . ' ' . $as->persona->apellido) : 'Sin persona' }}</div>
                                            <div class="text-xs text-gray-500">Asignado: {{ $as->fecha_asignacion ? $as->fecha_asignacion->format('Y-m-d') : '—' }} @if($as->fecha_fin) · Fin: {{ $as->fecha_fin->format('Y-m-d') }} @endif</div>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            @if($as->estado)
                                                <span class="px-2 py-1 rounded bg-green-100 text-green-800">Activa</span>
                                            @else
                                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-800">Inactiva</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">No hay asignaciones registradas para este activo.</p>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Historial de movimientos</h2>
                    @if(isset($movimientos) && $movimientos->count())
                        <ul class="divide-y divide-gray-100">
                            @foreach($movimientos as $mov)
                                <li class="py-3">
                                    <div class="text-sm text-gray-900">{{ $mov->fecha_movimiento ? $mov->fecha_movimiento : 'Fecha desconocida' }}</div>
                                    <div class="text-xs text-gray-500">
                                        Origen: {{ $mov->ubicacionOrigen ? ($mov->ubicacionOrigen->nombre . ' — ' . ($mov->ubicacionOrigen->area->nombre ?? '')) : 'N/A' }}<br>
                                        Destino: {{ $mov->ubicacionDestino ? ($mov->ubicacionDestino->nombre . ' — ' . ($mov->ubicacionDestino->area->nombre ?? '')) : 'N/A' }}
                                    </div>
                                    @if($mov->motivo)
                                        <div class="mt-2 text-sm text-gray-700">Motivo: {{ $mov->motivo }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">No hay movimientos de ubicación para este activo.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
