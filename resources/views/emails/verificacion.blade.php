<!DOCTYPE html>
<html>
<head>
    <style>
        .container { font-family: sans-serif; padding: 20px; color: #333; }
        .header { background: #000; color: #fff; padding: 10px; text-align: center; }
        .content { margin-top: 20px; line-height: 1.6; }
        .button { background: #ffcc00; color: #000; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; }
        .footer { margin-top: 40px; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GOLSTYLE</h1>
        </div>
        <div class="content">
            <h2>¡Hola, {{ $usuario->nombre }}!</h2>
            <p>Gracias por registrarte en nuestra tienda. Estamos encantados de tenerte con nosotros.</p>
            <p>Para poder iniciar sesión, explorar nuestros productos y realizar tus pedidos con total seguridad, necesitamos que confirmes tu correo electrónico.</p>
            <br>
            <a href="{{ $url }}" class="button">Verificar mi cuenta</a>
            
            <div class="footer">
                <p>Si no te has registrado en GolStyle, por favor ignora este correo.</p>
            </div>
        </div>
    </div>
</body>
</html>