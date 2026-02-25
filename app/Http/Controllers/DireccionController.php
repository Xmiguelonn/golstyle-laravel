<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Direccion>
     * 
     * ? GET /api/direcciones
     * ! Devuelve todas las direcciones
     */
    public function index()
    {
        
        return Direccion::all();
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
     * @return Direccion|\Illuminate\Database\Eloquent\Collection<int, Direccion>
     * 
     * ? GET /api/direcciones/{id}
     * ! Devuelve una dirección asociada a un ID
     */
    public function show($id)
    {
        
        return Direccion::findOrFail($id);
    }

    /**
     * Summary of ciudad
     * @param mixed $id
     * @return \App\Models\Ciudad
     * 
     * ? GET /api/direcciones/{id}/ciudad
     * ! Devuelve la ciudad asociad a una dirección por ID
     */
    public function ciudad($id){

        return Direccion::findOrFail($id)->ciudad;
    }

    /**
     * Summary of usuario
     * @param mixed $id
     * @return \App\Models\Usuario
     * 
     * ? GET /api/direcciones/{id}/usuario
     * ! Devuelve el usuario dueño de una dirección asociada a un ID
     */
    public function usuario($id) {

        return Direccion::findOrFail($id)->usuario;
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
