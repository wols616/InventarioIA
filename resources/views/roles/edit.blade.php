@extends('layouts.app')

@section('content')
    <h1>Editar Rol</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $role->nombre) }}" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion', $role->descripcion) }}</textarea>
        </div>
        <div>
            <button type="submit">Guardar</button>
            <a href="{{ route('roles.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
