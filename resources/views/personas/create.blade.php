@extends('layouts.app')

@section('content')
    <h1>Crear Persona</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('personas.store') }}" method="POST">
        @csrf
        <div>
            <label>Rol</label>
            <select name="id_rol" required>
                <option value="">-- Seleccione rol --</option>
                @foreach($roles as $r)
                    <option value="{{ $r->id_rol }}" {{ old('id_rol') == $r->id_rol ? 'selected' : '' }}>{{ $r->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Departamento</label>
            <select name="id_departamento" required>
                <option value="">-- Seleccione departamento --</option>
                @foreach($departamentos as $d)
                    <option value="{{ $d->id_departamento }}" {{ old('id_departamento') == $d->id_departamento ? 'selected' : '' }}>{{ $d->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label>Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" required>
        </div>
        <div>
            <label>DUI</label>
            <input type="text" name="dui" value="{{ old('dui') }}">
        </div>
        <div>
            <label>Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}">
        </div>
        <div>
            <label>Estado</label>
            <select name="estado" required>
                <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('personas.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
