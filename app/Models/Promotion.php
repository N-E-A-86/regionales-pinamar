<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    // Habilitamos estos campos para poder guardar datos
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'is_active'
    ];
}