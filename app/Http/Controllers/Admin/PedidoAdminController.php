<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoAdminController extends Controller
{
    const ESTADOS = ['pendiente', 'enviado', 'entregado', 'cancelado'];

    public function index(Request $request)
    {
        $query = Pedido::with(['usuario', 'estadoObj'])->orderByDesc('fecha')->orderByDesc('cod_ped');

        if ($request->filled('estado')) {
            $estadoId = EstadoPedido::where('nombre', $request->estado)->value('id');
            if ($estadoId) {
                $query->where('estado_id', $estadoId);
            }
        }

        if ($request->filled('buscar')) {
            $query->where('cod_ped', 'like', '%' . $request->buscar . '%');
        }

        $pedidos = $query->paginate(20)->withQueryString();
        $estados = self::ESTADOS;

        return view('admin.gestion.pedidos', compact('pedidos', 'estados'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['detalles.variante.camiseta', 'usuario', 'direccion']);
        $estados = self::ESTADOS;

        return view('admin.gestion.pedido-detalle', compact('pedido', 'estados'));
    }

    public function updateEstado(Request $request, Pedido $pedido)
    {
        $request->validate(['estado' => 'required|in:' . implode(',', self::ESTADOS)]);
        $pedido->update(['estado' => $request->estado]);

        return redirect()->route('admin.pedidos.show', $pedido->cod_ped)
            ->with('success', 'Estado actualizado a «' . ucfirst($request->estado) . '».');
    }
}
