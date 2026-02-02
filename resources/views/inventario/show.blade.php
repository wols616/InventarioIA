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
    </div>
@endsection
