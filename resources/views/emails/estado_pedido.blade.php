<!DOCTYPE html>
<html>
<head>
    <style>
        .container { font-family: sans-serif; padding: 20px; color: #333; }
        .header { background: #000; color: #fff; padding: 10px; text-align: center; }
        .content { margin-top: 20px; line-height: 1.6; }
        
        /* Estilo para resaltar el estado del pedido */
        .badge-estado { 
            background: #000; 
            color: #ffcc00; 
            padding: 8px 15px; 
            border-radius: 5px; 
            font-weight: bold; 
            font-size: 18px;
            display: inline-block;
            margin: 10px 0;
            text-transform: uppercase;
        }

        .button { background: #ffcc00; color: #000; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 20px; }
        .footer { margin-top: 40px; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GOLSTYLE</h1>
        </div>
        <div class="content">
            <h2>¡Hola, {{ $pedido->usuario->nombre }}!</h2>
            
            <p>Te escribimos para avisarte de que hay novedades con tu pedido <strong>#{{ $pedido->cod_ped }}</strong>.</p>
            
            <p>El estado de tu compra se ha actualizado a:</p>
            <div style="text-align: center;">
                <span class="badge-estado">{{ $pedido->estado }}</span>
            </div>

            <p>Estamos trabajando para que disfrutes de tus artículos lo antes posible.</p>
            <br>
            <a href="http://localhost:4200/mis-pedidos" class="button">Ver detalles del pedido</a>
            
            <div class="footer">
                <p>Si tienes alguna duda sobre tu envío, responde a este correo y te ayudaremos.</p>
                <p>© 2025 - GolStyle</p>
            </div>
        </div>
    </div>
</body>
</html>