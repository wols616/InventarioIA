@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Editar Auditoría #{{ $auditoria->id_auditoria }}</h1>
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

            @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                <form action="{{ route('auditorias.update', $auditoria) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_persona" class="block text-sm font-medium text-gray-700 mb-2">Persona *</label>
                        <select name="id_persona" id="id_persona" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione persona --</option>
                            @foreach($personas as $p)
                                <option value="{{ $p->id_persona }}" {{ old('id_persona', $auditoria->id_persona) == $p->id_persona ? 'selected' : '' }}>{{ $p->nombre }} {{ $p->apellido }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="fecha_auditoria" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Auditoría *</label>
                        <input type="date" name="fecha_auditoria" id="fecha_auditoria" value="{{ old('fecha_auditoria', $auditoria->fecha_auditoria ? \Carbon\Carbon::parse($auditoria->fecha_auditoria)->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Detalle de Auditoría</h3>
                        <button type="button" id="addDetalle" class="bg-brand-100 hover:bg-brand-200 text-brand-700 font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Agregar Activo
                        </button>
                    </div>

                    <div id="detalles" class="space-y-3">
                        @foreach($auditoria->detalles as $d)
                            <div class="detalle-row bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                    <div class="md:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Activo *</label>
                                        <select name="id_activo[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                                            <option value="">-- Seleccione activo --</option>
                                            @foreach($activos as $act)
                                                <option value="{{ $act->id_activo }}" {{ $d->id_activo == $act->id_activo ? 'selected' : '' }}>{{ $act->codigo }} - {{ $act->marca }} {{ $act->modelo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" name="coincide[]" value="1" {{ $d->coincide_con_sistema ? 'checked' : '' }} class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                                            <span class="text-sm font-medium text-gray-700">Coincide</span>
                                        </label>
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Anotaciones</label>
                                        <input type="text" name="anotaciones[]" value="{{ $d->anotaciones }}" placeholder="Observaciones..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                                    </div>
                                    <div class="md:col-span-1">
                                        <button type="button" class="remove w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-md transition duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('auditorias.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Auditoría
                    </button>
                </div>
                </form>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-600">No tiene permiso para editar esta auditoría.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        (function(){
            const activesHtml = `@foreach($activos as $act)<option value="{{ $act->id_activo }}">{{ addslashes($act->codigo . ' - ' . ($act->marca ?? '') . ' ' . ($act->modelo ?? '')) }}</option>@endforeach`;
            
            document.getElementById('addDetalle').addEventListener('click', function(){
                const c = document.createElement('div');
                c.className='detalle-row bg-gray-50 p-4 rounded-lg border border-gray-200';
                c.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Activo *</label>
                            <select name="id_activo[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                                <option value="">-- Seleccione activo --</option>
                                ${activesHtml}
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="coincide[]" value="1" class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                                <span class="text-sm font-medium text-gray-700">Coincide</span>
                            </label>
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Anotaciones</label>
                            <input type="text" name="anotaciones[]" placeholder="Observaciones..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                        </div>
                        <div class="md:col-span-1">
                            <button type="button" class="remove w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-md transition duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                document.getElementById('detalles').appendChild(c);
            });
            
            document.getElementById('detalles').addEventListener('click', function(e){
                if(e.target.closest('.remove')) {
                    e.target.closest('.detalle-row').remove();
                }
            });
        })();
    </script>
@endsection
