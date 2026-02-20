<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Liga;
use Illuminate\Http\Request;

class LigaController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Liga>|\Illuminate\Support\Collection<int, \stdClass>
     * 
     * ? GET /api/ligas
     * ! Devuelve todas las ligas
     */
    public function index()
    {
        
        return Liga::all();
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
     * @return Liga|\Illuminate\Database\Eloquent\Collection<int, Liga>
     * 
     * ?GET /api/ligas/{id}
     * ! Devuelve la información de una liga asociada a un ID
     */
    public function show($id)
    {
        return Liga::findOrFail($id);
    }

    /**
     * Summary of equipos
     * @param mixed $id
     * @return Equipo
     * 
     * ? GET /api/camisetas/{id}/equipos
     * ! Devuelve los equipos de una liga
     */
    public function equipos($id) {

        return Liga::findOrFail($id)->equipos;
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
