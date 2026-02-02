@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Tipo #{{ $tipo->id_tipo }}</h1>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    Tipo de Activo
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Nombre</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $tipo->nombre }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Categoría</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $tipo->categoria ? $tipo->categoria->nombre : 'Sin categoría' }}
                    </p>
                </div>

                @if($tipo->descripcion)
                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2 lg:col-span-1">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Descripción</h3>
                    <p class="text-sm text-gray-900">{{ $tipo->descripcion }}</p>
                </div>
                @endif
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Requisitos</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 {{ $tipo->requiere_serie ? 'border-green-400' : 'border-gray-300' }}">
                        <div class="flex items-center">
                            @if($tipo->requiere_serie)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-600">Requiere Serie</span>
                            @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-sm text-gray-500">No requiere Serie</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 {{ $tipo->requiere_marca ? 'border-blue-400' : 'border-gray-300' }}">
                        <div class="flex items-center">
                            @if($tipo->requiere_marca)
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-600">Requiere Marca</span>
                            @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-sm text-gray-500">No requiere Marca</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 {{ $tipo->requiere_modelo ? 'border-purple-400' : 'border-gray-300' }}">
                        <div class="flex items-center">
                            @if($tipo->requiere_modelo)
                                <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-purple-600">Requiere Modelo</span>
                            @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-sm text-gray-500">No requiere Modelo</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 {{ $tipo->requiere_especificaciones ? 'border-yellow-400' : 'border-gray-300' }}">
                        <div class="flex items-center">
                            @if($tipo->requiere_especificaciones)
                                <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-yellow-600">Requiere Especificaciones</span>
                            @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-sm text-gray-500">No requiere Especificaciones</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('tipos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Listado
                    </a>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('tipos.edit', $tipo) }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
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
