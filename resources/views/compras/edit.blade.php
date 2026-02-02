@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Editar Compra {{ $compra->numero_factura }}</h1>
        </div>

        <div class="p-6">
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron errores:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form id="compraForm" action="{{ route('compras.update', $compra->id_compra) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_proveedor" class="block text-sm font-medium text-gray-700 mb-2">Proveedor *</label>
                        <select name="id_proveedor" id="id_proveedor" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">-- Seleccione proveedor --</option>
                            @foreach($proveedores as $p)
                                <option value="{{ $p->id_proveedor }}" {{ $compra->id_proveedor == $p->id_proveedor ? 'selected' : '' }}>{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="fecha_compra" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Compra *</label>
                        <input type="date" name="fecha_compra" id="fecha_compra" value="{{ old('fecha_compra', $compra->fecha_compra ? \Carbon\Carbon::parse($compra->fecha_compra)->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Detalle de Compra</h3>
                        <button type="button" id="addRow" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar Fila
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="detalle" class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activo</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Costo Unitario</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($compra->detalles as $d)
                                <tr>
                                    <td class="px-4 py-3">
                                        <select name="id_activo[]" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                                            <option value="">-- Seleccione activo --</option>
                                            @foreach($activos as $a)
                                                <option value="{{ $a->id_activo }}" {{ $d->id_activo == $a->id_activo ? 'selected' : '' }}>{{ $a->codigo }} - {{ $a->marca }} {{ $a->modelo }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="cantidad[]" min="1" value="{{ old('cantidad[]', $d->cantidad) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" step="0.01" name="costo_unitario[]" min="0" value="{{ old('costo_unitario[]', $d->costo_unitario) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="subtotal font-semibold text-gray-900">{{ number_format($d->subtotal, 2) }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" class="remove text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded transition duration-200" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Total General:</span>
                            <span class="text-2xl font-bold text-green-600">$<span id="total">{{ number_format($compra->monto_total,2) }}</span></span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('compras.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Actualizar Compra
                    </button>
                </div>
            </form>
        </div>
    </div>

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