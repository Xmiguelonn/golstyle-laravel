<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::withCount('pedidos')->orderBy('nombre');

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%$term%")
                  ->orWhere('correo', 'like', "%$term%");
            });
        }

        $usuarios = $query->paginate(20)->withQueryString();

        return view('admin.gestion.usuarios', compact('usuarios'));
    }

    public function updateRol(Request $request, Usuario $usuario)
    {
        $request->validate(['rol' => 'required|in:usuario,admin']);

        if ($usuario->cod_usu === Auth::id()) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $usuario->update(['rol' => $request->rol]);

        return back()->with('success', 'Rol de «' . $usuario->nombre . '» actualizado a ' . $request->rol . '.');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->cod_usu === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario «' . $usuario->nombre . '» eliminado.');
    }
}
