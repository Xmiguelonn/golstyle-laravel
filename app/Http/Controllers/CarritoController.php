<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\VarianteCamiseta;
use APP\Models\DetalleCarrito;
use Symfony\Component\HttpFoundation\JsonResponse;

class CarritoController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection<int, Carrito>
     * 
     * ? GET /api/carritos
     * ! Devuelve todos los carritos
     */
    public function index()
    {
        
        return Carrito::all();
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
     * @return Carrito|\Illuminate\Database\Eloquent\Collection<int, Carrito>
     * 
     * ? GET /api/carritos/{id}
     * ! Devuelve un carrito asociado a un ID
     */
    public function show($id)
    {
        
        return Carrito::findOrFail($id);
    }

    /**
     * Summary of detalles
     * @param mixed $id
     * @return \App\Models\DetalleCarrito
     * 
     * ? GET /api/carritos/{id}/detalles
     * ! Devuelve los detalles de un carrito asociado a un ID
     */
    public function detalles($id) {

        return Carrito::findOrFail($id)->detalles;
    }


    /**
     * Summary of usuario
     * @param mixed $id
     * @return \App\Models\Usuario
     * 
     * ? GET /api/carritos/{id}/usuario
     * ! Devuelve el usuario dueño de un carrito asociado a un ID
     */
    public function usuario($id) {

        return Carrito::findOrFail($id)->usuario;
    }

    /**
     * Summary of agregar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     *  ? POST /api/carrito/agregar
     * ! Endpoint para agregar un producto al carrito
     */
    public function agregar(Request $request): JsonResponse {

        // OBTENER EL USUARIO AUTENTICADO
        $usuario = $request->user();

        // VALIDACIÓN DE PARÁMETROS
        $request->validate([

            'cod_var' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'nombre_personalizado' => 'nullable|string|max:50',
            'dorsal_personalizado' => 'nullable|integer|min:0|max:99'
        ]);

        // COMPROBAR QUE LA CAMISETA EXISTE
        $variante = VarianteCamiseta::find($request->cod_var);

        if (!$variante) {

            return response()->json([

                'error' => 'Variante no encontrada'
            ], 404);
        }

        // COMPROBAR STOCK
        if ($variante->stock < $request->cantidad ) {

            return response()->json([

                'error' => 'Stock insuficiente'
            ], 400);
        }

        // BUSCAR O CREAR EL CARRITO DEL USUARIO
        $carrito = Carrito::firstOrCreate([

            'cod_usu' => $usuario->cod_usu
        ]);

        // COMPROBAR SI YA EXISTE UNA CAMISETA IGUAL
        $detalleQuery = DetalleCarrito::where('cod_carr', $carrito->cod_carr)->where('cod_var', $request->cod_var);

        // Comprobar el nombre personalizado
        if ($request->nombre_personalizado === null) {

            $detalleQuery->whereNull('nombre_personalizado');
        } else {

            $detalleQuery->where('nombre_personalizado', $request->nombre_personalizado);
        }

        // Comprobar el dorsal personalizado
        if ($request->dorsal_personalizado === null) {

            $detalleQuery->whereNull('dorsal_personalizado');
        } else {

            $detalleQuery->where('dorsal_personalizado', $request->dorsal_personalizado);
        }

        // Hacer la consulta
        $detalle = $detalleQuery->first();


        if ($detalle) {

            $detalle->cantidad += $request->cantidad;
            // actualizar cantidad en la base de datos
            $detalle->save();
        } else {
            
            // crear el nuevo detalle de carrito y añadirlo a la base de datos
            $detalle = DetalleCarrito::create([

                'cod_carr' => $carrito->cod_carr,
                'cod_var' => $request->cod_var,
                'cantidad' => $request->cantidad,
                'nombre_personalizado' => $request->nombre_personalizado,
                'dorsal_personalizado' => $request->dorsal_personalizado,
            ]);
        }

        // Devolver el resultado
        return response()->json([
            'mensaje' => 'Producto añadido al carrito',
            'detalle' => $detalle,
        ]);

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
