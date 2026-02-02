@extends('layouts.app')

@section('content')
    <h1>Registrar compra</h1>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="compraForm" action="{{ route('compras.store') }}" method="POST">
        @csrf

        <div>
            <label>Proveedor</label>
            <select name="id_proveedor" required>
                <option value="">-- Seleccione proveedor --</option>
                @foreach($proveedores as $p)
                    <option value="{{ $p->id_proveedor }}">{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Fecha compra</label>
            <input type="date" name="fecha_compra" value="{{ date('Y-m-d') }}" required />
        </div>

        <h3>Detalle de compra</h3>
        <table id="detalle">
            <thead>
                <tr>
                    <th>Activo</th>
                    <th>Cantidad</th>
                    <th>Costo unitario</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="id_activo[]" required>
                            <option value="">-- Seleccione activo --</option>
                            @foreach($activos as $a)
                                <option value="{{ $a->id_activo }}">{{ $a->codigo }} - {{ $a->marca }} {{ $a->modelo }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('activos.create') }}">Crear activo</a>
                    </td>
                    <td><input type="number" name="cantidad[]" min="1" value="1" required /></td>
                    <td><input type="number" step="0.01" name="costo_unitario[]" min="0" value="0.00" required /></td>
                    <td class="subtotal">0.00</td>
                    <td><button type="button" class="remove">-</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="addRow">Agregar fila</button>

        <div>
            <strong>Total: $<span id="total">0.00</span></strong>
        </div>

        <div>
            <button type="submit">Registrar compra</button>
        </div>
    </form>

    <script>
        function recalcRow(row){
            const qty = parseFloat(row.querySelector('input[name="cantidad[]"]').value) || 0;
            const cost = parseFloat(row.querySelector('input[name="costo_unitario[]"]').value) || 0;
            const subtotal = qty * cost;
            row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
        }

        function recalcAll(){
            let total = 0;
            document.querySelectorAll('#detalle tbody tr').forEach(r => {
                recalcRow(r);
                total += parseFloat(r.querySelector('.subtotal').textContent) || 0;
            });
            document.getElementById('total').textContent = total.toFixed(2);
        }

        document.getElementById('addRow').addEventListener('click', function(){
            const tbody = document.querySelector('#detalle tbody');
            const tr = tbody.rows[0].cloneNode(true);
            tr.querySelectorAll('input').forEach(i => i.value = i.name.indexOf('cantidad')>=0 ? 1 : 0.00);
            tr.querySelector('.subtotal').textContent = '0.00';
            tbody.appendChild(tr);
            recalcAll();
        });

        document.querySelector('#detalle tbody').addEventListener('click', function(e){
            if(e.target.classList.contains('remove')){
                const tr = e.target.closest('tr');
                if(document.querySelectorAll('#detalle tbody tr').length > 1){
                    tr.remove();
                    recalcAll();
                }
            }
        });

        document.querySelector('#detalle tbody').addEventListener('input', function(e){
            if(e.target.name === 'cantidad[]' || e.target.name === 'costo_unitario[]'){
                recalcAll();
            }
        });

        // initial calc
        recalcAll();
    </script>

@endsection
