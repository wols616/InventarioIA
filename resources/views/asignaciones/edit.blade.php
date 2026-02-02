@extends('layouts.app')

@section('content')
    <h1>Editar asignación #{{ $asignacion->id_asignacion }}</h1>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('asignaciones.update', $asignacion->id_asignacion) }}" method="POST">
        @method('PUT')
        @include('asignaciones._form')
    </form>

    <a href="{{ route('asignaciones.index') }}">Volver</a>
@endsection
