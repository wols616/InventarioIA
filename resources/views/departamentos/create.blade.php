@extends('layouts.app')

@section('content')
    <h1>Crear Departamento</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departamentos.store') }}" method="POST">
        @csrf
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion') }}</textarea>
        </div>
        <div>
            <label><input type="checkbox" name="estado" value="1" {{ old('estado', '1') ? 'checked' : '' }}> Activo</label>
        </div>
        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('departamentos.index') }}">Cancelar</a>
            <a href="{{ route('roles.index') }}" style="margin-left:1rem">Gestionar Roles</a>
        </div>
    </form>
@endsection
