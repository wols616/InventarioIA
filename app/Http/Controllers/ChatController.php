<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    /**
     * Obtener el usuario autenticado
     */
    private function getAuthenticatedUser(Request $request)
    {
        $usuarioId = $request->session()->get('usuario_id');
        if (!$usuarioId) {
            return null;
        }
        return Usuario::with('persona.rol')->find($usuarioId);
    }

    public function index(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Obtener todas las sesiones del usuario ordenadas por última actividad
        $sessions = ChatSession::where('user_id', $user->id_usuario)
            ->orderBy('last_activity_at', 'desc')
            ->get();

        return view('chat.index', compact('sessions'));
    }

    /**
     * Crear una nueva sesión de chat
     */
    public function createSession(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'No autenticado'], 401);
        }
        
        $session = ChatSession::createNewSession($user->id_usuario);

        return response()->json([
            'success' => true,
            'session' => [
                'id' => $session->id,
                'session_id' => $session->session_id,
                'title' => $session->title,
            ],
        ]);
    }

    /**
     * Obtener el historial de una sesión
     */
    public function getSessionHistory(Request $request, $sessionId)
    {
        $user = $this->getAuthenticatedUser($request);
        
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'No autenticado'], 401);
        }
        
        $session = ChatSession::where('session_id', $sessionId)
            ->where('user_id', $user->id_usuario)
            ->firstOrFail();

        $messages = $session->messages()
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'session' => [
                'id' => $session->id,
                'session_id' => $session->session_id,
                'title' => $session->title,
            ],
            'messages' => $messages->map(function ($msg) {
                return [
                    'role' => $msg->role,
                    'content' => $msg->content,
                    'timestamp' => $msg->created_at->format('H:i'),
                ];
            }),
        ]);
    }

    /**
     * Obtener todas las sesiones del usuario
     */
    public function getSessions(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'No autenticado'], 401);
        }
        
        $sessions = ChatSession::where('user_id', $user->id_usuario)
            ->orderBy('last_activity_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'sessions' => $sessions->map(function ($session) {
                return [
                    'id' => $session->id,
                    'session_id' => $session->session_id,
                    'title' => $session->title,
                    'last_activity' => $session->last_activity_at->diffForHumans(),
                ];
            }),
        ]);
    }

    /**
     * Eliminar una sesión
     */
    public function deleteSession(Request $request, $sessionId)
    {
        $user = $this->getAuthenticatedUser($request);
        
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'No autenticado'], 401);
        }
        
        $session = ChatSession::where('session_id', $sessionId)
            ->where('user_id', $user->id_usuario)
            ->firstOrFail();

        $session->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat eliminado correctamente',
        ]);
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
            'session_id' => 'required|string|max:255',
        ]);

        $user = $this->getAuthenticatedUser($request);
        
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'No autenticado'], 401);
        }

        try {
            // Buscar o crear la sesión
            $session = ChatSession::where('session_id', $data['session_id'])
                ->where('user_id', $user->id_usuario)
                ->first();

            if (!$session) {
                $session = ChatSession::create([
                    'user_id' => $user->id,
                    'session_id' => $data['session_id'],
                    'title' => 'Nuevo Chat',
                    'last_activity_at' => now(),
                ]);
            }

            // Guardar mensaje del usuario
            ChatMessage::create([
                'session_id' => $session->id,
                'role' => 'user',
                'content' => $data['message'],
            ]);

            // Actualizar título si es el primer mensaje
            if ($session->messages()->count() === 1) {
                $session->updateTitleFromFirstMessage();
            }

            // Enviar mensaje al webhook de n8n con el formato correcto
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::timeout(30)->post($data['webhook_url'], [
                'mensaje' => $data['message'],
                'sessionId' => $data['session_id'],
                'userId' => $user->id_usuario,
            ]);

            if ($response->successful()) {
                $responseData = $response->json() ?? [];
                
                // Extraer la respuesta del bot (puede venir como 'reply', 'response', 'message', etc.)
                $botReply = $responseData['reply'] ?? 
                           $responseData['response'] ?? 
                           $responseData['message'] ?? 
                           $responseData['output'] ?? 
                           json_encode($responseData);
                
                // Guardar respuesta del bot
                ChatMessage::create([
                    'session_id' => $session->id,
                    'role' => 'assistant',
                    'content' => $botReply,
                ]);

                // Actualizar última actividad
                $session->touchActivity();
                
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
            'session_id' => 'required|string|max:255',
        ]);

        $user = $this->getAuthenticatedUser($request);
        
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'No autenticado'], 401);
        }
        
        $message = strtolower($data['message']);

        try {
            // Buscar o crear la sesión
            $session = ChatSession::where('session_id', $data['session_id'])
                ->where('user_id', $user->id_usuario)
                ->first();

            if (!$session) {
                $session = ChatSession::create([
                    'user_id' => $user->id,
                    'session_id' => $data['session_id'],
                    'title' => 'Nuevo Chat',
                    'last_activity_at' => now(),
                ]);
            }

            // Guardar mensaje del usuario
            ChatMessage::create([
                'session_id' => $session->id,
                'role' => 'user',
                'content' => $data['message'],
            ]);

            // Actualizar título si es el primer mensaje
            if ($session->messages()->count() === 1) {
                $session->updateTitleFromFirstMessage();
            }
        
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

            // Guardar respuesta del bot
            ChatMessage::create([
                'session_id' => $session->id,
                'role' => 'assistant',
                'content' => $response,
            ]);

            // Actualizar última actividad
            $session->touchActivity();

            return response()->json([
                'success' => true,
                'data' => [
                    'response' => $response,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
