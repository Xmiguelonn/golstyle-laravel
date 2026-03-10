<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\ImagenCamiseta;
use App\Models\VarianteCamiseta;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


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
     * Summary of catalogo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? GET /api/camisetas/catalogo
     * ! Devuelve la información PAGINADA para el catálogo 
     */
    public function catalogo(Request $request): JsonResponse
    {

        $query = Camiseta::with([

            'equipo.liga',
            'seleccion',
            'temporada',
        ]);

        // FILTROS DE BÚSQUEDA
        if ($request->liga) {

            $query->whereRelation('equipo.liga', 'nombre', $request->liga);
        }

        if ($request->equipo) {

            $query->whereRelation('equipo', 'nombre', $request->equipo);
        }

        if ($request->seleccion) {

            $query->whereRelation('seleccion', 'nombre', $request->seleccion);
        }

        if ($request->temporada) {

            $query->whereRaw("CONCAT(inicio, '/', fin) = ?", [$request->temporada]);
        }

        // PAGINACIÓN
        $camisetas = $query->paginate(20);

        // CREAR ARRAY RESULTADO
        $resultado = [];

        foreach ($camisetas as $camiseta) {

            $resultado[] = [

                'cod_cam' => $camiseta->cod_cam,
                'nombre' => $camiseta->nombre,
                'imagen_principal' => $camiseta->imagen_principal,
                'precio' => $camiseta->precio,
                'equipo' => $camiseta->equipo?->nombre,
                'liga' => $camiseta->equipo?->liga?->nombre,
                'seleccion' => $camiseta->seleccion?->nombre,
                'temporada' => $camiseta->temporada->inicio . '/' . $camiseta->temporada->fin,
            ];
        }

        // REEMPLAZAR LA COLECCIÓN DEL PAGINADOR
        $camisetas->setCollection(collect($resultado));

        // DEVOLVER RESULTADO
        return response()->json($camisetas);
    }



    /**
     * Summary of crear
     * @param Request $request
     * @return JsonResponse
     * 
     * ? POST /api/camisetas/crear
     * ! Añade una camiseta a la base de datos
     */
    public function crear(Request $request): JsonResponse
    {

        // Validación de datos
        $validated = $request->validate([

            'nombre' => 'required|string|max:100',
            'color' => 'required|string|max:30',
            'cod_tem' => 'required|integer|exists:temporada,cod_tem',
            'precio' => 'required|numeric|min:0',
            'imagen_principal' => 'nullable|string',

            'cod_equi' => 'nullable|integer|exists:equipo,cod_equi',
            'cod_sel' => 'nullable|integer|exists:seleccion,cod_sel',
        ]);

        // Validar que una camiseta no pertenezca a un equipo y una selección a la vez
        if ($request->cod_equi && $request->cod_sel) {

            return response()->json([

                'error' => 'Una camiseta no puedo pertenecer a un equipo y una selección al mismo tiempo'
            ], 400);
        }

        // Crear la camiseta
        $camiseta = Camiseta::create([

            'nombre' => $validated['nombre'],
            'color' => $validated['color'],
            'cod_tem' => $validated['cod_tem'],
            'precio' => $validated['precio'],
            'imagen_principal' => $validated['imagen_principal'] ?? null,
            'cod_equi' => $validated['cod_equi'] ?? null,
            'cod_sel' => $validated['cod_sel'] ?? null,
        ]);


        return response()->json([

            'mensaje' => 'Camiseta creada correctamente',
            'camiseta' => $camiseta,
        ], 201);
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
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? GET /api/camisetas/{id}
     * ! Devuelve los detalles de una camiseta asociada a un ID
     */
    public function show($id): JsonResponse
    {
        $camiseta = Camiseta::with([

            'equipo.liga',
            'seleccion',
            'temporada',
            'imagenes',
            'variantes'
        ])->find($id);

        // Si no existe la camiseta, devolvemos un error 404
        if (!$camiseta) {

            return response()->json([
                'error' => 'Camiseta no encontrada'
            ], 404);
        }

        // CREAR ARRAY RESULTADO

        $resultado = [

            'cod_cam' => $camiseta->cod_cam,
            'nombre' => $camiseta->nombre,
            'color' => $camiseta->color,
            'precio' => $camiseta->precio,
            'imagen_principal' => $camiseta->imagen_principal,

            // RELACIONES
            'equipo' => $camiseta->equipo?->nombre,
            'liga' => $camiseta->equipo?->liga?->nombre,
            'seleccion' => $camiseta->seleccion?->nombre,
            'temporada' => $camiseta->temporada->inicio . '/' . $camiseta->temporada->fin,

            // IMÁGENES
            //! de la IMAGENES devuelve solo la columna IMAGEN
            'imagenes' => $camiseta->imagenes->pluck('imagen'),

            // Variantes (tallas + stock)
            'variantes' => $camiseta->variantes->map(function ($var) {

                return [

                    'cod_var' => $var->cod_var,
                    'talla' => $var->talla,
                    'stock' => $var->stock,
                ];
            }),
        ];

        return response()->json($resultado);
    }

    /**
     * Summary of variantes
     * @param mixed $id
     * @return VarianteCamiseta
     * 
     * ? GET /api/camisetas/{id}/variantes
     * ! Devuelve las variantes de una camiseta 
     */
    public function variantes($id): VarianteCamiseta
    {

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
    public function imagenes($id): ImagenCamiseta
    {

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
