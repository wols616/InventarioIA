@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Gestión de Inventario</h1>
                @if(isset($authUser) && in_array(($authUser->persona->rol->nombre ?? ''), ['Admin','Supervisor']))
                    <a href="{{ route('inventario.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar Item
                    </a>
                @elseif(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor')
                    @include('partials.disabled-button', ['label' => 'Agregar Item'])
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($inventarios as $i)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $i->id_inventario }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $i->activo ? ($i->activo->codigo . ' - ' . trim(($i->activo->marca ?? '') . ' ' . ($i->activo->modelo ?? ''))) : $i->id_activo }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $i->cantidad < ($i->cantidad_minima ?: 0) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $i->cantidad }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $i->descripcion ?: '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i->cantidad_minima ?: '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i->cantidad_maxima ?: '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('inventario.show', $i) }}" class="text-brand-600 hover:text-brand-900">Ver</a>
                                @if(isset($authUser) && in_array(($authUser->persona->rol->nombre ?? ''), ['Admin','Supervisor']))
                                    <a href="{{ route('inventario.edit', $i) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                @endif
                                @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                                    <form action="{{ route('inventario.destroy', $i) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar?')" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
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
    <div class="mt-6">{{ $inventarios->links() }}</div>
@endsection
