@extends('layouts.app')

@section('content')
    <h1>Crear Edificio</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('edificios.store') }}" method="POST">
        @csrf
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label>Codigo</label>
            <input type="text" name="codigo" value="{{ old('codigo') }}">
        </div>
        <div>
            <button type="submit">Crear</button>
            <a href="{{ route('edificios.index') }}">Cancelar</a>
        </div>
    </form>

@endsection
