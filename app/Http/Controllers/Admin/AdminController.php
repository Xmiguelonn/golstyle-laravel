<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camiseta;
use App\Models\Contacto;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\VarianteCamiseta;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'usuarios'           => Usuario::where('rol_id', Rol::USUARIO)->count(),
            'camisetas'          => Camiseta::count(),
            'pedidos'            => Pedido::where('estado_id', '!=', EstadoPedido::CANCELADO)->count(),
            'ingresos'           => Pedido::where('estado_id', '!=', EstadoPedido::CANCELADO)->sum('total'),
            'pedidos_pendientes' => Pedido::where('estado_id', EstadoPedido::PENDIENTE)->count(),
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
