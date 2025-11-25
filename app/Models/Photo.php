<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    // ESTA ES LA SOLUCIÓN AL ERROR
    // Aquí definimos qué campos se pueden rellenar automáticamente
    protected $fillable = [
        'user_id',
        'file_path',
        'status',
        'likes_count',
        'comments_count',
        'reward_claimed',
    ];

    // Relación: Una foto pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una foto tiene muchos likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Función auxiliar para saber si el usuario actual le dio like
    public function isLikedByAuthUser()
    {
        if (!auth()->check()) return false;
        
        // Busca si existe un like del usuario conectado en esta foto
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
}