@extends('layouts.app')

@section('content')
    <h1>Editar Persona #{{ $persona->id_persona }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('personas.update', $persona) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Rol</label>
            <select name="id_rol" required>
                <option value="">-- Seleccione rol --</option>
                @foreach($roles as $r)
                    <option value="{{ $r->id_rol }}" {{ (old('id_rol', $persona->id_rol) == $r->id_rol) ? 'selected' : '' }}>{{ $r->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Departamento</label>
            <select name="id_departamento" required>
                <option value="">-- Seleccione departamento --</option>
                @foreach($departamentos as $d)
                    <option value="{{ $d->id_departamento }}" {{ (old('id_departamento', $persona->id_departamento) == $d->id_departamento) ? 'selected' : '' }}>{{ $d->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $persona->nombre) }}" required>
        </div>
        <div>
            <label>Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido', $persona->apellido) }}" required>
        </div>
        <div>
            <label>DUI</label>
            <input type="text" name="dui" value="{{ old('dui', $persona->dui) }}">
        </div>
        <div>
            <label>Correo</label>
            <input type="email" name="correo" value="{{ old('correo', $persona->correo) }}">
        </div>
        <div>
            <label>Estado</label>
            <select name="estado" required>
                <option value="1" {{ (string)old('estado', $persona->estado) === '1' || $persona->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ (string)old('estado', $persona->estado) === '0' || $persona->estado === 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('personas.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
