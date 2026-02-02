@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Editar Área #{{ $area->id_area }}</h1>
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

            <form action="{{ route('areas.update', $area) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edificio_select" class="block text-sm font-medium text-gray-700 mb-2">Edificio *</label>
                        <select id="edificio_select" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione Edificio --</option>
                            @foreach($edificios as $ed)
                                <option value="{{ $ed->id_edificio }}" {{ (optional($area->piso)->id_edificio == $ed->id_edificio) ? 'selected' : '' }}>{{ $ed->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_piso" class="block text-sm font-medium text-gray-700 mb-2">Piso *</label>
                        <select name="id_piso" id="piso_select" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione Piso --</option>
                            @foreach($pisos as $p)
                                <option value="{{ $p->id_piso }}" data-edificio-id="{{ $p->id_edificio }}" {{ (old('id_piso', $area->id_piso) == $p->id_piso) ? 'selected' : '' }}>{{ optional($p->edificio)->nombre }} - Piso {{ $p->numero_piso }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $area->nombre) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Nombre del área">
                    </div>

                    <div>
                        <label for="tipo_area" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Área</label>
                        <input type="text" name="tipo_area" id="tipo_area" value="{{ old('tipo_area', $area->tipo_area) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Ej: Oficina, Almacén, Laboratorio">
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select name="estado" id="estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="1" {{ $area->estado ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$area->estado ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span class="text-sm text-gray-600">¿Necesitas gestionar pisos?</span>
                            <a href="{{ route('pisos.index') }}" class="ml-2 text-brand-600 hover:text-brand-800 text-sm font-medium">Gestionar Pisos</a>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm text-gray-600">¿Necesitas gestionar edificios?</span>
                            <a href="{{ route('edificios.index') }}" class="ml-2 text-brand-600 hover:text-brand-800 text-sm font-medium">Gestionar Edificios</a>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('areas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        (function(){
            const edSelect = document.getElementById('edificio_select');
            const pisoSelect = document.getElementById('piso_select');

            function filterPisos(){
                const eid = edSelect.value;
                for(const opt of pisoSelect.options){
                    if(!opt.value) continue;
                    const match = opt.dataset.edificioId === eid;
                    opt.style.display = match ? '' : 'none';
                    if(!match) opt.selected = false;
                }
            }

            edSelect.addEventListener('change', filterPisos);
            (function init(){
                const selectedPiso = pisoSelect.querySelector('option[selected]');
                if(selectedPiso){
                    const edid = selectedPiso.dataset.edificioId;
                    if(edid){ edSelect.value = edid; }
                }
                filterPisos();
            })();
        })();
    </script>
@endsection
