@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Editar Activo #{{ $activo->id_activo }}</h1>
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

            <form action="{{ route('activos.update', $activo) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_tipo" class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                        <select name="id_tipo" id="id_tipo" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione tipo --</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id_tipo }}" {{ (old('id_tipo', $activo->id_tipo) == $tipo->id_tipo) ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_estado" class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                        <select name="id_estado" id="id_estado" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione estado --</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ (old('id_estado', $activo->id_estado) == $estado->id_estado) ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_edificio_select" class="block text-sm font-medium text-gray-700 mb-2">Edificio</label>
                        <select id="id_edificio_select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Todos los Edificios --</option>
                            @foreach($edificios as $ed)
                                <option value="{{ $ed->id_edificio }}">{{ $ed->nombre }}</option>
                            @endforeach
                        </select>

                        <label for="id_area_select" class="block text-sm font-medium text-gray-700 mb-2 mt-4">Área</label>
                        <select id="id_area_select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Todas las Áreas --</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id_area }}" data-edificio="{{ $area->piso ? $area->piso->id_edificio : '' }}">{{ $area->nombre }}</option>
                            @endforeach
                        </select>

                        <label for="id_ubicacion_actual" class="block text-sm font-medium text-gray-700 mb-2 mt-4">Ubicación</label>
                        <select name="id_ubicacion_actual" id="id_ubicacion_actual" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Sin ubicación --</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id_ubicacion }}" data-area="{{ $ubicacion->id_area }}" {{ (old('id_ubicacion_actual', $activo->id_ubicacion_actual) == $ubicacion->id_ubicacion) ? 'selected' : '' }}>
                                    {{ $ubicacion->nombre }}@if($ubicacion->area) ({{ $ubicacion->area->nombre }})@endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="codigo" class="block text-sm font-medium text-gray-700 mb-2">Código *</label>
                        <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $activo->codigo) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-700 mb-2">Marca</label>
                        <input type="text" name="marca" id="marca" value="{{ old('marca', $activo->marca) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="modelo" class="block text-sm font-medium text-gray-700 mb-2">Modelo</label>
                        <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $activo->modelo) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="numero_serie" class="block text-sm font-medium text-gray-700 mb-2">Número de Serie</label>
                        <input type="text" name="numero_serie" id="numero_serie" value="{{ old('numero_serie', $activo->numero_serie) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="fecha_adquisicion" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Adquisición</label>
                        <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" value="{{ old('fecha_adquisicion', optional($activo->fecha_adquisicion)->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="valor_adquisicion" class="block text-sm font-medium text-gray-700 mb-2">Valor de Adquisición</label>
                        <input type="number" step="0.01" name="valor_adquisicion" id="valor_adquisicion" value="{{ old('valor_adquisicion', $activo->valor_adquisicion) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('activos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Activo
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        (function(){
            const areas = @json($areas);
            const ubicaciones = @json($ubicaciones);
            const edificioSelect = document.getElementById('id_edificio_select');
            const areaSelect = document.getElementById('id_area_select');
            const ubicSelect = document.getElementById('id_ubicacion_actual');

            function populateAreas(edificioId){
                const current = areaSelect.value;
                areaSelect.innerHTML = '<option value="">-- Todas las Áreas --</option>';
                areas.forEach(a => {
                    const edificioOfArea = a.piso ? a.piso.id_edificio : null;
                    if(!edificioId || String(edificioOfArea) === String(edificioId)){
                        const opt = document.createElement('option');
                        opt.value = a.id_area;
                        opt.textContent = a.nombre;
                        opt.dataset.edificio = edificioOfArea || '';
                        areaSelect.appendChild(opt);
                    }
                });
                if(current) areaSelect.value = current;
            }

            function populateUbicaciones(areaId){
                const prev = ubicSelect.value;
                ubicSelect.innerHTML = '<option value="">-- Sin ubicación --</option>';
                ubicaciones.forEach(u => {
                    if(!areaId || String(u.id_area) === String(areaId)){
                        const opt = document.createElement('option');
                        opt.value = u.id_ubicacion;
                        opt.textContent = (u.area && u.area.nombre ? u.area.nombre + ' - ' : '') + u.nombre;
                        opt.dataset.area = u.id_area;
                        if(String(u.id_ubicacion) === String(prev)) opt.selected = true;
                        ubicSelect.appendChild(opt);
                    }
                });
            }

            edificioSelect.addEventListener('change', function(e){
                populateAreas(e.target.value);
                populateUbicaciones('');
            });

            areaSelect.addEventListener('change', function(e){
                populateUbicaciones(e.target.value);
            });

            // initialize selects based on current activo value if present
            const oldUbic = @json(old('id_ubicacion_actual', $activo->id_ubicacion_actual));
            if(oldUbic){
                const selU = ubicaciones.find(u => String(u.id_ubicacion) === String(oldUbic));
                const areaId = selU ? selU.id_area : null;
                const areaObj = areas.find(a => String(a.id_area) === String(areaId));
                const edificioId = areaObj && areaObj.piso ? areaObj.piso.id_edificio : null;
                if(edificioId){
                    edificioSelect.value = edificioId;
                }
                populateAreas(edificioId);
                if(areaId) areaSelect.value = areaId;
                populateUbicaciones(areaId);
                if(oldUbic) ubicSelect.value = oldUbic;
            } else {
                populateAreas('');
                populateUbicaciones('');
            }
        })();
    </script>

    @endsection
