@extends('layouts.app')

@section('content')
    <h1>Compras</h1>
    <a href="{{ route('compras.create') }}">Registrar compra</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Factura</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Monto total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $c)
                <tr>
                    <td>{{ $c->id_compra }}</td>
                    <td>{{ $c->numero_factura }}</td>
                    <td>{{ optional($c->proveedor)->nombre }}</td>
                    <td>{{ optional($c->fecha_compra)->format('Y-m-d') }}</td>
                    <td>{{ number_format($c->monto_total,2) }}</td>
                    <td><a href="{{ route('compras.show', $c->id_compra) }}">Ver</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $compras->links() }}
@endsection
