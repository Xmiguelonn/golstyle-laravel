<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; margin: 0; padding: 0; }
        .container { padding: 20px; max-width: 600px; margin: 0 auto; border: 1px solid #eee; }
        .header { background: #000; color: #ffcc00; padding: 20px; text-align: center; }
        .header h1 { margin: 0; letter-spacing: 2px; }
        .content { padding: 20px; }
        .info-pedido { margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #f8f8f8; text-align: left; padding: 10px; border-bottom: 2px solid #eee; }
        td { padding: 10px; border-bottom: 1px solid #eee; vertical-align: top; }
        
        .personalizacion { font-size: 12px; color: #666; font-style: italic; }
        .total-box { text-align: right; padding: 20px; background: #fafafa; }
        .total-amount { font-size: 20px; font-weight: bold; color: #000; }
        
        .datos { background: #fffdf5; padding: 15px; border-left: 4px solid #ffcc00; margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 11px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GOLSTYLE</h1>
        </div>
        
        <div class="content">
            <div class="info-pedido">
                <h2>¡Gracias por tu compra, {{ $pedido->usuario->nombre }}!</h2>
                <p>Hemos recibido tu pedido correctamente. Aquí tienes el resumen de lo que hemos preparado para ti.</p>
                <strong>Pedido #{{ $pedido->cod_ped }}</strong> | Fecha: {{ $pedido->fecha }}
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->detalles as $detalle)
                    <tr>
                        <td>
                            <strong>{{ $detalle->variante->camiseta->nombre }}</strong><br>
                            Talla: {{ $detalle->variante->talla }}
                            @if($detalle->nombre_personalizado || $detalle->dorsal_personalizado)
                                <div class="personalizacion">
                                    Personalización: {{ $detalle->nombre_personalizado }} ({{ $detalle->dorsal_personalizado }})
                                </div>
                            @endif
                        </td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ number_format($detalle->precio_unid * $detalle->cantidad, 2) }}€</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-box">
                <span>TOTAL DEL PEDIDO:</span><br>
                <span class="total-amount">{{ number_format($pedido->total, 2) }}€</span>
            </div>

            <div class="datos">
                <strong>Dirección de envío:</strong><br>
                {{ $pedido->direccion->nombre }}<br>
                {{ $pedido->direccion->calle }} {{ $pedido->direccion->num }} {{ $pedido->direccion->piso }}<br>
                {{ $pedido->direccion->ciudad }}, {{ $pedido->direccion->provincia }}
            </div>
            <div class="datos">
                <strong>Télefono de contacto:</strong><br>
                {{ $pedido->direccion->telefono }}
            </div>
        </div>

        <div class="footer">
            Este es un correo automático, por favor no respondas a esta dirección. <br>
            © 2026 GolStyle - Tienda Oficial de Camisetas.
        </div>
    </div>
</body>
</html>