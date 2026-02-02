@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Editar Ubicación #{{ $ubicacion->id_ubicacion }}</h1>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron errores:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('ubicaciones.update', $ubicacion) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_area" class="block text-sm font-medium text-gray-700 mb-2">Área *</label>
                        <select name="id_area" id="area_select" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione área --</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id_area }}"
                                    data-piso-num="{{ optional($area->piso)->numero_piso }}"
                                    data-piso-id="{{ optional($area->piso)->id_piso }}"
                                    data-edificio-nombre="{{ optional(optional($area->piso)->edificio)->nombre }}"
                                    {{ (old('id_area', $ubicacion->id_area) == $area->id_area) ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $ubicacion->nombre) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="codigo_interno" class="block text-sm font-medium text-gray-700 mb-2">Código Interno</label>
                        <input type="text" name="codigo_interno" id="codigo_interno" value="{{ old('codigo_interno', $ubicacion->codigo_interno) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="estado" value="1" id="estado" {{ old('estado', $ubicacion->estado) ? 'checked' : '' }} class="focus:ring-brand-500 h-4 w-4 text-brand-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="estado" class="font-medium text-gray-700">Estado Activo</label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="descripcion_detallada" class="block text-sm font-medium text-gray-700 mb-2">Descripción Detallada</label>
                        <textarea name="descripcion_detallada" id="descripcion_detallada" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Descripción de la ubicación...">{{ old('descripcion_detallada', $ubicacion->descripcion_detallada) }}</textarea>
                    </div>
                </div>

                <div id="area_info" class="bg-blue-50 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Información del Área</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p><strong>Edificio:</strong> <span id="ai_edificio">{{ optional(optional($ubicacion->area)->piso->edificio)->nombre ?? '-' }}</span></p>
                                <p><strong>Piso:</strong> <span id="ai_piso">{{ optional(optional($ubicacion->area)->piso)->numero_piso ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="text-sm text-gray-600">¿No encuentra el área que busca?</span>
                        <a href="{{ route('areas.index') }}" class="ml-2 text-brand-600 hover:text-brand-800 text-sm font-medium">Gestionar Áreas</a>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('ubicaciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function(){
            const sel = document.getElementById('area_select');
            const ed = document.getElementById('ai_edificio');
            const pi = document.getElementById('ai_piso');
            function update(){
                const o = sel.selectedOptions[0];
                if(!o || !o.value){ ed.textContent = '-'; pi.textContent = '-'; return; }
                ed.textContent = o.dataset.edificioNombre || '-';
                pi.textContent = o.dataset.pisoNum || '-';
            }
            sel.addEventListener('change', update);
            update();
        })();
    </script>

@endsection
