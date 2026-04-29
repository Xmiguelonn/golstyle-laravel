<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seleccion;
use Illuminate\Http\Request;

class SeleccionAdminController extends Controller
{
    public function index()
    {
        $selecciones = Seleccion::withCount('camisetas')->orderBy('nombre')->get();
        return view('admin.categorias.selecciones', compact('selecciones'));
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100|unique:seleccion,nombre']);
        Seleccion::create(['nombre' => $request->nombre]);
        return redirect()->route('admin.selecciones.index')->with('success', 'Selección creada correctamente.');
    }

    public function update(Request $request, Seleccion $seleccion)
    {
        $request->validate(['nombre' => 'required|string|max:100|unique:seleccion,nombre,' . $seleccion->cod_sel . ',cod_sel']);
        $seleccion->update(['nombre' => $request->nombre]);
        return redirect()->route('admin.selecciones.index')->with('success', 'Selección actualizada.');
    }

    public function destroy(Seleccion $seleccion)
    {
        $seleccion->delete();
        return redirect()->route('admin.selecciones.index')->with('success', 'Selección eliminada.');
    }
}
