<?php

namespace App\Http\Controllers;

use App\Models\DetalleCarrito;
use Illuminate\Http\Request;

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
     * @param mixed $id
     * @return DetalleCarrito|\Illuminate\Database\Eloquent\Collection<int, DetalleCarrito>
     * 
     * ? GET /api/detalle-carritos/{id}
     * ! Devuelve un detalle de carrito asociado a un ID
     */
    public function show($id)
    {
        
        return DetalleCarrito::findOrFail($id);
    }

    /**
     * Summary of carrito
     * @param mixed $id
     * @return \App\Models\Carrito
     * 
     * ? GET /api/detalle-carritos/{id}/carrito
     * ! Devuelve el carrito asociado a un detalle por ID
     */
    public function carrito($id) {

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
    public function variante($id) {

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
