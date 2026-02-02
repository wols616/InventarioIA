@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Movimiento #{{ $movimiento->id_movimiento ?? $movimiento->id }}</h1>
                <a href="{{ route('movimientos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
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
                            {{ $movimiento->activo->codigo ?? '' }} - {{ $movimiento->activo->marca ?? '' }} {{ $movimiento->activo->modelo ?? '' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Ubicación Origen</label>
                        @if($movimiento->ubicacionOrigen)
                            <div class="mt-1">
                                <p class="text-sm font-medium text-gray-900">{{ $movimiento->ubicacionOrigen->nombre }}</p>
                                <p class="text-sm text-gray-500">{{ $movimiento->ubicacionOrigen->codigo_interno ?? '' }}</p>
                            </div>
                        @else
                            <p class="mt-1 text-sm text-gray-400">No especificada</p>
                        @endif
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Ubicación Destino</label>
                        @if($movimiento->ubicacionDestino)
                            <div class="mt-1">
                                <p class="text-sm font-medium text-gray-900">{{ $movimiento->ubicacionDestino->nombre }}</p>
                                <p class="text-sm text-gray-500">{{ $movimiento->ubicacionDestino->codigo_interno ?? '' }}</p>
                            </div>
                        @else
                            <p class="mt-1 text-sm text-gray-400">No especificada</p>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fecha del Movimiento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $movimiento->fecha_movimiento }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Motivo</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $movimiento->motivo ?: 'Sin motivo especificado' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
