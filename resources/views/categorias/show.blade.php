@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Categoría: {{ $categoria->nombre }}</h1>
                <div class="flex space-x-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $categoria->depreciable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $categoria->depreciable ? 'Depreciable' : 'No depreciable' }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $categoria->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $categoria->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">ID</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $categoria->id_categoria }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Nombre</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $categoria->nombre }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Vida Útil Estimada</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        @if($categoria->vida_util_estimada_meses)
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $categoria->vida_util_estimada_meses }} meses
                            </span>
                        @else
                            <span class="text-gray-400">No especificado</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($categoria->descripcion)
                <div class="mt-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Descripción</h3>
                        <p class="text-gray-900 leading-relaxed">{{ $categoria->descripcion }}</p>
                    </div>
                </div>
            @endif

            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Características</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 {{ $categoria->depreciable ? 'border-green-400' : 'border-red-400' }}">
                        <div class="flex items-center">
                            @if($categoria->depreciable)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-600">Depreciable</span>
                            @else
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-red-600">No depreciable</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $categoria->depreciable ? 'Los activos de esta categoría se deprecian con el tiempo' : 'Los activos de esta categoría no se deprecian' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border-l-4 {{ $categoria->activo ? 'border-green-400' : 'border-gray-400' }}">
                        <div class="flex items-center">
                            @if($categoria->activo)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-600">Categoría Activa</span>
                            @else
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600">Categoría Inactiva</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $categoria->activo ? 'Esta categoría está disponible para crear nuevos tipos' : 'Esta categoría no está disponible para crear nuevos tipos' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('categorias.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Listado
                    </a>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('categorias.edit', $categoria) }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
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
