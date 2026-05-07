<!DOCTYPE html>
<html>
<head>
    <style>
        .container { font-family: sans-serif; padding: 20px; color: #333; }
        .header { background: #000; color: #fff; padding: 10px; text-align: center; }
        .content { margin-top: 20px; line-height: 1.6; }
        .button { background: #ffcc00; color: #000; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GOLSTYLE</h1>
        </div>
        <div class="content">
            <h2>¡Hola, {{ $user->nombre }}!</h2>
            <p>Gracias por unirte a nuestra comunidad. Estamos encantados de tenerte con nosotros.</p>
            <p>Ya puedes empezar a explorar nuestros productos y realizar tus pedidos.</p>
            <br>
            <a href="http://localhost:4217" class="button">Ir a la tienda</a>
        </div>
    </div>
</body>
</html>