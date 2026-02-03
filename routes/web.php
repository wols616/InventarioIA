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
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthenticateUsuario;
use App\Http\Middleware\AdminOnlyMiddleware;
use App\Http\Middleware\AuditorOnlyMiddleware;
use App\Http\Middleware\AdminOrSupervisorMiddleware;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MovimientoActivoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\AuditoriaInventarioController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AsignacionActivoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ChatController;

// Authentication routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Enforce numeric route parameters to avoid literal segments (eg. 'create') matching show routes
Route::pattern('activo', '[0-9]+');
Route::pattern('inventario', '[0-9]+');
Route::pattern('movimiento', '[0-9]+');
Route::pattern('mantenimiento', '[0-9]+');
Route::pattern('documento', '[0-9]+');
Route::pattern('persona', '[0-9]+');
Route::pattern('asignacion', '[0-9]+');
Route::pattern('tipo', '[0-9]+');
Route::pattern('categoria', '[0-9]+');
Route::pattern('estado', '[0-9]+');
Route::pattern('ubicacion', '[0-9]+');
Route::pattern('edificio', '[0-9]+');
Route::pattern('piso', '[0-9]+');
Route::pattern('departamento', '[0-9]+');
Route::pattern('area', '[0-9]+');
Route::pattern('proveedor', '[0-9]+');
Route::pattern('compra', '[0-9]+');
Route::pattern('usuario', '[0-9]+');
Route::pattern('role', '[0-9]+');

// Protected routes - require usuario login
Route::middleware(AuthenticateUsuario::class)->group(function () {
    Route::get('/', function () { return view('home'); });

    // Chat con IA
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/test-bot', [ChatController::class, 'testBot'])->name('chat.testBot');

    // Public to authenticated users: read-only routes (index/show)
    Route::resource('activos', ActivoController::class)->only(['index','show']);
    Route::resource('inventario', InventarioController::class)->only(['index','show']);
    Route::resource('movimientos', MovimientoActivoController::class)->only(['index','show']);
    Route::resource('mantenimientos', MantenimientoController::class)->only(['index','show']);
    Route::resource('documentos', DocumentoAdjuntoController::class)->only(['index','show']);
    Route::resource('personas', PersonaController::class)->parameters(['personas' => 'persona'])->only(['index','show']);
    Route::resource('asignaciones', AsignacionActivoController::class)->parameters(['asignaciones' => 'asignacion'])->only(['index','show']);

    // Catalogos - read-only for non-admin
    Route::resource('tipos', TipoActivoController::class)->only(['index','show']);
    Route::resource('categorias', CategoriaController::class)->only(['index','show']);
    Route::resource('estados', EstadoActivoController::class)->only(['index','show']);
    // Fix parameter name for Spanish plural -> singular mismatch (ubicaciones -> ubicacion)
    Route::resource('ubicaciones', UbicacionFisicaController::class)->parameters(['ubicaciones' => 'ubicacion'])->only(['index','show']);
    Route::resource('edificios', EdificioController::class)->only(['index','show']);
    Route::resource('pisos', PisoController::class)->parameters(['pisos' => 'piso'])->only(['index','show']);
    Route::resource('departamentos', DepartamentoController::class)->parameters(['departamentos' => 'departamento'])->only(['index','show']);
    Route::resource('areas', AreaController::class)->parameters(['areas' => 'area'])->only(['index','show']);
    // Proveedores: permitir ver lista y detalle para usuarios autenticados (admin gestiona el resto)
    Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor'])->only(['index','show']);

    // Compras: permitir ver lista y detalle para usuarios autenticados
    Route::resource('compras', CompraController::class)->parameters(['compras' => 'compra'])->only(['index','show']);

    // Auditorías - auditors can create and edit their own audits (leave controller to enforce ownership)
    Route::resource('auditorias', AuditoriaInventarioController::class)->parameters(['auditorias' => 'auditoria']);

    // Supervisor or Admin: create/edit actions for several resources (Supervisor allowed where appropriate)
    Route::middleware(AdminOrSupervisorMiddleware::class)->group(function () {
        Route::resource('activos', ActivoController::class)->only(['create','store','edit','update']);
        Route::resource('movimientos', MovimientoActivoController::class)->only(['create','store','edit','update'])->parameters(['movimientos' => 'movimiento']);
        Route::resource('mantenimientos', MantenimientoController::class)->only(['create','store','edit','update'])->parameters(['mantenimientos' => 'mantenimiento']);
        Route::resource('asignaciones', AsignacionActivoController::class)->only(['create','store','edit','update'])->parameters(['asignaciones' => 'asignacion']);
        Route::resource('inventario', InventarioController::class)->only(['create','store','edit','update'])->parameters(['inventario' => 'inventario']);
        Route::resource('compras', CompraController::class)->only(['create','store','edit','update'])->parameters(['compras' => 'compra']);
        Route::resource('documentos', DocumentoAdjuntoController::class)->only(['create','store','edit','update'])->parameters(['documentos' => 'documento']);
    });

    // Inventario
    // Remaining read-only routes handled above; admin-only routes defined below
    
    // Admin-only management routes
    Route::middleware(AdminOnlyMiddleware::class)->group(function () {
        // Full management
        Route::resource('activos', ActivoController::class)->only(['destroy']);
        Route::resource('tipos', TipoActivoController::class)->except(['index','show']);
        Route::resource('categorias', CategoriaController::class)->except(['index','show']);
        Route::resource('estados', EstadoActivoController::class)->except(['index','show']);
        Route::resource('ubicaciones', UbicacionFisicaController::class)->except(['index','show'])->parameters(['ubicaciones' => 'ubicacion']);
        Route::resource('edificios', EdificioController::class)->except(['index','show']);
        Route::resource('pisos', PisoController::class)->except(['index','show'])->parameters(['pisos' => 'piso']);
        Route::resource('proveedores', ProveedorController::class)->except(['index','show'])->parameters(['proveedores' => 'proveedor']);
        Route::resource('departamentos', DepartamentoController::class)->except(['index','show'])->parameters(['departamentos' => 'departamento']);
        Route::resource('areas', AreaController::class)->except(['index','show'])->parameters(['areas' => 'area']);
        Route::resource('documentos', DocumentoAdjuntoController::class)->only(['destroy'])->parameters(['documentos' => 'documento']);

        Route::resource('movimientos', MovimientoActivoController::class)->only(['destroy'])->parameters(['movimientos' => 'movimiento']);
        Route::resource('mantenimientos', MantenimientoController::class)->only(['destroy'])->parameters(['mantenimientos' => 'mantenimiento']);

        Route::resource('asignaciones', AsignacionActivoController::class)->only(['destroy'])->parameters(['asignaciones' => 'asignacion']);
        Route::resource('inventario', InventarioController::class)->only(['destroy'])->parameters(['inventario' => 'inventario']);
        // Personas management (Admin)
        Route::resource('personas', PersonaController::class)->except(['index','show'])->parameters(['personas' => 'persona']);
        Route::resource('compras', CompraController::class)->only(['destroy'])->parameters(['compras' => 'compra']);

        // Users and roles management only for Admin
        Route::resource('usuarios', App\Http\Controllers\UsuarioController::class)->except(['create']);
        Route::get('usuarios/create/{persona}', [App\Http\Controllers\UsuarioController::class, 'create'])->name('usuarios.create');
        Route::resource('roles', RoleController::class)->parameters(['roles' => 'role']);
    });
});

