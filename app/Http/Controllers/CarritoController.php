<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\VarianteCamiseta;
use APP\Models\DetalleCarrito;
use Illuminate\Http\JsonResponse;

class CarritoController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Carrito>
     * 
     * ? GET /api/carritos
     * ! Devuelve todos los carritos
     */
    public function index()
    {

        return Carrito::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Summary of show
     * @param mixed $id
     * @return Carrito|\Illuminate\Database\Eloquent\Collection<int, Carrito>
     * 
     * ? GET /api/carritos/{id}
     * ! Devuelve un carrito asociado a un ID
     */
    public function show($id)
    {

        return Carrito::findOrFail($id);
    }

    /**
     * Summary of detalles
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? GET /api/carritos/detalles
     * ! Devuelve los elementos dentro del carrito del usuario
     */
    public function detalles(Request $request): JsonResponse
    {

        $usuario = $request->user();

        $carrito = Carrito::where('cod_usu', $usuario->cod_usu)->first();

        if (!$carrito) {

            return response()->json([

                'carrito' => null,
                'detalles' => []
            ]);
        }

        $detalles = DetalleCarrito::where('cod_carr', $carrito->cod_carr)
            ->with([

                'variante.camiseta',
                'variante'
            ])->get();

        $resultadoDetalles = $detalles->map(function ($detalle) {

            $variante = $detalle->variante;
            $camiseta = $variante->camiseta;

            return [

                'cod_det_carr' => $detalle->cod_det_carr,
                'cantidad' => $detalle->cantidad,
                'nombre_personalizado' => $detalle->nombre_personalizado,
                'dorsal_personalizado' => $detalle->dorsal_personalizado,

                // datos de la camiseta
                'nombre_camiseta' => $camiseta->nombre,
                'precio' => $camiseta->precio,
                'subtotal' => $camiseta->precio * $detalle->cantidad,

                // Variante
                'talla' => $variante->talla,
                'stock' => $variante->stock,

                // imagen principal
                'imagen' => $camiseta->imagen_principal

            ];
        });

        // Calcular el total del carrito
        $total = $resultadoDetalles->sum('subtotal');

        // Devolver resultado
        return response()->json([

            'detalles' => $resultadoDetalles,
            'total' => $total,
        ]);
    }


    /**
     * Summary of usuario
     * @param mixed $id
     * @return \App\Models\Usuario
     * 
     * ? GET /api/carritos/{id}/usuario
     * ! Devuelve el usuario dueño de un carrito asociado a un ID
     */
    public function usuario($id)
    {

        return Carrito::findOrFail($id)->usuario;
    }

    /**
     * Summary of agregar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     *  ? POST /api/carritos/agregar
     * ! Endpoint para agregar un producto al carrito
     */
    public function agregar(Request $request): JsonResponse
    {
        $usuario = $request->user();

        // VALIDACIÓN DE PARÁMETROS
        $request->validate([

            'cod_var' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'nombre_personalizado' => 'nullable|string|max:50',
            'dorsal_personalizado' => 'nullable|integer|min:0|max:99'
        ]);

        // COMPROBAR QUE LA VARIANTE EXISTE
        $variante = VarianteCamiseta::findOrFail($request->cod_var);

        // COMPROBAR STOCK DIRECTO
        if ($variante->stock < $request->cantidad) {

            return response()->json([

                'error' => 'Stock insuficiente',
                'stock' => $variante->stock
            ], 400);
        }

        // BUSCAR O CREAR EL CARRITO DEL USUARIO
        $carrito = Carrito::firstOrCreate([
            'cod_usu' => $usuario->cod_usu
        ]);

        // BUSCAR DETALLE EXISTENTE (misma variante + misma personalización)
        $detalleQuery = DetalleCarrito::where('cod_carr', $carrito->cod_carr)->where('cod_var', $request->cod_var);

        // Personalización: nombre
        if ($request->nombre_personalizado === null) {

            $detalleQuery->whereNull('nombre_personalizado');
        } else {

            $detalleQuery->where('nombre_personalizado', $request->nombre_personalizado);
        }

        // Personalización: dorsal
        if ($request->dorsal_personalizado === null) {

            $detalleQuery->whereNull('dorsal_personalizado');
        } else {

            $detalleQuery->where('dorsal_personalizado', $request->dorsal_personalizado);
        }

        $detalle = $detalleQuery->first();

        if ($detalle) {

            // CANTIDAD TOTAL QUE TENDRÍA
            $nuevaCantidad = $detalle->cantidad + $request->cantidad;

            // VALIDAR STOCK TOTAL
            if ($nuevaCantidad > $variante->stock) {

                return response()->json([

                    'error' => 'Stock insuficiente',
                    'cantidad_actual' => $detalle->cantidad,
                    'stock' => $variante->stock
                ], 400);
            }

            // ACTUALIZAR CANTIDAD
            $detalle->cantidad = $nuevaCantidad;
            $detalle->save();
        } else {

            // CREAR NUEVO DETALLE
            DetalleCarrito::create([

                'cod_carr' => $carrito->cod_carr,
                'cod_var' => $request->cod_var,
                'cantidad' => $request->cantidad,
                'nombre_personalizado' => $request->nombre_personalizado,
                'dorsal_personalizado' => $request->dorsal_personalizado,
            ]);
        }

        return response()->json([

            'mensaje' => 'Producto añadido al carrito',
        ]);
    }


    /**
     * Summary of eliminar
     * @param Request $request
     * @param mixed $id_detalle
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? DETELE /api/carritos/eliminar/{id}
     * ! Elimina un artículo del carrito del usuario
     */
    public function eliminar(Request $request, $id_detalle): JsonResponse
    {

        $usuario = $request->user();

        // Si no existe → 404 automático
        $detalle = DetalleCarrito::findOrFail($id_detalle);

        // Verificar que pertenece al usuario
        if ($detalle->carrito->cod_usu != $usuario->cod_usu) {
            return response()->json([
                'error' => 'No tienes permiso para eliminar este producto'
            ], 403);
        }

        // Borrar el artículo del carrito
        $detalle->delete();

        return response()->json([
            'mensaje' => 'Producto eliminado del carrito'
        ]);
    }


    /**
     * Summary of aumentarCantidad
     * @param Request $request
     * @param mixed $id_detalle
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? PATCH /api/carritos/aumentar/{id}
     * ! Aumenta la cantidad de un artículo en el carrito en +1
     */
    public function aumentarCantidad(Request $request, $id_detalle): JsonResponse
    {

        $usuario = $request->user();

        // Si no existe → 404 automático
        $detalle = DetalleCarrito::findOrFail($id_detalle);

        // Verificar que pertenece al usuario
        if ($detalle->carrito->cod_usu != $usuario->cod_usu) {

            return response()->json([

                'error' => 'No tienes permiso para modificar este producto'
            ], 403);
        }

        // Stock disponible de la variante
        $stockDisponible = $detalle->variante->stock;

        // Validación de stock
        if ($detalle->cantidad >= $stockDisponible) {

            return response()->json([

                'error' => 'No hay más stock disponible',
                'cantidad' => $detalle->cantidad,
                'stock' => $stockDisponible
            ], 400);
        }

        // Aumentar cantidad
        $detalle->cantidad += 1;
        $detalle->save();

        return response()->json([

            'mensaje' => 'Cantidad aumentada',
        ]);
    }

    /**
     * Summary of dismunuirCantidad
     * @param Request $request
     * @param mixed $id_detalle
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? PATCH /api/carritos/aumentar/{id}
     * ! Disminuye la cantidad de un artículo del carrito en -1
     */
    public function disminuirCantidad(Request $request, $id_detalle): JsonResponse
    {

        $usuario = $request->user();

        // Si no existe → 404 automático
        $detalle = DetalleCarrito::findOrFail($id_detalle);

        // Verificar que pertenece al usuario
        if ($detalle->carrito->cod_usu != $usuario->cod_usu) {

            return response()->json([

                'error' => 'No tienes permiso para modificar este producto'
            ], 403);
        }

        // No permitir bajar de 1
        if ($detalle->cantidad <= 1) {

            return response()->json([

                'mensaje' => 'La cantidad mínima es 1',
                'cantidad' => $detalle->cantidad
            ]);
        }

        // Disminuir cantidad
        $detalle->cantidad -= 1;
        $detalle->save();

        return response()->json([

            'mensaje' => 'Cantidad disminuida',
        ]);
    }

    /**
     * Summary of vaciar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? DELETE /api/carritos/vaciar
     * ! Vacía el carrito de un usuario
     */
    public function vaciar(Request $request)
    {

        $usuario = $request->user();

        $carrito = Carrito::where('cod_usu', $usuario->cod_usu)->first();

        if (!$carrito) {

            return response()->json([

                'mensaje' => 'El carrito ya está vacío'
            ]);
        }

        $detalles = DetalleCarrito::where('cod_carr', $carrito->cod_carr);

        if (!$detalles->exists()) {

            return response()->json([

                'mensaje' => 'El carrito ya está vacío'
            ]);
        }

        $detalles->delete();


        return response()->json([

            'mensaje' => 'Carrito vaciado correctamente'
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
