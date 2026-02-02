@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="id_activo" class="block text-sm font-medium text-gray-700 mb-2">Activo *</label>
        <select name="id_activo" id="id_activo" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            <option value="">-- Seleccione activo --</option>
                @foreach($activos as $activo)
                    <option value="{{ $activo->id_activo }}" {{ (old('id_activo', optional($asignacion)->id_activo ?? '') == $activo->id_activo) ? 'selected' : '' }}>{{ $activo->codigo }} - {{ $activo->marca }} {{ $activo->modelo }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="id_persona" class="block text-sm font-medium text-gray-700 mb-2">Persona *</label>
        <select name="id_persona" id="id_persona" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            <option value="">-- Seleccione persona --</option>
            @foreach($personas as $persona)
                <option value="{{ $persona->id_persona }}" {{ (old('id_persona', optional($asignacion)->id_persona ?? '') == $persona->id_persona) ? 'selected' : '' }}>{{ $persona->nombre }} {{ $persona->apellido }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="fecha_asignacion" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Asignación *</label>
        <input type="date" name="fecha_asignacion" id="fecha_asignacion" value="{{ old('fecha_asignacion', optional(optional($asignacion)->fecha_asignacion)->format('Y-m-d') ?? date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" />
    </div>

    <div>
        <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', optional(optional($asignacion)->fecha_fin)->format('Y-m-d') ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent" />
    </div>

    <div class="md:col-span-2">
        <div class="space-y-4">
            <div class="flex items-center">
                <input type="checkbox" name="es_responsable_principal" id="es_responsable_principal" value="1" {{ old('es_responsable_principal', optional($asignacion)->es_responsable_principal ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                <label for="es_responsable_principal" class="ml-2 text-sm text-gray-700">Responsable principal</label>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="estado" id="estado" value="1" {{ old('estado', optional($asignacion)->estado ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                <label for="estado" class="ml-2 text-sm text-gray-700">Asignación activa</label>
            </div>
        </div>
    </div>
</div>

<div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        Guardar
    </button>
</div>
