<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Liga;
use Illuminate\Http\Request;

class LigaAdminController extends Controller
{
    public function index()
    {
        $ligas = Liga::withCount('equipos')->orderBy('nombre')->get();
        return view('admin.categorias.ligas', compact('ligas'));
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100|unique:liga,nombre']);
        Liga::create(['nombre' => $request->nombre]);
        return redirect()->route('admin.ligas.index')->with('success', 'Liga creada correctamente.');
    }

    public function update(Request $request, Liga $liga)
    {
        $request->validate(['nombre' => 'required|string|max:100|unique:liga,nombre,' . $liga->cod_lig . ',cod_lig']);
        $liga->update(['nombre' => $request->nombre]);
        return redirect()->route('admin.ligas.index')->with('success', 'Liga actualizada.');
    }

    public function destroy(Liga $liga)
    {
        $liga->delete();
        return redirect()->route('admin.ligas.index')->with('success', 'Liga eliminada.');
    }
}
