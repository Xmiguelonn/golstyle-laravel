<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Liga;
use Illuminate\Http\Request;

class EquipoAdminController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with('liga')->orderBy('nombre')->get();
        $ligas   = Liga::orderBy('nombre')->get();
        return view('admin.categorias.equipos', compact('equipos', 'ligas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100|unique:equipo,nombre',
            'cod_lig' => 'required|exists:liga,cod_lig',
        ]);
        Equipo::create($request->only('nombre', 'cod_lig'));
        return redirect()->route('admin.equipos.index')->with('success', 'Equipo creado correctamente.');
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100|unique:equipo,nombre,' . $equipo->cod_equi . ',cod_equi',
            'cod_lig' => 'required|exists:liga,cod_lig',
        ]);
        $equipo->update($request->only('nombre', 'cod_lig'));
        return redirect()->route('admin.equipos.index')->with('success', 'Equipo actualizado.');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('admin.equipos.index')->with('success', 'Equipo eliminado.');
    }
}
