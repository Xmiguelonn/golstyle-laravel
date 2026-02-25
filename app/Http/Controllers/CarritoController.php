<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;

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
     * @param mixed $id
     * @return \App\Models\DetalleCarrito
     * 
     * ? GET /api/carritos/{id}/detalles
     * ! Devuelve los detalles de un carrito asociado a un ID
     */
    public function detalles($id) {

        return Carrito::findOrFail($id)->detalles;
    }


    /**
     * Summary of usuario
     * @param mixed $id
     * @return \App\Models\Usuario
     * 
     * ? GET /api/carritos/{id}/usuario
     * ! Devuelve el usuario dueño de un carrito asociado a un ID
     */
    public function usuario($id) {

        return Carrito::findOrFail($id)->usuario;
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
