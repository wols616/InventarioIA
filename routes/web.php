<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\TipoActivoController;
use App\Http\Controllers\EstadoActivoController;
use App\Http\Controllers\UbicacionFisicaController;
use App\Http\Controllers\EdificioController;
use App\Http\Controllers\PisoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DocumentoAdjuntoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('activos', ActivoController::class);
Route::resource('tipos', TipoActivoController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('estados', EstadoActivoController::class);
// Fix parameter name for Spanish plural -> singular mismatch (ubicaciones -> ubicacion)
Route::resource('ubicaciones', UbicacionFisicaController::class)->parameters(['ubicaciones' => 'ubicacion']);
Route::resource('edificios', EdificioController::class);
Route::resource('pisos', PisoController::class)->parameters(['pisos' => 'piso']);
Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor']);
Route::resource('personas', PersonaController::class)->parameters(['personas' => 'persona']);
Route::resource('departamentos', DepartamentoController::class)->parameters(['departamentos' => 'departamento']);
Route::resource('roles', RoleController::class)->parameters(['roles' => 'role']);
Route::resource('areas', AreaController::class)->parameters(['areas' => 'area']);
Route::resource('documentos', DocumentoAdjuntoController::class)->parameters(['documentos' => 'documento']);

// Movimientos de activos
use App\Http\Controllers\MovimientoActivoController;
Route::resource('movimientos', MovimientoActivoController::class)->parameters(['movimientos' => 'movimiento']);

// Mantenimientos
use App\Http\Controllers\MantenimientoController;
Route::resource('mantenimientos', MantenimientoController::class)->parameters(['mantenimientos' => 'mantenimiento']);

// Auditorias
use App\Http\Controllers\AuditoriaInventarioController;
Route::resource('auditorias', AuditoriaInventarioController::class)->parameters(['auditorias' => 'auditoria']);

// Inventario
use App\Http\Controllers\InventarioController;
Route::resource('inventario', InventarioController::class)->parameters(['inventario' => 'inventario']);

// Asignaciones de activos
use App\Http\Controllers\AsignacionActivoController;
Route::resource('asignaciones', AsignacionActivoController::class)->parameters(['asignaciones' => 'asignacion']);

// Compras
use App\Http\Controllers\CompraController;
Route::resource('compras', CompraController::class)->parameters(['compras' => 'compra']);
