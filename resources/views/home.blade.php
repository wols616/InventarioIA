@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- Header Principal -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-brand-600 to-brand-700 px-6 py-8">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">Sistema de Inventario</h1>
                    <p class="text-brand-100 text-lg">Gestión integral de activos empresariales</p>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ \App\Models\Activo::count() ?? 0 }}</div>
                        <div class="text-sm text-blue-800">Activos Totales</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ \App\Models\Persona::count() ?? 0 }}</div>
                        <div class="text-sm text-green-800">Personal Registrado</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ \App\Models\UbicacionFisica::count() ?? 0 }}</div>
                        <div class="text-sm text-purple-800">Ubicaciones</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulos Principales -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Gestión de Activos -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z"></path>
                        </svg>
                        Gestión de Activos
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('activos.index') }}" class="block bg-blue-50 hover:bg-blue-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-blue-900">Activos</div>
                        <div class="text-sm text-blue-700">Administrar inventario de activos</div>
                    </a>
                    <a href="{{ route('tipos.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Tipos de Activo</div>
                        <div class="text-sm text-gray-700">Clasificación por tipo</div>
                    </a>
                    <a href="{{ route('categorias.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Categorías</div>
                        <div class="text-sm text-gray-700">Organización por categoría</div>
                    </a>
                    <a href="{{ route('estados.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Estados</div>
                        <div class="text-sm text-gray-700">Estados operacionales</div>
                    </a>
                </div>
            </div>

            <!-- Gestión de Ubicaciones -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Gestión de Ubicaciones
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('ubicaciones.index') }}" class="block bg-green-50 hover:bg-green-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-green-900">Ubicaciones Físicas</div>
                        <div class="text-sm text-green-700">Gestión de ubicaciones</div>
                    </a>
                    <a href="{{ route('areas.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Áreas</div>
                        <div class="text-sm text-gray-700">Administrar áreas</div>
                    </a>
                    <a href="{{ route('edificios.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Edificios</div>
                        <div class="text-sm text-gray-700">Gestión de edificios</div>
                    </a>
                    <a href="{{ route('pisos.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Pisos</div>
                        <div class="text-sm text-gray-700">Administrar pisos</div>
                    </a>
                </div>
            </div>

            <!-- Gestión de Personal -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                        Gestión de Personal
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('personas.index') }}" class="block bg-indigo-50 hover:bg-indigo-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-indigo-900">Personas</div>
                        <div class="text-sm text-indigo-700">Administrar personal</div>
                    </a>
                    <a href="{{ route('departamentos.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Departamentos</div>
                        <div class="text-sm text-gray-700">Gestión departamental</div>
                    </a>
                    <a href="{{ route('roles.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Roles</div>
                        <div class="text-sm text-gray-700">Administrar roles</div>
                    </a>
                </div>
            </div>

            <!-- Gestión Comercial -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Gestión Comercial
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('compras.index') }}" class="block bg-orange-50 hover:bg-orange-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-orange-900">Compras</div>
                        <div class="text-sm text-orange-700">Gestión de compras</div>
                    </a>
                    <a href="{{ route('proveedores.index') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                        <div class="font-medium text-gray-900">Proveedores</div>
                        <div class="text-sm text-gray-700">Administrar proveedores</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Acciones Rápidas</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if(!(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor'))
                        <a href="{{ route('activos.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-3 px-4 rounded-md transition duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nuevo Activo
                        </a>
                    @else
                        @include('partials.disabled-button', ['label' => 'Nuevo Activo'])
                    @endif
                    @if(!(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor'))
                        <a href="{{ route('personas.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-md transition duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Nueva Persona
                        </a>
                    @else
                        @include('partials.disabled-button', ['label' => 'Nueva Persona'])
                    @endif
                    @if(!(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor'))
                        <a href="{{ route('ubicaciones.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        Nueva Ubicación
                        </a>
                    @else
                        @include('partials.disabled-button', ['label' => 'Nueva Ubicación'])
                    @endif
                    @if(!(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor'))
                        <a href="{{ route('compras.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-4 rounded-md transition duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Nueva Compra
                        </a>
                    @else
                        @include('partials.disabled-button', ['label' => 'Nueva Compra'])
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-6">
            <div class="text-center">
                <div class="text-gray-600 mb-2">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Sistema de Inventario Empresarial
                </div>
                <div class="text-sm text-gray-500">
                    Versión 1.0 | Desarrollado con Laravel {{ app()->version() }}
                </div>
            </div>
        </div>
    </div>
@endsection