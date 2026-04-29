<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CamisetaAdminController;
use App\Http\Controllers\Admin\VarianteAdminController;
use App\Http\Controllers\Admin\LigaAdminController;
use App\Http\Controllers\Admin\EquipoAdminController;
use App\Http\Controllers\Admin\SeleccionAdminController;
use App\Http\Controllers\Admin\TemporadaAdminController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\UsuarioAdminController;
use App\Http\Controllers\Admin\ContactoAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // Acceso público al login
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Rutas protegidas por AdminMiddleware
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('camisetas', CamisetaAdminController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::get('variantes', [VarianteAdminController::class, 'index'])->name('variantes.index');
        Route::get('variantes/{camiseta}/edit', [VarianteAdminController::class, 'edit'])->name('variantes.edit');
        Route::put('variantes/{camiseta}', [VarianteAdminController::class, 'update'])->name('variantes.update');
        Route::delete('variantes/{camiseta}/{variante}', [VarianteAdminController::class, 'destroy'])->name('variantes.destroy');

        // Categorías
        Route::resource('ligas',      LigaAdminController::class)     ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('equipos',    EquipoAdminController::class)   ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('selecciones',SeleccionAdminController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('temporadas', TemporadaAdminController::class)->only(['index', 'store', 'update', 'destroy']);

        // Gestión
        Route::get('pedidos',                    [PedidoAdminController::class,   'index'])       ->name('pedidos.index');
        Route::get('pedidos/{pedido}',           [PedidoAdminController::class,   'show'])        ->name('pedidos.show');
        Route::put('pedidos/{pedido}/estado',    [PedidoAdminController::class,   'updateEstado'])->name('pedidos.estado');

        Route::get('usuarios',                   [UsuarioAdminController::class,  'index'])       ->name('usuarios.index');
        Route::put('usuarios/{usuario}/rol',     [UsuarioAdminController::class,  'updateRol'])   ->name('usuarios.rol');
        Route::delete('usuarios/{usuario}',      [UsuarioAdminController::class,  'destroy'])     ->name('usuarios.destroy');

        Route::get('contactos',                  [ContactoAdminController::class, 'index'])       ->name('contactos.index');
        Route::get('contactos/{contacto}',       [ContactoAdminController::class, 'show'])        ->name('contactos.show');
        Route::delete('contactos/{contacto}',    [ContactoAdminController::class, 'destroy'])     ->name('contactos.destroy');
    });
});
