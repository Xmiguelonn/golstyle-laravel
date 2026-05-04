{{-- Vista para el correo de contacto --}}
<!DOCTYPE html>
<html>
<head>
    <title>Nuevo mensaje de contacto</title>
</head>
<body>
    <h1>Nuevo mensaje de contacto</h1>
    <p><strong>Correo:</strong> {{ $correo }}</p>
    <p><strong>Asunto:</strong> {{ $asunto }}</p>
    <p><strong>Mensaje:</strong></p>
    <p>{{ $mensaje }}</p>
    @if($idPedido)
        <p><strong>ID Pedido:</strong> {{ $idPedido }}</p>
    @endif
</body>
</html>