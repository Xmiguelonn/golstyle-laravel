<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\ImagenCamiseta;
use App\Models\VarianteCamiseta;
use Illuminate\Http\Request;

class CamisetaController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Camiseta>|\Illuminate\Support\Collection<int, \stdClass>
     * 
     * ? GET /api/camisetas
     * ! Devuelve todas las camiseats
     */
    public function index()
    {
        return Camiseta::with([
            'variantes',
            'imagenes',
            'temporada',
            'seleccion',
            'equipo',
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
     * @return Camiseta|\Illuminate\Database\Eloquent\Collection<int, Camiseta>
     * 
     * ? GET /api/camisetas/{id}
     * ! Devuelve la información de una camiseta asociada a un ID
     */
    public function show($id)
    {
        return Camiseta::with([
            'variantes',
            'imagenes',
            'temporada',
            'seleccion',
            'equipo'
        ])->findOrFail($id);
    }

    /**
     * Summary of variantes
     * @param mixed $id
     * @return VarianteCamiseta
     * 
     * ? GET /api/camisetas/{id}/variantes
     * ! Devuelve las variantes de una camiseta 
     */
    public function variantes($id): VarianteCamiseta {

        return Camiseta::findOrFail($id)->variantes;
    }


    /**
     * Summary of imagenes
     * @param mixed $id
     * @return ImagenCamiseta
     * 
     * ? GET /api/camisetas/{id}/imagenes
     * ! Devuelve las imágenes de una camiseta
     */
    public function imagenes($id): ImagenCamiseta  {

        return Camiseta::findOrFail($id)->imagenes;
    }


    /**
     * Update the specified resource in storage.
     * 
     * TODO
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * 
     * TODO
     */
    public function destroy(string $id)
    {
        //
    }
}
