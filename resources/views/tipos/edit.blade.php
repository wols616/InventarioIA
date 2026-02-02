@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Editar Tipo #{{ $tipo->id_tipo }}</h1>
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

            <form action="{{ route('tipos.update', $tipo) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="id_categoria" class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
                        <select name="id_categoria" id="id_categoria" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione categoría --</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}" {{ (old('id_categoria', $tipo->id_categoria) == $cat->id_categoria) ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $tipo->nombre) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div class="md:col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">{{ old('descripcion', $tipo->descripcion) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Requisitos</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="requiere_serie" value="1" {{ old('requiere_serie', $tipo->requiere_serie) ? 'checked' : '' }} class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                                    <span class="text-sm font-medium text-gray-700">Requiere número de serie</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="requiere_marca" value="1" {{ old('requiere_marca', $tipo->requiere_marca) ? 'checked' : '' }} class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                                    <span class="text-sm font-medium text-gray-700">Requiere marca</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="requiere_modelo" value="1" {{ old('requiere_modelo', $tipo->requiere_modelo) ? 'checked' : '' }} class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                                    <span class="text-sm font-medium text-gray-700">Requiere modelo</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="requiere_especificaciones" value="1" {{ old('requiere_especificaciones', $tipo->requiere_especificaciones) ? 'checked' : '' }} class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                                    <span class="text-sm font-medium text-gray-700">Requiere especificaciones</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('tipos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
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
@endsection
