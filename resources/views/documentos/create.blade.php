@extends('layouts.app')

@section('content')
    <h1>Agregar Documento</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_activo" value="{{ $activoId }}">
        <div>
            <label>Tipo documento</label>
            <input type="text" name="tipo_documento" value="{{ old('tipo_documento') }}">
        </div>
        <div>
            <label>Archivo</label>
            <input type="file" name="archivo" required>
        </div>
        <div>
            <button type="submit">Subir</button>
            <a href="{{ route('documentos.index', ['activo' => $activoId]) }}">Cancelar</a>
        </div>
    </form>
@endsection
