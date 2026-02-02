@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Personas</h2>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apellido</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Correo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($personas as $persona)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $persona->id_persona }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $persona->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $persona->apellido }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $persona->correo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $persona->usuario ? $persona->usuario->username : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                                @if($persona->usuario)
                                    <a href="{{ route('usuarios.edit', $persona->usuario->id_usuario) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 mr-2">Editar</a>
                                    <form action="{{ route('usuarios.destroy', $persona->usuario->id_usuario) }}" method="POST" class="inline-block" onsubmit="return confirm('Desactivar usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Desactivar</button>
                                    </form>
                                @else
                                    <a href="{{ route('usuarios.create', $persona->id_persona) }}" class="bg-brand-600 text-white px-3 py-1 rounded hover:bg-brand-700">Crear usuario</a>
                                @endif
                            @else
                                @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Auditor')
                                    @if($persona->usuario)
                                        @include('partials.disabled-button', ['label' => 'Editar'])
                                        @include('partials.disabled-button', ['label' => 'Desactivar'])
                                    @else
                                        @include('partials.disabled-button', ['label' => 'Crear usuario'])
                                    @endif
                                @else
                                    {{ $persona->usuario ? '—' : '—' }}
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
