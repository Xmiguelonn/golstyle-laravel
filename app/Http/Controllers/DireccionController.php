<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DireccionController extends Controller
{

    /**
     * Summary of index
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? GET /api/direcciones
     * ! Devuelve todas las direcciones pertenecientes a un usuario
     */
    public function index(Request $request): JsonResponse
    {

        // Obtener el usuario
        $usuario = $request->user();

        // Obtener las direcciones del usuario
        $direcciones = Direccion::where('cod_usu', $usuario->cod_usu)->get();

        // Devolver el resultado
        return response()->json([

            'direcciones' => $direcciones,
        ]);
    }

    /**
     * Summary of store
     * @param Request $request
     * @return JsonResponse
     * 
     * ? POST /api/direcciones/agregar
     * ! Añade una dirección creada por el usuario
     */
    public function store(Request $request): JsonResponse
    {

        // Obtener el usuario
        $usuario = $request->user();

        // Validación de datos
        $request->validate([

            'nombre' => 'required|string|max:50',
            'calle' => 'required|string|max:100',
            'num' => 'required|string|max:10',
            'piso' => 'nullable|string|max:10',
            'cp' => 'required|string|max:10',
            'telefono' => 'required|string|max:20',
            'ciudad' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
        ]);

        $existeDireccion = Direccion::where('cod_usu', $usuario->cod_usu)
            ->where('nombre', $request->nombre)
            ->exists();

        if ($existeDireccion) {
            return response()->json([
                'message' => 'Ya tienes una dirección con ese nombre.'
            ], 422);
        }

        // Crear dirección
        Direccion::create([

            'nombre' => $request->nombre,
            'calle' => $request->calle,
            'num' => $request->num,
            'piso' => $request->piso,
            'cp' => $request->cp,
            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad,
            'provincia' => $request->provincia,
            'cod_usu' => $usuario->cod_usu,
        ]);

        return response()->json([

            'mensaje' => 'Dirección creada correctamente',
        ]);
    }


    /**
     * Summary of show
     * @param Request $request
     * @param mixed $id
     * @return JsonResponse
     * 
     * ? GET /api/direcciones/{id}
     * ! Devuelve una dirección asociada a un ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        // Obtener el usuario
        $usuario = $request->user();

        // Obtener la dirección -> 404 si falla
        $direccion = Direccion::findOrFail($id);

        // Comprobar que pertenece al usuario
        if ($direccion->cod_usu !== $usuario->cod_usu) {

            return response()->json([

                'error' => 'No tienes permiso para ver esta dirección'
            ], 403);
        }

        // Devolver la dirección
        return response()->json([

            'nombre' => $direccion->nombre,
            'calle' => $direccion->calle,
            'num' => $direccion->num,
            'piso' => $direccion->piso,
            'cp' => $direccion->cp,
            'telefono' => $direccion->telefono,
            'ciudad' => $direccion->ciudad,
            'provincia' => $direccion->provincia,
        ]);
    }


    /**
     * Summary of usuario
     * @param mixed $id
     * @return \App\Models\Usuario
     * 
     * ? GET /api/direcciones/{id}/usuario
     * ! Devuelve el usuario dueño de una dirección asociada a un ID
     */
    public function usuario($id)
    {

        return Direccion::findOrFail($id)->usuario;
    }


    /**
     * Summary of update
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * 
     * ? PUT /api/direcciones/actualizar/{id}
     * ! Actualiza una dirección de un usuario
     */
    public function update(Request $request, string $id): JsonResponse
    {

        // Obtener el usuario autenticado
        $usuario = $request->user();


        // Obtener la dirección (404 si no existe)
        $direccion = Direccion::findOrFail($id);

        // Comprobar que pertenece al usuario
        if ($direccion->cod_usu !== $usuario->cod_usu) {

            return response()->json([

                'error' => 'No tienes los permisos para editar esta dirección'
            ], 403);
        }

        // Validación de datos
        $request->validate([

            'nombre' => 'required|string|max:50|unique:direccion,nombre,' . $id . ',cod_dir,cod_usu,' . $usuario->cod_usu,
            'calle' => 'required|string|max:100',
            'num' => 'required|string|max:10',
            'piso' => 'nullable|string|max:10',
            'cp' => 'required|string|max:10',
            'telefono' => 'required|string|max:20',
            'ciudad' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
        ]);

        // Actualizar la dirección
        $direccion->update([

            'nombre' => $request->nombre,
            'calle' => $request->calle,
            'num' => $request->num,
            'piso' => $request->piso,
            'cp' => $request->cp,
            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad,
            'provincia' => $request->provincia,
        ]);

        // Devolver respuesta
        return response()->json([

            'mensaje' => 'Dirección actualizada con éxito'
        ]);
    }


    /**
     * Summary of destroy
     * @param Request $request
     * @param mixed $id
     * @return JsonResponse
     * 
     * ? DELETE /api/direcciones/eliminar/{id}
     * ! Elimina una dirección del usuario
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        // Obtener el usuario
        $usuario = $request->user();

        // Obtener la dirección -> 404 si falla
        $direccion = Direccion::findOrFail($id);

        // Comprobar que la dirección pertenece al usuario
        if ($direccion->cod_usu !== $usuario->cod_usu) {

            return response()->json([

                'error' => 'No tienes los permisos para eliminar esta direccion'
            ], 403);
        }

        // Eliminar la direccion
        $direccion->delete();

        // Devolver respuesta
        return response()->json([

            'mensaje' => 'Direccion eliminada correctamente'
        ]);
    }
}
