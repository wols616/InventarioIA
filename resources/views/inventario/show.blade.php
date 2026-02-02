@extends('layouts.app')

@section('content')
    <h1>Item de Inventario #{{ $inventario->id_inventario }}</h1>

    <p><strong>Activo:</strong> {{ $inventario->activo ? ($inventario->activo->codigo . ' - ' . trim(($inventario->activo->marca ?? '') . ' ' . ($inventario->activo->modelo ?? ''))) : $inventario->id_activo }}</p>
    <p><strong>Cantidad:</strong> {{ $inventario->cantidad }}</p>
    <p><strong>Descripción:</strong> {{ $inventario->descripcion }}</p>
    <p><strong>Cantidad mínima:</strong> {{ $inventario->cantidad_minima }}</p>
    <p><strong>Cantidad máxima:</strong> {{ $inventario->cantidad_maxima }}</p>

    <a href="{{ route('inventario.index') }}">Volver</a>
@endsection
