<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    /**
     * Enviar mensaje al webhook de n8n
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string|max:5000',
            'webhook_url' => 'required|url',
            'session_id' => 'nullable|string|max:255',
        ]);

        try {
            // Generar un session_id si no existe
            $sessionId = $data['session_id'] ?? session()->getId();

            // Enviar mensaje al webhook de n8n con el formato correcto
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::timeout(30)->post($data['webhook_url'], [
                'mensaje' => $data['message'],
                'sessionId' => $sessionId,
            ]);

            if ($response->successful()) {
                $responseData = $response->json() ?? [];
                
                // Extraer la respuesta del bot (puede venir como 'reply', 'response', 'message', etc.)
                $botReply = $responseData['reply'] ?? 
                           $responseData['response'] ?? 
                           $responseData['message'] ?? 
                           $responseData['output'] ?? 
                           json_encode($responseData);
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'response' => $botReply,
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Error al comunicarse con el bot (código: ' . $response->status() . ')',
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Endpoint de prueba local - Simula respuestas de un bot
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testBot(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $message = strtolower($data['message']);
        
        // Simular diferentes respuestas según el mensaje
        $responses = [
            'hola' => '¡Hola! Soy tu asistente virtual del sistema de inventario. ¿En qué puedo ayudarte?',
            'ayuda' => 'Puedo ayudarte con información sobre: activos, ubicaciones, mantenimientos, asignaciones, auditorías y más. ¿Qué necesitas saber?',
        ];

        // Intentar obtener datos de la base de datos (si está disponible)
        try {
            $responses['activos'] = 'Actualmente tenemos ' . \App\Models\Activo::count() . ' activos registrados en el sistema.';
            $responses['ubicaciones'] = 'Hay ' . \App\Models\UbicacionFisica::count() . ' ubicaciones físicas registradas.';
            $responses['mantenimiento'] = 'Hay ' . \App\Models\Mantenimiento::count() . ' mantenimientos registrados en el sistema.';
        } catch (\Exception $e) {
            // Si no hay conexión a BD, usar respuestas estáticas
            $responses['activos'] = 'El sistema de gestión de activos está listo. Conecta la base de datos para obtener estadísticas en tiempo real.';
            $responses['ubicaciones'] = 'El módulo de ubicaciones está disponible. Configura la base de datos para ver las ubicaciones registradas.';
            $responses['mantenimiento'] = 'El módulo de mantenimientos está activo. La base de datos te permitirá ver el historial completo.';
        }

        // Buscar una respuesta coincidente
        $response = null;
        foreach ($responses as $key => $value) {
            if (str_contains($message, $key)) {
                $response = $value;
                break;
            }
        }

        // Respuesta por defecto
        if (!$response) {
            $response = "He recibido tu mensaje: '{$data['message']}'. Este es un bot de prueba local. Para conectar con tu bot real de n8n, cambia al modo 'n8n Webhook' y asegúrate de que el webhook esté activo.";
        }

        return response()->json([
            'success' => true,
            'data' => [
                'response' => $response,
            ],
        ]);
    }
}
