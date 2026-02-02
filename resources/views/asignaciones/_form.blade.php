@csrf

<div>
    <label>Activo</label>
    <select name="id_activo" required>
        <option value="">-- Seleccione activo --</option>
            @foreach($activos as $activo)
                <option value="{{ $activo->id_activo }}" {{ (old('id_activo', optional($asignacion)->id_activo ?? '') == $activo->id_activo) ? 'selected' : '' }}>{{ $activo->codigo }} - {{ $activo->marca }} {{ $activo->modelo }}</option>
        @endforeach
    </select>
</div>

<div>
    <label>Persona</label>
    <select name="id_persona" required>
        <option value="">-- Seleccione persona --</option>
        @foreach($personas as $persona)
            <option value="{{ $persona->id_persona }}" {{ (old('id_persona', optional($asignacion)->id_persona ?? '') == $persona->id_persona) ? 'selected' : '' }}>{{ $persona->nombre }} {{ $persona->apellido }}</option>
        @endforeach
    </select>
</div>

<div>
    <label>Fecha asignación</label>
    <input type="date" name="fecha_asignacion" value="{{ old('fecha_asignacion', optional(optional($asignacion)->fecha_asignacion)->format('Y-m-d') ?? date('Y-m-d')) }}" required />
</div>

<div>
    <label>Fecha fin</label>
    <input type="date" name="fecha_fin" value="{{ old('fecha_fin', optional(optional($asignacion)->fecha_fin)->format('Y-m-d') ?? '') }}" />
</div>

<div>
    <label>
        <input type="checkbox" name="es_responsable_principal" value="1" {{ old('es_responsable_principal', optional($asignacion)->es_responsable_principal ?? false) ? 'checked' : '' }} /> Responsable principal
    </label>
</div>

<div>
    <label>
        <input type="checkbox" name="estado" value="1" {{ old('estado', optional($asignacion)->estado ?? true) ? 'checked' : '' }} /> Activa
    </label>
</div>

<div>
    <button type="submit">Guardar</button>
</div>
