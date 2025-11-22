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
}