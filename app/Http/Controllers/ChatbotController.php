<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    private string $apiKey;
    private string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    private string $systemPrompt = <<<'PROMPT'
Eres el asistente virtual de GolStyle, una tienda online especializada en camisetas de fútbol oficiales.
Tu nombre es "GolBot" y siempre debes ser amable, conciso y útil.

Información sobre GolStyle:
- Vendemos camisetas de fútbol de equipos de clubes (LaLiga, Premier League, Bundesliga, Serie A, etc.) y selecciones nacionales.
- Disponemos de tallas: XS, S, M, L, XL, XXL.
- Los pedidos se pueden consultar en la sección "Mis Pedidos" del perfil del usuario.
- Los estados de pedido son: pendiente, enviado, entregado, cancelado.
- Para personalizar una camiseta (dorsal y nombre) el usuario debe indicarlo al añadir al carrito.
- Las devoluciones se gestionan contactando con nosotros a través del formulario de contacto.
- El envío estándar tarda entre 3 y 5 días laborables.
- Para cualquier incidencia con un pedido específico, el usuario puede usar el formulario de contacto indicando el número de pedido.

Normas de comportamiento:
- Solo responde sobre temas relacionados con GolStyle, fútbol, camisetas o pedidos.
- Si te preguntan algo fuera de tu ámbito, indica amablemente que solo puedes ayudar con temas de la tienda.
- No inventes precios ni stocks concretos; indica que consulten el catálogo.
- Responde siempre en español.
- Sé breve: máximo 3-4 frases por respuesta.
PROMPT;

    public function chat(Request $request)
    {
        $request->validate([
            'message'  => 'required|string|max:1000',
            'history'  => 'array|max:20',
            'history.*.role' => 'required|in:user,model',
            'history.*.text' => 'required|string|max:2000',
        ]);

        $contents = [];

        foreach ($request->input('history', []) as $turn) {
            $contents[] = [
                'role'  => $turn['role'],
                'parts' => [['text' => $turn['text']]],
            ];
        }

        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $request->input('message')]],
        ];

        $response = Http::timeout(15)->post(
            $this->apiUrl . '?key=' . $this->apiKey,
            [
                'systemInstruction' => [
                    'parts' => [['text' => $this->systemPrompt]],
                ],
                'contents'          => $contents,
                'generationConfig'  => [
                    'maxOutputTokens' => 300,
                    'temperature'     => 0.7,
                ],
            ]
        );

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo conectar con el asistente.'], 502);
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text', '');

        if (empty($text)) {
            return response()->json(['error' => 'El asistente no generó respuesta.'], 502);
        }

        return response()->json(['reply' => trim($text)]);
    }

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', '');
    }
}
