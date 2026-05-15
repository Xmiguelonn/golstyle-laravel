<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Pedido;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\Usuario;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\EstadoPedidoMail;
use App\Mail\ResumenPedidoMail;

class PedidoController extends Controller
{


    /**
     * Summary of index
     * @param Request $request
     * @return JsonResponse
     * 
     * ? GET /api/pedidos
     * ! Devuelve los pedidos de un usuario
     */
    public function index(Request $request)
    {
        // Obtener el usuario
        $usuario = $request->user();

        // Obtener los pedidos del usuario
        $pedidos = Pedido::where('cod_usu', $usuario->cod_usu)->with('estadoObj')->orderBy('fecha', 'desc')->get();

        // Devolver los pedidos
        return response()->json($pedidos);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Summary of crear
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? POST /api/pedidos/crear
     * ! Crea un pedido
     */
    public function crear(Request $request): JsonResponse
    {

        $usuario = $request->user();

        // Validación de datos
        $request->validate([

            'cod_dir' => 'required|integer'
        ]);

        // Obtener la dirección -> 404 si falla
        $direccion = Direccion::findOrFail($request->cod_dir);

        // Comprobar si la dirección pertenece al usuario
        if ($direccion->cod_usu !== $usuario->cod_usu) {

            return response()->json([

                'error' => 'No puedes usar esta dirección'
            ], 403);
        }

        // Obtener el carrito
        $carrito = Carrito::where('cod_usu', $usuario->cod_usu)->first();

        if (!$carrito) {

            return response()->json([

                'error' => 'El carrito está vacío'
            ], 400);
        }

        // Obtener los detalles del carrito
        $detalles = DetalleCarrito::where('cod_carr', $carrito->cod_carr)
            ->with('variante.camiseta')->get();

        if ($detalles->isEmpty()) {

            return response()->json([

                'error' => 'El carrito está vacío'
            ], 400);
        }

        // Calcular el total
        $total = 0;
        foreach ($detalles as $det) {

            $total += $det->variante->camiseta->precio * $det->cantidad;
        }

        // Crear el pedido
        $pedido = Pedido::create([

            'fecha' => now()->toDateString(),
            'total' => $total,
            'estado' => 'pendiente',
            'cod_usu' => $usuario->cod_usu,
            'cod_dir' => $direccion->cod_dir,
        ]);

        // Crear detalles del pedido
        foreach ($detalles as $det) {

            DetallePedido::create([

                'precio_unid' => $det->variante->camiseta->precio,
                'cantidad' => $det->cantidad,
                'cod_ped' => $pedido->cod_ped,
                'cod_var' => $det->cod_var,
                'nombre_personalizado' => $det->nombre_personalizado,
                'dorsal_personalizado' => $det->dorsal_personalizado
            ]);

            // Restar el stock
            $det->variante->stock -= $det->cantidad;
            $det->variante->save();
        }

        // Vaciar carrito
        DetalleCarrito::where('cod_carr', $carrito->cod_carr)->delete();

        Mail::to($usuario->correo)->send(new ResumenPedidoMail($pedido));

        return response()->json([

            'mensaje' => 'Pedido creado correctamente'
        ]);
    }


    /**
     * Summary of show
     * @param Request $request
     * @param mixed $id
     * @return JsonResponse
     * 
     * ? GET /api/pedidos/{id}
     * ! Devuelve los detalles de un pedido
     */
    public function show(Request $request, $id): JsonResponse
    {

        // Obtener le usuario
        $usuario = $request->user();

        // Obtener el pedido -> Si falla devuelve 404
        $pedido = Pedido::findOrFail($id);


        // Verificar que el pedido pertenece al usuario
        if ($pedido->cod_usu !== $usuario->cod_usu) {

            return response()->json([

                'error' => 'No tienes los permisos para ver este pedido'
            ], 403);
        }

        // Obtener la direción asiciada al pedido
        $pedido->load(['direccion', 'estadoObj']);
        $direccion = $pedido->direccion;

        // Obtener los detalles del pedido
        $detalles = DetallePedido::where('cod_ped', $pedido->cod_ped)
            ->with('variante.camiseta')->get();

        // Devolver el resultado
        return response()->json([

            'pedido' => $pedido,
            'detalles' => $detalles,
            'direccion' => $direccion,
        ]);
    }



    /**
     * Summary of cancelar
     * @param Request $request
     * @param mixed $id
     * @return JsonResponse
     * 
     * ? DELETE /api/pedidos/cancelar/{id}
     * ! Cancela un pedido
     */
    public function cancelar(Request $request, $id): JsonResponse
    {

        // Obtener el usuario
        $usuario = $request->user();

        // Obtener el pedido -> 404 si no existe
        $pedido = Pedido::findOrFail($id);

        // Verificar que el pedido pertenece al usuario
        if ($pedido->cod_usu !== $usuario->cod_usu) {

            return response()->json([
                
                'error' => 'No tienes permisos para cancelar el pedido'
            ], 403);
        }

        // Comprobar el estado del pedido
        if ($pedido->estado !== 'pendiente') {

            return response()->json([

                'error' => 'Este pedido no se puede cancelar porque no está pendiente'
            ], 400);
        }

        // Obtener los detalles del pedido
        $detalles = DetallePedido::where('cod_ped', $pedido->cod_ped)
            ->with('variante')
            ->get();

        // Restaurar stock de cada variante
        foreach ($detalles as $detalle) {

            $variante = $detalle->variante;

            if ($variante) {

                $variante->stock += $detalle->cantidad;
                $variante->save();
            }
        }

        // Cambiar el estado a cancelado
        $pedido->estado = 'cancelado';
        $pedido->save();

        $pedido->refresh();

        Mail::to($pedido->usuario->correo)->send(new EstadoPedidoMail($pedido));

        // Devolver respuesta
        return response()->json([

            'mensaje' => 'Pedido cancelado correctamente'
        ]);
    }



    /**
     * Summary of usuario
     * @param mixed $id
     * @return \App\Models\Usuario
     * 
     * ? GET /api/pedidos/{id}/usuario
     * ! Devuelve el usuario dueño de un pedido asociado a un ID
     */
    public function usuario($id)
    {

        return Pedido::findOrFail($id)->usuario;
    }

    /**
     * Summary of direccion
     * @param mixed $id
     * @return \App\Models\Direccion
     * 
     * ? GET /api/pedidos/{id}/direccion
     * ! Devuelve la dirección de un pedido asociado a un ID
     */
    public function direccion($id)
    {

        return Pedido::findOrFail($id)->direccion;
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
