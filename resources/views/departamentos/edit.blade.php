@extends('layouts.app')

@section('content')
    <h1>Editar Departamento</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departamentos.update', $departamento) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $departamento->nombre) }}" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion', $departamento->descripcion) }}</textarea>
        </div>
        <div>
            <label><input type="checkbox" name="estado" value="1" {{ old('estado', $departamento->estado) ? 'checked' : '' }}> Activo</label>
        </div>
        <div>
            <button type="submit">Guardar</button>
            <a href="{{ route('departamentos.index') }}">Cancelar</a>
            <a href="{{ route('roles.index') }}" style="margin-left:1rem">Gestionar Roles</a>
        </div>
    </form>
@endsection
