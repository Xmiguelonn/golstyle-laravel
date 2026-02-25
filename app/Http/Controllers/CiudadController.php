<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Ciudad>|\Illuminate\Support\Collection<int, \stdClass>
     * 
     * ? GET /api/ciudades
     * ! Devuelve todas las ciudades
     */
    public function index()
    {
        
        return Ciudad::all();
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
     * @return Ciudad|\Illuminate\Database\Eloquent\Collection<int, Ciudad>
     * 
     * ? GET /api/ciudades/{id}
     * ! Devuelve la selección asociada a un ID
     */
    public function show($id)
    {
        
        return Ciudad::findOrFail($id);
    }

    /**
     * Summary of provincia
     * @param mixed $id
     * @return \App\Models\Provincia
     * 
     * ? GET /api/ciudades/{id}/provincia
     * ! Devuelve la provincia a la que pertenece una ciudad asociad a un ID
     */
    public function provincia($id){

        return Ciudad::findOrFail($id)->provincia;
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
