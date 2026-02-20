<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\Temporada;
use Illuminate\Http\Request;

class TemporadaController extends Controller
{
    

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Temporada>|\Illuminate\Support\Collection<int, \stdClass>
     * 
     * ? GET /api/temporadas
     * ! Devuelve todas las temporadas
     */
    public function index()
    {
        
        return Temporada::all();
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
     * @return Temporada|\Illuminate\Database\Eloquent\Collection<int, Temporada>
     * 
     * ? GET /api/temporadas/{id}
     * ! Devuelve la temporada asociada a un ID
     */
    public function show($id)
    {

        return Temporada::findOrFail($id);
    }

    /**
     * Summary of camisetas
     * @param mixed $id
     * @return Camiseta
     * 
     * ? GET /api/temporadas/{id}/camisetas
     * ! Devuelve las camisetas asociadas a una temporada
     */
    public function camisetas($id) {

        return Temporada::findOrFail($id)->camisetas;
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
