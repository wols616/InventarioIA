@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Mantenimiento #{{ $mantenimiento->id_mantenimiento ?? $mantenimiento->id }}</h1>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    Mantenimiento
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Activo</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $mantenimiento->activo ? $mantenimiento->activo->codigo : 'N/A' }}
                    </p>
                    @if($mantenimiento->activo)
                        <p class="text-sm text-gray-600">
                            {{ trim(($mantenimiento->activo->marca ?? '') . ' ' . ($mantenimiento->activo->modelo ?? '')) }}
                        </p>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Tipo de Mantenimiento</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $mantenimiento->tipo_mantenimiento ?? 'No especificado' }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Costo</h3>
                    <p class="text-lg font-semibold text-green-600">
                        @if($mantenimiento->costo)
                            ${{ number_format($mantenimiento->costo, 2) }}
                        @else
                            Sin especificar
                        @endif
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha de Inicio</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $mantenimiento->fecha_inicio ? \Carbon\Carbon::parse($mantenimiento->fecha_inicio)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha de Fin</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $mantenimiento->fecha_fin ? \Carbon\Carbon::parse($mantenimiento->fecha_fin)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>

                @if($mantenimiento->fecha_inicio && $mantenimiento->fecha_fin)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Duración</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($mantenimiento->fecha_inicio)->diffInDays(\Carbon\Carbon::parse($mantenimiento->fecha_fin)) + 1 }} días
                    </p>
                </div>
                @endif
            </div>

            @if($mantenimiento->anotacion)
                <div class="mt-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Anotaciones</h3>
                        <p class="text-gray-900 leading-relaxed">
                            {{ $mantenimiento->anotacion }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('mantenimientos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Listado
                    </a>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('mantenimientos.edit', $mantenimiento->id_mantenimiento ?? $mantenimiento->id) }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
