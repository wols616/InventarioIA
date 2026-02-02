@extends('layouts.app')

@section('content')
    <h1>Movimiento #{{ $movimiento->id_movimiento ?? $movimiento->id }}</h1>

    <p><strong>Activo:</strong> {{ $movimiento->activo->codigo ?? '' }} - {{ $movimiento->activo->marca ?? '' }} {{ $movimiento->activo->modelo ?? '' }}</p>
    <p><strong>Origen:</strong> {{ $movimiento->ubicacionOrigen->nombre ?? 'N/A' }} ({{ $movimiento->ubicacionOrigen->codigo_interno ?? '' }})</p>
    <p><strong>Destino:</strong> {{ $movimiento->ubicacionDestino->nombre ?? 'N/A' }} ({{ $movimiento->ubicacionDestino->codigo_interno ?? '' }})</p>
    <p><strong>Fecha:</strong> {{ $movimiento->fecha_movimiento }}</p>
    <p><strong>Motivo:</strong> {{ $movimiento->motivo }}</p>

    <a href="{{ route('movimientos.index') }}">Volver</a>

@endsection
