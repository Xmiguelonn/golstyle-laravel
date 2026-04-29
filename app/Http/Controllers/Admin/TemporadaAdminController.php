<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temporada;
use Illuminate\Http\Request;

class TemporadaAdminController extends Controller
{
    public function index()
    {
        $temporadas = Temporada::withCount('camisetas')->orderByDesc('inicio')->get();
        return view('admin.categorias.temporadas', compact('temporadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inicio' => 'required|digits:4|integer|min:2000|max:2099',
            'fin'    => 'required|digits:4|integer|min:2000|max:2099|gte:inicio',
        ]);
        Temporada::create($request->only('inicio', 'fin'));
        return redirect()->route('admin.temporadas.index')->with('success', 'Temporada creada correctamente.');
    }

    public function update(Request $request, Temporada $temporada)
    {
        $request->validate([
            'inicio' => 'required|digits:4|integer|min:2000|max:2099',
            'fin'    => 'required|digits:4|integer|min:2000|max:2099|gte:inicio',
        ]);
        $temporada->update($request->only('inicio', 'fin'));
        return redirect()->route('admin.temporadas.index')->with('success', 'Temporada actualizada.');
    }

    public function destroy(Temporada $temporada)
    {
        $temporada->delete();
        return redirect()->route('admin.temporadas.index')->with('success', 'Temporada eliminada.');
    }
}
