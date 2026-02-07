<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'title',
        'last_activity_at',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id_usuario');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    /**
     * Crear una nueva sesión de chat
     */
    public static function createNewSession($userId)
    {
        return self::create([
            'user_id' => $userId,
            'session_id' => 'session_' . $userId . '_' . time() . '_' . Str::random(8),
            'title' => 'Nuevo Chat',
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Actualizar el título basado en el primer mensaje
     */
    public function updateTitleFromFirstMessage()
    {
        $firstMessage = $this->messages()->where('role', 'user')->first();
        if ($firstMessage && $this->title === 'Nuevo Chat') {
            $this->title = Str::limit($firstMessage->content, 50);
            $this->save();
        }
    }

    /**
     * Actualizar la última actividad
     */
    public function touchActivity()
    {
        $this->last_activity_at = now();
        $this->save();
    }
}
