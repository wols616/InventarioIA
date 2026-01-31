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
