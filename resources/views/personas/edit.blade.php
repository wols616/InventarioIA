@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Editar Persona #{{ $persona->id_persona }}
            </h1>
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

            <form action="{{ route('personas.update', $persona) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_rol" class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                        <select name="id_rol" id="id_rol" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione rol --</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->id_rol }}" {{ (old('id_rol', $persona->id_rol) == $r->id_rol) ? 'selected' : '' }}>{{ $r->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_departamento" class="block text-sm font-medium text-gray-700 mb-2">Departamento *</label>
                        <select name="id_departamento" id="id_departamento" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione departamento --</option>
                            @foreach($departamentos as $d)
                                <option value="{{ $d->id_departamento }}" {{ (old('id_departamento', $persona->id_departamento) == $d->id_departamento) ? 'selected' : '' }}>{{ $d->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $persona->nombre) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Nombre de la persona">
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">Apellido *</label>
                        <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $persona->apellido) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Apellido de la persona">
                    </div>

                    <div>
                        <label for="dui" class="block text-sm font-medium text-gray-700 mb-2">DUI</label>
                        <input type="text" name="dui" id="dui" value="{{ old('dui', $persona->dui) }}" maxlength="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="12345678-9">
                        <p class="mt-1 text-xs text-gray-500">Opcional: número de documento de identidad</p>
                    </div>

                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" value="{{ old('correo', $persona->correo) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="correo@ejemplo.com">
                    </div>

                    <div class="md:col-span-2">
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                        <select name="estado" id="estado" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="1" {{ (string)old('estado', $persona->estado) === '1' || $persona->estado ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ (string)old('estado', $persona->estado) === '0' || $persona->estado === 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="bg-indigo-50 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-indigo-800">Información sobre la actualización</h3>
                            <div class="mt-2 text-sm text-indigo-700">
                                <p>Los cambios en el rol o departamento pueden afectar los permisos y responsabilidades de la persona.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('personas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
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
    document.addEventListener('DOMContentLoaded', function(){
        const dui = document.getElementById('dui');
        if(!dui) return;
        dui.setAttribute('maxlength','10');
        dui.addEventListener('input', function(){
            let digits = this.value.replace(/\D/g, '');
            if (digits.length > 9) digits = digits.slice(0,9);
            if (digits.length > 8) {
                this.value = digits.slice(0,8) + '-' + digits.slice(8);
            } else {
                this.value = digits;
            }
        });
    });
    </script>
    @endsection
