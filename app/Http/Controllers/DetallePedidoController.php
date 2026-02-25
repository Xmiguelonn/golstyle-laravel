<?php

namespace App\Http\Controllers;

use App\Models\DetalleCarrito;
use App\Models\DetallePedido;
use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, DetallePedido>
     * 
     * ? GET /api/detalle-pedidos
     * ! Devuelve todos los detalles de pedido
     */
    public function index()
    {
        
        return DetallePedido::all();
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
     * @return DetallePedido|\Illuminate\Database\Eloquent\Collection<int, DetallePedido>
     * 
     * ? GET /api/detalle-pedidos/{id}
     * ! Devuelve un detalle de pedido asociado a un ID
     */
    public function show($id)
    {
        
        return DetallePedido::findOrFail($id);
    }

    /**
     * Summary of pedido
     * @param mixed $id
     * @return \App\Models\Pedido
     * 
     * ? GET /api/detalle-pedidos/{id}/pedido
     * ! Devuelve el pedido asociado a un detalle por ID
     */
    public function pedido($id) {

        return DetallePedido::findOrFail($id)->pedido;
    }

    /**
     * Summary of variante
     * @param mixed $id
     * @return \App\Models\VarianteCamiseta
     * 
     * ? GET /api/detalle-pedidos/{id}/variante
     * ! Devuelve la variante asociada a un detalle por ID
     */
    public function variante($id) {

        return DetallePedido::findOrFail($id)->variante;
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
