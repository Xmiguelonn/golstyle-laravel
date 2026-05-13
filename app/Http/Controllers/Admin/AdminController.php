<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camiseta;
use App\Models\Contacto;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\VarianteCamiseta;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'usuarios'           => Usuario::where('rol', 'usuario')->count(),
            'camisetas'          => Camiseta::count(),
            'pedidos'            => Pedido::where('estado', '!=', 'cancelado')->count(),
            'ingresos'           => Pedido::where('estado', '!=', 'cancelado')->sum('total'),
            'pedidos_pendientes' => Pedido::where('estado', 'pendiente')->count(),
            'mensajes'           => Contacto::count(),
        ];

        $pedidos_recientes = Pedido::with('usuario')
            ->orderByDesc('fecha')
            ->limit(5)
            ->get();

        $stock_bajo = VarianteCamiseta::with('camiseta')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'pedidos_recientes', 'stock_bajo'));
    }
}
