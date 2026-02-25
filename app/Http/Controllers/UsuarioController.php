<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Usuario>
     * 
     * ? GET /api/usuarios
     * ! Devuelve todos los usuarios
     */
    public function index()
    {
        
        return Usuario::all();
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
     * @return \App\Models\Usuario
     * 
     * ? GET /api/usuarios/{id}
     * ! Devuelve un usuario asociado a un ID
     */
    public function show($id)
    {
        
        return Usuario::findOrFail($id);
    }

    /**
     * Summary of direcciones
     * @param mixed $id
     * @return \App\Models\Direccion
     * 
     * ? GET /api/usuarios/{id}/direcciones
     * ! Devuelve las direcciones asociadas a un ID de usuario
     */
    public function direcciones($id) {

        return Usuario::findOrFail($id)->direcciones;
    }

    /**
     * Summary of pedidos
     * @param mixed $id
     * @return \App\Models\Pedido
     * 
     * ? GET /api/usuarios/{id}/pedidos
     * ! Devuelve los pedidos asociados a un ID de usuario
     */
    public function pedidos($id){

        return Usuario::findOrFail($id)->pedidos;
    }

    /**
     * Summary of carrito
     * @param mixed $id
     * @return \App\Models\Carrito
     * 
     * ? GET /api/usuarios/{id}/carrito
     * ! Devuelve el carrito asociado un ID de usuario
     */
    public function carrito($id) {

        return Usuario::findOrFail($id)->carrito;
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
