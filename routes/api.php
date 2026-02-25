<?php

use App\Http\Controllers\CamisetaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\DetalleCarritoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\SeleccionController;
use App\Http\Controllers\TemporadaController;
use App\Http\Controllers\UsuarioController;
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

/**
 * 
 * ! RUTAS PARA CIUDADES
 * 
 */
Route::get('/ciudades', [CiudadController::class , 'index']);
Route::get('/ciudades/{id}', [CiudadController::class, 'show']);
Route::get('/ciudades/{id}/provincia', [CiudadController::class, 'provincia']);

/**
 * 
 * ! RUTAS PARA USUARIOS
 * 
 */
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::get('/usuarios/{id}/direcciones', [UsuarioController::class, 'direcciones']);
Route::get('/usuarios/{id}/pedidos', [UsuarioController::class, 'pedidos']);
Route::get('/usuarios/{id}/carrito', [UsuarioController::class, 'carrito']);

/**
 * 
 * ! RUTAS PARA CARRITOS
 * 
 */
Route::get('/carritos', [CarritoController::class, 'index']);
Route::get('/carritos/{id}', [CarritoController::class, 'show']);
Route::get('/carritos/{id}/detalles', [CarritoController::class, 'detalles']);
Route::get('/carritos/{id}/usuario', [CarritoController::class, 'usuario']);

/**
 * 
 * ! RUTAS PARA DIRECCIÓNES
 * 
 */
Route::get('/direcciones', [DireccionController::class, 'index']);
Route::get('/direcciones/{id}', [DireccionController::class, 'show']);
Route::get('/direcciones/{id}/ciudad', [DireccionController::class, 'ciudad']);
Route::get('/direcciones/{id}/usuario', [DireccionController::class, 'usuario']);

/**
 * 
 * ! RUTAS PARA PEDIDOS
 * 
 */
Route::get('/pedidos', [PedidoController::class, 'index']);
Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
Route::get('/pedidos/{id}/detalles', [PedidoController::class, 'detalles']);
Route::get('/pedidos/{id}/usuario', [PedidoController::class, 'usuario']);
Route::get('/pedidos/{id}/direccion', [PedidoController::class, 'direccion']);

/**
 * 
 * ! RUTAS PARA DETALLES PEDIDOS
 * 
 */
Route::get('/detalle-pedidos', [DetallePedidoController::class, 'index']);
Route::get('/detalle-pedidos/{id}', [DetallePedidoController::class, 'show']);
Route::get('/detalle-pedidos/{id}/pedido', [DetallePedidoController::class, 'pedido']);
Route::get('/detalle-pedidos/{id}/variante', [DetallePedidoController::class, 'variante']);

/**
 * 
 * ! RUTAS PARA DETALLE CARRITO
 * 
 */
Route::get('/detalle-carritos' , [DetalleCarritoController::class, 'index']);
Route::get('/detalle-carritos/{id}', [DetalleCarritoController::class, 'show']);
Route::get('/detalle-carritos/{id}/carrito', [DetalleCarritoController::class, 'carrito']);
Route::get('/detalle-carritos/{id}/variante', [DetalleCarritoController::class, 'variante']);