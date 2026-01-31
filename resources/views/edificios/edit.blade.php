@extends('layouts.app')

@section('content')
    <h1>Editar Edificio #{{ $edificio->id_edificio }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('edificios.update', $edificio) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $edificio->nombre) }}" required>
        </div>
        <div>
            <label>Codigo</label>
            <input type="text" name="codigo" value="{{ old('codigo', $edificio->codigo) }}">
        </div>
        <div>
            <button type="submit">Actualizar</button>
            <a href="{{ route('edificios.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
