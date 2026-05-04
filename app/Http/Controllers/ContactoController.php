<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoMail;

class ContactoController extends Controller
{
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

        // Datos para el correo
        $data = [
            'correo' => $request->correo,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'idPedido' => $request->idPedido,
        ];

        // Guardar en BD
        Contacto::create([

            'correo' => $request->correo,
            'asunto' => $request->asunto,
            'id_pedido' => $request->idPedido,
            'mensaje' => $request->mensaje,
        ]);

        Mail::to('davidrivasg06@gmail.com')->send(new ContactoMail($data));

        // Devolver respuesta
        return response()->json([

            'mensaje' => 'Mensaje enviado correctamente.'
        ], 200);

    }
}
