<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
   public function toggle($photoId)
    {
        $user = Auth::user();
        $photo = Photo::findOrFail($photoId);

        // Verificamos si existe
        $exists = Like::where('user_id', $user->id)
                      ->where('photo_id', $photo->id)
                      ->exists();

        if ($exists) {
            // SI YA EXISTE: Lo borramos usando una "Eliminación Directa"
            // Esto soluciona el error porque no depende de una columna 'id'
            Like::where('user_id', $user->id)
                ->where('photo_id', $photo->id)
                ->delete();

            $photo->decrement('likes_count');
            $liked = false;
        } else {
            // SI NO EXISTE: Lo creamos
            Like::create([
                'user_id' => $user->id,
                'photo_id' => $photo->id
            ]);
            $photo->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $photo->likes_count
        ]);
    }
}