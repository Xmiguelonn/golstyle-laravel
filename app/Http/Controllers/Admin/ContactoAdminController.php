<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;

class ContactoAdminController extends Controller
{
    public function index()
    {
        $contactos = Contacto::orderByDesc('created_at')->paginate(20);
        return view('admin.gestion.mensajes', compact('contactos'));
    }

    public function show(Contacto $contacto)
    {
        return view('admin.gestion.mensaje-detalle', compact('contacto'));
    }

    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        return redirect()->route('admin.contactos.index')
            ->with('success', 'Mensaje eliminado.');
    }
}
