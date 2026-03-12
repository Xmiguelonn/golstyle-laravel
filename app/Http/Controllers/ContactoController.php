<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use Illuminate\Http\JsonResponse;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? POST /api/contacto/enviar
     * ! Agrega un mensaje de contacto a la base de datos
     */
    public function enviar(Request $request): JsonResponse {

        // Validación de datos
        $request->validate([

            'correo' => 'required|email',
            'asunto' => 'required|string',
            'mensaje' => 'required|string',
            'idPedido' => 'nullable|string',
        ]);

        // Guardar en BD
        Contacto::create([

            'correo' => $request->correo,
            'asunto' => $request->asunto,
            'id_pedido' => $request->idPedido,
            'mensaje' => $request->mensaje,
        ]);

        // Devolver respuesta
        return response()->json([

            'mensaje' => 'Mensaje enviado correctamente.'
        ], 200);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
