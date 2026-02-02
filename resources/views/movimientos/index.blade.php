@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Movimientos de Activos</h1>
                @if(isset($authUser) && in_array(($authUser->persona->rol->nombre ?? ''), ['Admin','Supervisor']))
                    <a href="{{ route('movimientos.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Movimiento
                    </a>
                @else
                    @include('partials.disabled-button', ['label' => 'Crear Movimiento'])
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($movimientos as $m)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $m->id_movimiento }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $m->activo ? ($m->activo->codigo . ' - ' . trim(($m->activo->marca ?? '') . ' ' . ($m->activo->modelo ?? ''))) : $m->id_activo }}
                        </td>
                        <td class="px-6 py-4">
                            @if($m->ubicacionOrigen)
                                <div class="text-sm font-medium text-gray-900">{{ $m->ubicacionOrigen->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $m->ubicacionOrigen->codigo_interno ?? '' }}</div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($m->ubicacionDestino)
                                <div class="text-sm font-medium text-gray-900">{{ $m->ubicacionDestino->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $m->ubicacionDestino->codigo_interno ?? '' }}</div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $m->fecha_movimiento ? \Carbon\Carbon::parse($m->fecha_movimiento)->format('Y-m-d') : '' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $m->motivo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('movimientos.show', $m) }}" class="text-brand-600 hover:text-brand-900">Ver</a>
                            @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                                <a href="{{ route('movimientos.edit', $m) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form action="{{ route('movimientos.destroy', $m) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar?')" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            @elseif(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Supervisor')
                                <a href="{{ route('movimientos.edit', $m) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
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
    <div class="mt-6">{{ $movimientos->links() }}</div>
@endsection
