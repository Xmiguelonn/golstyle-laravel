<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\DetalleCarrito;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DetalleCarritoController extends Controller
{


    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, DetalleCarrito>
     * 
     * ? GET /api/detalle-carritos
     * ! Devuelve todos los detalles de carritos
     */
    public function index()
    {

        return DetalleCarrito::all();
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
     * @param mixed $cod_usu
     * @return \Illuminate\Http\JsonResponse
     * ? GET /api/detalle-carritos/{id}
     * ! Devuelve un detalle de carrito asociado a un ID
     */
    public function show($cod_usu): JsonResponse 
    {
        $carrito = Carrito::with([
            'detalles.variante.camiseta'
        ])->where('cod_usu', $cod_usu)->firstOrFail();

        $resultado = $carrito->detalles->map(function ($detalle) {

            $variante = $detalle->variante;
            $camiseta = $variante->camiseta;

            return [
                'cod_det_carr' => $detalle->cod_det_carr,
                'cantidad' => $detalle->cantidad,
                'fecha_agregado' => $detalle->fecha_agregado,
                'nombre_personalizado' => $detalle->nombre_personalizado,
                'dorsal_personalizado' => $detalle->dorsal_personalizado,

                'precio_unitario' => $variante->precio,
                'subtotal' => $detalle->cantidad * $variante->precio,

                'variante' => [
                    'cod_var' => $variante->cod_var,
                    'talla' => $variante->talla,
                    'stock' => $variante->stock,
                ],

                'camiseta' => [
                    'cod_cam' => $camiseta->cod_cam,
                    'nombre' => $camiseta->nombre,
                    'color' => $camiseta->color,
                    'imagen_principal' => $camiseta->imagen_principal,
                ]
            ];
        });

        return response()->json([
            'carrito' => [
                'cod_carr' => $carrito->cod_carr,
                'fecha_creacion' => $carrito->fecha_creacion,
            ],
            'detalles' => $resultado
        ]);
    }




    /**
     * Summary of carrito
     * @param mixed $id
     * @return \App\Models\Carrito
     * 
     * ? GET /api/detalle-carritos/{id}/carrito
     * ! Devuelve el carrito asociado a un detalle por ID
     */
    public function carrito($id)
    {

        return DetalleCarrito::findOrFail($id)->carrito;
    }

    /**
     * Summary of variante
     * @param mixed $id
     * @return \App\Models\VarianteCamiseta
     * 
     * ? GET /api/detalle-carritos/{id}/variante
     * ! Devuelve la variante de camiseta asociada a un detalle por ID
     */
    public function variante($id)
    {

        return DetalleCarrito::findOrFail($id)->variante;
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
