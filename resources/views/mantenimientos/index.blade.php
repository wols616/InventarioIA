@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Mantenimientos</h1>
                @if(isset($authUser) && in_array(($authUser->persona->rol->nombre ?? ''), ['Admin','Supervisor']))
                    <a href="{{ route('mantenimientos.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Crear Mantenimiento
                    </a>
                @elseif(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor')
                    @include('partials.disabled-button', ['label' => 'Crear Mantenimiento'])
                @endif
            </div>
        </div>

        <!-- Barra de búsqueda y filtros -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <form method="GET" action="{{ route('mantenimientos.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-48">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Buscar</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                               placeholder="Código, marca, modelo, anotación..."
                               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-brand-500 focus:border-brand-500">
                        <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tipo</label>
                    <select name="tipo" class="py-2 px-3 text-sm border border-gray-300 rounded-md focus:ring-brand-500 focus:border-brand-500">
                        <option value="">Todos</option>
                        <option value="Preventivo" {{ ($filters['tipo'] ?? '') === 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                        <option value="Correctivo" {{ ($filters['tipo'] ?? '') === 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                        <option value="Predictivo" {{ ($filters['tipo'] ?? '') === 'Predictivo' ? 'selected' : '' }}>Predictivo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Desde</label>
                    <input type="date" name="fecha_desde" value="{{ $filters['fecha_desde'] ?? '' }}"
                           class="py-2 px-3 text-sm border border-gray-300 rounded-md focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Hasta</label>
                    <input type="date" name="fecha_hasta" value="{{ $filters['fecha_hasta'] ?? '' }}"
                           class="py-2 px-3 text-sm border border-gray-300 rounded-md focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium py-2 px-4 rounded-md transition">
                        Filtrar
                    </button>
                    @if(array_filter($filters ?? []))
                        <a href="{{ route('mantenimientos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-4 rounded-md transition">Limpiar</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Costo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($mantenimientos as $m)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $m->id_mantenimiento }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $m->activo ? ($m->activo->codigo . ' - ' . trim(($m->activo->marca ?? '') . ' ' . ($m->activo->modelo ?? ''))) : $m->id_activo }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $m->tipo_mantenimiento }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $m->fecha_inicio ? \Carbon\Carbon::parse($m->fecha_inicio)->format('Y-m-d') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $m->fecha_fin ? \Carbon\Carbon::parse($m->fecha_fin)->format('Y-m-d') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($m->costo)
                                ${{ number_format($m->costo, 2) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('mantenimientos.show', $m) }}" class="text-brand-600 hover:text-brand-900">Ver</a>
                            @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                                <a href="{{ route('mantenimientos.edit', $m) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form action="{{ route('mantenimientos.destroy', $m) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar?')" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            @elseif(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Supervisor')
                                <a href="{{ route('mantenimientos.edit', $m) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            @elseif(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor')
                                @include('partials.disabled-button', ['label' => 'Editar'])
                                @include('partials.disabled-button', ['label' => 'Eliminar'])
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-6">{{ $mantenimientos->links() }}</div>
@endsection
