<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\DetallePedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{


    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Pedido>
     * 
     * ? GET /api/pedidos
     * ! Devuelve todos los pedidos
     */
    public function index()
    {
        
        return Pedido::all();
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
     * @return Pedido|\Illuminate\Database\Eloquent\Collection<int, Pedido>
     * 
     * ? GET /api/pedidos/{id}
     * ! Devuelve un pedido asociado a un ID
     */
    public function show($id)
    {
        
        return Pedido::findOrFail($id);
    }



    /**
     * Summary of detalles
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetallePedido>
     * 
     * ? GET /api/pedidos/{id}/detalles
     * ! Devuelve los detalles de un pedido asociado a un ID
     */
    public function detalles($id) {

        return Pedido::findOrFail($id)->detalles;
    }

    /**
     * Summary of usuario
     * @param mixed $id
     * @return \App\Models\Usuario
     * 
     * ? GET /api/pedidos/{id}/usuario
     * ! Devuelve el usuario dueño de un pedido asociado a un ID
     */
    public function usuario($id) {

        return Pedido::findOrFail($id)->usuario;
    }

    /**
     * Summary of direccion
     * @param mixed $id
     * @return \App\Models\Direccion
     * 
     * ? GET /api/pedidos/{id}/direccion
     * ! Devuelve la dirección de un pedido asociado a un ID
     */
    public function direccion($id) {

        return Pedido::findOrFail($id)->direccion;
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
