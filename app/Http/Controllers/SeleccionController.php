<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\Seleccion;
use Illuminate\Http\Request;

class SeleccionController extends Controller
{
    
    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Seleccion>|\Illuminate\Support\Collection<int, \stdClass>
     * 
     * ? GET /api/selecciones
     * ! Devuelve todas las selecciones
     */
    public function index()
    {
        
        return Seleccion::all();
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
     * @return Seleccion|\Illuminate\Database\Eloquent\Collection<int, Seleccion>
     * 
     * ? GET /api/selecciones/{id}
     * ! Devuelve la selección asociad a un ID
     */
    public function show($id)
    {
        
        return Seleccion::findOrFail($id);
    }


    /**
     * Summary of camisetas
     * @param mixed $id
     * @return Camiseta
     * 
     * ? GET /api/selecciones/{id}/camisetas
     * ! Devuelve las camisetas de una selección
     */
    public function camisetas($id) {

        return Seleccion::findOrFail($id)->camisetas;
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
