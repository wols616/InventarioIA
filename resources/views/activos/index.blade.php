@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Gestión de Activos</h1>
                <a href="{{ route('activos.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Crear Activo
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <form method="GET" action="{{ route('activos.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div>
                        <input type="text" name="codigo" placeholder="Código" value="{{ request('codigo') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                    <div>
                        <input type="text" name="marca" placeholder="Marca" value="{{ request('marca') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                    <div>
                        <input type="text" name="modelo" placeholder="Modelo" value="{{ request('modelo') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                    <div>
                        <select name="id_tipo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Tipo --</option>
                            @foreach($tipos as $t)
                                <option value="{{ $t->id_tipo }}" {{ request('id_tipo') == $t->id_tipo ? 'selected' : '' }}>{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="id_estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Estado --</option>
                            @foreach($estados as $e)
                                <option value="{{ $e->id_estado }}" {{ request('id_estado') == $e->id_estado ? 'selected' : '' }}>{{ $e->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="id_ubicacion_actual" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Ubicación --</option>
                            @foreach($ubicaciones as $u)
                                <option value="{{ $u->id_ubicacion }}" {{ request('id_ubicacion_actual') == $u->id_ubicacion ? 'selected' : '' }}>{{ $u->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="include_deleted" value="1" {{ request()->boolean('include_deleted') ? 'checked' : '' }} class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Incluir Eliminados</span>
                    </label>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                            Filtrar
                        </button>
                        <a href="{{ route('activos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modelo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Adquisición</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($activos as $activo)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $activo->id_activo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activo->codigo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activo->marca }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activo->modelo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ $activo->estado ? $activo->estado->nombre : '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($activo->ubicacion)
                                <div class="text-sm font-medium text-gray-900">{{ $activo->ubicacion->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $activo->ubicacion->codigo_interno ?? '' }}</div>
                                <div class="text-xs text-gray-400">{{ $activo->ubicacion->area ? $activo->ubicacion->area->nombre : '' }}
                                @if(optional($activo->ubicacion->area)->piso)
                                    / Piso {{ optional($activo->ubicacion->area->piso)->numero_piso }}
                                @endif
                                @if(optional(optional($activo->ubicacion->area)->piso)->edificio)
                                    / {{ optional(optional($activo->ubicacion->area)->piso->edificio)->nombre }}
                                @endif
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($activo->fecha_adquisicion)->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($activo->valor_adquisicion, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('activos.show', $activo) }}" class="text-brand-600 hover:text-brand-900">Ver</a>
                            <a href="{{ route('documentos.index', ['activo' => $activo->id_activo]) }}" class="text-brand-600 hover:text-brand-900">Docs</a>
                            <a href="{{ route('inventario.index') }}?activo={{ $activo->id_activo }}" class="text-brand-600 hover:text-brand-900">Inv</a>
                            <a href="{{ route('activos.edit', $activo) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            <form action="{{ route('activos.destroy', $activo) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar?')" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-6">{{ $activos->links() }}</div>
@endsection
