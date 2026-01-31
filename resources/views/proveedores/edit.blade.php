@extends('layouts.app')

@section('content')
    <h1>Editar Proveedor #{{ $proveedor->id_proveedor }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
        </div>
        <div>
            <label>Contacto</label>
            <input type="text" name="contacto" value="{{ old('contacto', $proveedor->contacto) }}">
        </div>
        <div>
            <label>Descripcion</label>
            <textarea name="descripcion">{{ old('descripcion', $proveedor->descripcion) }}</textarea>
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('proveedores.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
