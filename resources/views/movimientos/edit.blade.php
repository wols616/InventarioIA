@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Editar Movimiento #{{ $movimiento->id_movimiento ?? $movimiento->id }}</h1>
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

            <form action="{{ route('movimientos.update', $movimiento->id_movimiento ?? $movimiento->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="id_activo" class="block text-sm font-medium text-gray-700 mb-2">Activo *</label>
                        <select name="id_activo" id="activo_select" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione activo --</option>
                            @foreach($activos as $a)
                                <option value="{{ $a->id_activo }}" data-ubicacion="{{ $a->id_ubicacion_actual }}" {{ (old('id_activo', $movimiento->id_activo) == $a->id_activo) ? 'selected' : '' }}>{{ $a->codigo }} - {{ $a->marca }} {{ $a->modelo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_ubicacion_origen" class="block text-sm font-medium text-gray-700 mb-2">Ubicación Origen</label>
                        <select name="id_ubicacion_origen" id="origen_select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- (se establecerá al elegir activo) --</option>
                            @foreach($ubicaciones as $u)
                                <option value="{{ $u->id_ubicacion }}" {{ old('id_ubicacion_origen', $movimiento->id_ubicacion_origen) == $u->id_ubicacion ? 'selected' : '' }}>{{ $u->nombre }} ({{ $u->codigo_interno ?? '' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_ubicacion_destino" class="block text-sm font-medium text-gray-700 mb-2">Ubicación Destino *</label>
                        <select name="id_ubicacion_destino" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione destino --</option>
                            @foreach($ubicaciones as $u)
                                <option value="{{ $u->id_ubicacion }}" {{ old('id_ubicacion_destino', $movimiento->id_ubicacion_destino) == $u->id_ubicacion ? 'selected' : '' }}>{{ $u->nombre }} ({{ $u->codigo_interno ?? '' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="fecha_movimiento" class="block text-sm font-medium text-gray-700 mb-2">Fecha Movimiento *</label>
                        <input type="date" name="fecha_movimiento" id="fecha_movimiento" value="{{ old('fecha_movimiento', (isset($movimiento->fecha_movimiento) && $movimiento->fecha_movimiento) ? \Carbon\Carbon::parse($movimiento->fecha_movimiento)->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div class="md:col-span-2">
                        <label for="motivo" class="block text-sm font-medium text-gray-700 mb-2">Motivo</label>
                        <textarea name="motivo" id="motivo" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">{{ old('motivo', $movimiento->motivo) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('movimientos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
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
        (function() {
            const activoSel = document.getElementById('activo_select');
            const origenSel = document.getElementById('origen_select');

            function updateOrigen() {
                const o = activoSel.selectedOptions[0];
                if (!o || !o.value) {
                    origenSel.value = '';
                    return;
                }
                const ubic = o.dataset.ubicacion;
                if (ubic) {
                    const opt = Array.from(origenSel.options).find(x => x.value == ubic);
                    if (opt) opt.selected = true;
                }
            }
            activoSel.addEventListener('change', updateOrigen);
        })();
    </script>
@endsection