@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Asignación #{{ $asignacion->id_asignacion }}</h1>
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $asignacion->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $asignacion->estado ? 'Activa' : 'Inactiva' }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Activo</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ optional($asignacion->activo)->codigo ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        {{ optional($asignacion->activo)->marca }} {{ optional($asignacion->activo)->modelo }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Persona Asignada</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ optional($asignacion->persona)->nombre }} {{ optional($asignacion->persona)->apellido }}
                    </p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha de Asignación</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ optional($asignacion->fecha_asignacion)->format('d/m/Y') ?? 'N/A' }}
                    </p>
                </div>

                @if($asignacion->fecha_fin)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha de Fin</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ optional($asignacion->fecha_fin)->format('d/m/Y') }}
                    </p>
                </div>
                @endif

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Responsable Principal</h3>
                    <div class="flex items-center">
                        @if($asignacion->es_responsable_principal)
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-lg font-semibold text-green-600">Sí</span>
                        @else
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="text-lg font-semibold text-red-600">No</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('asignaciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Listado
                    </a>
                    
                    <div class="flex space-x-3">
                            @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                            <a href="{{ route('asignaciones.edit', $asignacion->id_asignacion) }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
