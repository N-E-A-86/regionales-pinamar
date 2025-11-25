<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // --- LA SOLUCIÓN AL ERROR ESTÁ AQUÍ ---
    // Le decimos a Laravel: "Es seguro rellenar estos dos campos"
    protected $fillable = ['user_id', 'photo_id'];

    // Relación opcional (pero útil): Un like pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}