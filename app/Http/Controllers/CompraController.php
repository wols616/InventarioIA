<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Activo;
use App\Models\Proveedor;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')->orderBy('fecha_compra','desc')->paginate(20);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $activos = Activo::orderBy('codigo')->get();
        return view('compras.create', compact('proveedores', 'activos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'fecha_compra' => 'required|date',
            'id_activo' => 'required|array|min:1',
            'id_activo.*' => 'required|exists:activos,id_activo',
            'cantidad' => 'required|array',
            'cantidad.*' => 'required|integer|min:1',
            'costo_unitario' => 'required|array',
            'costo_unitario.*' => 'required|numeric|min:0',
        ]);

        // Generar número de factura como FAC-<n>
        $last = Compra::orderBy('id_compra','desc')->first();
        $nextNum = 1;
        if($last && $last->numero_factura){
            if(preg_match('/FAC-(\d+)$/', $last->numero_factura, $m)){
                $nextNum = intval($m[1]) + 1;
            }
        }
        $numero_factura = 'FAC-' . $nextNum;

        DB::beginTransaction();
        try{
            $compra = Compra::create([
                'id_proveedor' => $data['id_proveedor'],
                'numero_factura' => $numero_factura,
                'fecha_compra' => $data['fecha_compra'],
                'monto_total' => 0,
            ]);

            $total = 0;
            for($i=0;$i<count($data['id_activo']);$i++){
                $id_activo = $data['id_activo'][$i];
                $cantidad = intval($data['cantidad'][$i]);
                $costo = floatval($data['costo_unitario'][$i]);
                $subtotal = $cantidad * $costo;

                DetalleCompra::create([
                    'id_compra' => $compra->id_compra,
                    'id_activo' => $id_activo,
                    'cantidad' => $cantidad,
                    'costo_unitario' => $costo,
                    'subtotal' => $subtotal,
                ]);

                // Actualizar inventario
                $inv = Inventario::where('id_activo', $id_activo)->first();
                if($inv){
                    $inv->cantidad = ($inv->cantidad ?? 0) + $cantidad;
                    $inv->save();
                } else {
                    Inventario::create([
                        'id_activo' => $id_activo,
                        'cantidad' => $cantidad,
                        'descripcion' => null,
                        'cantidad_minima' => null,
                        'cantidad_maxima' => null,
                    ]);
                }

                $total += $subtotal;
            }

            $compra->monto_total = $total;
            $compra->save();

            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors(['general' => 'Error al procesar la compra: '.$e->getMessage()])->withInput();
        }

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente ('.$numero_factura.')');
    }

    public function show(Compra $compra)
    {
        $compra->load('detalles.activo','proveedor');
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $activos = Activo::orderBy('codigo')->get();
        $compra->load('detalles.activo');
        return view('compras.edit', compact('compra', 'proveedores', 'activos'));
    }

    public function update(Request $request, Compra $compra)
    {
        $data = $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'fecha_compra' => 'required|date',
            'id_activo' => 'required|array|min:1',
            'id_activo.*' => 'required|exists:activos,id_activo',
            'cantidad' => 'required|array',
            'cantidad.*' => 'required|integer|min:1',
            'costo_unitario' => 'required|array',
            'costo_unitario.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try{
            // revert inventory quantities based on existing detalles
            foreach($compra->detalles as $old){
                $inv = Inventario::where('id_activo', $old->id_activo)->first();
                if($inv){
                    $inv->cantidad = max(0, ($inv->cantidad ?? 0) - ($old->cantidad ?? 0));
                    $inv->save();
                }
            }

            // remove old detalles
            DetalleCompra::where('id_compra', $compra->id_compra)->delete();

            // create new detalles and update/increment inventory
            $total = 0;
            for($i=0;$i<count($data['id_activo']);$i++){
                $id_activo = $data['id_activo'][$i];
                $cantidad = intval($data['cantidad'][$i]);
                $costo = floatval($data['costo_unitario'][$i]);
                $subtotal = $cantidad * $costo;

                DetalleCompra::create([
                    'id_compra' => $compra->id_compra,
                    'id_activo' => $id_activo,
                    'cantidad' => $cantidad,
                    'costo_unitario' => $costo,
                    'subtotal' => $subtotal,
                ]);

                $inv = Inventario::where('id_activo', $id_activo)->first();
                if($inv){
                    $inv->cantidad = ($inv->cantidad ?? 0) + $cantidad;
                    $inv->save();
                } else {
                    Inventario::create([
                        'id_activo' => $id_activo,
                        'cantidad' => $cantidad,
                        'descripcion' => null,
                        'cantidad_minima' => null,
                        'cantidad_maxima' => null,
                    ]);
                }

                $total += $subtotal;
            }

            $compra->id_proveedor = $data['id_proveedor'];
            $compra->fecha_compra = $data['fecha_compra'];
            $compra->monto_total = $total;
            $compra->save();

            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors(['general' => 'Error al actualizar la compra: '.$e->getMessage()])->withInput();
        }

        return redirect()->route('compras.show', $compra)->with('success', 'Compra actualizada correctamente');
    }

    public function destroy(Compra $compra)
    {
        // opcional: no eliminar físicamente
        $compra->delete();
        return redirect()->route('compras.index')->with('success','Compra eliminada');
    }
}
