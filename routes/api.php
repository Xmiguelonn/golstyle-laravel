<?php

use App\Http\Controllers\CamisetaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\SeleccionController;
use App\Http\Controllers\TemporadaController;
use Illuminate\Support\Facades\Route;


/**
 * 
 *  ! RUTAS PARA CAMISETAS
 * 
 */
Route::get('/camisetas', [CamisetaController::class, 'index']);
Route::get('/camisetas/{id}', [CamisetaController::class, 'show']);
Route::get('/camisetas/{id}/variantes', [CamisetaController::class, 'variantes']);
Route::get('/camisetas/{id}/imagenes', [CamisetaController::class, 'imagenes']);

/**
 * 
 * ! RUTAS PARA LIGAS
 * 
 */
Route::get('/ligas', [LigaController::class, 'index']);
Route::get('/ligas/{id}', [LigaController::class, 'show']);
Route::get('/ligas/{id}/equipos', [LigaController::class, 'equipos']);

/**
 * 
 * ! RUTAS PARA SELECCIONES
 * 
 */
Route::get('/selecciones', [SeleccionController::class, 'index']);
Route::get('/selecciones/{id}', [SeleccionController::class, 'show']);
Route::get('/selecciones/{id}/camisetas', [SeleccionController::class, 'camisetas']);

/**
 * 
 * ! RUTAS PARA TEMPORADAS
 * 
 */
Route::get('/temporadas', [TemporadaController::class, 'index']);
Route::get('/temporadas/{id}', [TemporadaController::class, 'show']);
Route::get('/temporadas/{id}/camisetas', [TemporadaController::class, 'camisetas']);

/**
 * 
 * ! RUTAS PARA EQUIPOS
 * 
 */
Route::get('/equipos', [EquipoController::class, 'index']);
Route::get('/equipos/{id}', [EquipoController::class, 'show']);
Route::get('/equipos/{id}/camisetas', [EquipoController::class, 'camisetas']);