<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Equipo>|\Illuminate\Support\Collection<int, \stdClass>
     * 
     * ? GET /api/equipos
     * ! Devuelve todos los equipos
     */
    public function index()
    {
        
        return Equipo::with([
            'liga',
        ])->get();
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
     * @return Equipo|\Illuminate\Database\Eloquent\Collection<int, Equipo>
     * 
     * ? GET /api/equipos/{id}
     * ! Devuelve el equipo asociado a un ID
     */
    public function show($id)
    {
        
        return Equipo::with([
            'liga',
        ])->findOrFail($id);
    }

    /**
     * Summary of camisetas
     * @param mixed $id
     * @return Camiseta
     * 
     * ? GET /api/equipos/{id}/camisetas
     * ! Devuelve las camisetas asociadas a un equipo
     */
    public function camisetas($id): Camiseta {

        return Equipo::findOrFail($id)->camisetas;
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
