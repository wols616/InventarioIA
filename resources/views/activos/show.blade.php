@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Activo #{{ $activo->id_activo }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('activos.edit', $activo) }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('activos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Código</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $activo->codigo }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Marca</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $activo->marca ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Modelo</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $activo->modelo ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Número de Serie</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $activo->numero_serie ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Estado</label>
                        <p class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $activo->estado ? $activo->estado->nombre : '-' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Ubicación</label>
                        @if($activo->ubicacion)
                            <div class="mt-1">
                                <p class="text-sm font-medium text-gray-900">{{ $activo->ubicacion->nombre }}</p>
                                <p class="text-sm text-gray-500">{{ $activo->ubicacion->codigo_interno ?? '' }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $activo->ubicacion->area ? $activo->ubicacion->area->nombre : '-' }}
                                    @if(optional($activo->ubicacion->area)->piso)
                                        / Piso {{ optional($activo->ubicacion->area->piso)->numero_piso }}
                                    @endif
                                    @if(optional(optional($activo->ubicacion->area)->piso)->edificio)
                                        / {{ optional(optional($activo->ubicacion->area)->piso->edificio)->nombre }}
                                    @endif
                                </p>
                            </div>
                        @else
                            <p class="mt-1 text-sm text-gray-400">Sin ubicación asignada</p>
                        @endif
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Fecha de Adquisición</label>
                        <p class="mt-1 text-sm text-gray-900">{{ optional($activo->fecha_adquisicion)->format('Y-m-d') ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Valor de Adquisición</label>
                        <p class="mt-1 text-sm text-gray-900">${{ number_format($activo->valor_adquisicion, 2) ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
