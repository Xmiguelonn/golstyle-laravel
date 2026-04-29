<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camiseta;
use App\Models\Equipo;
use App\Models\Seleccion;
use App\Models\Temporada;
use Illuminate\Http\Request;

class CamisetaAdminController extends Controller
{
    public function index()
    {
        $camisetas = Camiseta::with(['equipo', 'seleccion', 'temporada'])
            ->orderBy('cod_cam', 'desc')
            ->paginate(15);

        return view('admin.camisetas.index', compact('camisetas'));
    }

    public function create()
    {
        $equipos    = Equipo::orderBy('nombre')->get();
        $selecciones = Seleccion::orderBy('nombre')->get();
        $temporadas = Temporada::orderByDesc('inicio')->get();

        return view('admin.camisetas.create', compact('equipos', 'selecciones', 'temporadas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'           => 'required|string|max:100',
            'color'            => 'required|string|max:30',
            'precio'           => 'required|numeric|min:0',
            'cod_tem'          => 'required|exists:temporada,cod_tem',
            'cod_equi'         => 'nullable|exists:equipo,cod_equi',
            'cod_sel'          => 'nullable|exists:seleccion,cod_sel',
            'imagen_principal' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('imagen_principal')) {
            $file = $request->file('imagen_principal');
            $data['imagen_principal'] = 'data:' . $file->getMimeType() . ';base64,' .
                base64_encode(file_get_contents($file->getRealPath()));
        } else {
            unset($data['imagen_principal']);
        }

        Camiseta::create($data);

        return redirect()->route('admin.camisetas.index')
            ->with('success', 'Camiseta creada correctamente.');
    }

    public function edit(Camiseta $camiseta)
    {
        $equipos    = Equipo::orderBy('nombre')->get();
        $selecciones = Seleccion::orderBy('nombre')->get();
        $temporadas = Temporada::orderByDesc('inicio')->get();

        return view('admin.camisetas.edit', compact('camiseta', 'equipos', 'selecciones', 'temporadas'));
    }

    public function update(Request $request, Camiseta $camiseta)
    {
        $data = $request->validate([
            'nombre'           => 'required|string|max:100',
            'color'            => 'required|string|max:30',
            'precio'           => 'required|numeric|min:0',
            'cod_tem'          => 'required|exists:temporada,cod_tem',
            'cod_equi'         => 'nullable|exists:equipo,cod_equi',
            'cod_sel'          => 'nullable|exists:seleccion,cod_sel',
            'imagen_principal' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('imagen_principal')) {
            $file = $request->file('imagen_principal');
            $data['imagen_principal'] = 'data:' . $file->getMimeType() . ';base64,' .
                base64_encode(file_get_contents($file->getRealPath()));
        } else {
            unset($data['imagen_principal']);
        }

        $camiseta->update($data);

        return redirect()->route('admin.camisetas.index')
            ->with('success', 'Camiseta actualizada correctamente.');
    }

    public function destroy(Camiseta $camiseta)
    {
        $camiseta->delete();

        return redirect()->route('admin.camisetas.index')
            ->with('success', 'Camiseta eliminada correctamente.');
    }
}
