@extends('layouts.app')

@section('content')
    <h1>Compra {{ $compra->numero_factura }}</h1>
    <p><strong>Proveedor:</strong> {{ optional($compra->proveedor)->nombre }}</p>
    <p><strong>Fecha:</strong> {{ optional($compra->fecha_compra)->format('Y-m-d') }}</p>
    <p><strong>Monto total:</strong> {{ number_format($compra->monto_total,2) }}</p>

    <h3>Detalles</h3>
    <table>
        <thead>
            <tr>
                <th>Activo</th>
                <th>Cantidad</th>
                <th>Costo unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compra->detalles as $d)
                <tr>
                    <td>{{ optional($d->activo)->codigo }} {{ optional($d->activo)->marca }} {{ optional($d->activo)->modelo }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>{{ number_format($d->costo_unitario,2) }}</td>
                    <td>{{ number_format($d->subtotal,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('compras.index') }}">Volver</a>
@endsection
