@extends('layouts.app')

@section('content')
    <h1>Crear asignación</h1>

    @php $asignacion = null; @endphp

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('asignaciones.store') }}" method="POST">
        @include('asignaciones._form')
    </form>

    <a href="{{ route('asignaciones.index') }}">Volver</a>
@endsection
