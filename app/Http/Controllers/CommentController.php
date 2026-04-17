<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $photoId)
    {
        // 1. Validar que no envíen comentarios vacíos
        $request->validate([
            'body' => 'required|max:255', // Máximo 255 caracteres
        ]);

        $photo = Photo::findOrFail($photoId);

        // 2. Crear el comentario
        Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
            'body' => $request->body
        ]);

        // 3. Actualizar contador de comentarios en la foto (para que sea rápido mostrarlo)
        $photo->increment('comments_count');

        // 4. Volver a la misma página
        return back()->with('status', '¡Comentario publicado!');
    }
            
              
   public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Seguridad: Solo permitimos borrar si es Admin o si es el dueño del comentario
        if (auth()->user()->role == 'admin' || auth()->id() == $comment->user_id) {
            
            // 1. Guardamos la referencia a la foto ANTES de borrar
            $photo = $comment->photo;

            // 2. Borramos el comentario
            $comment->delete();

            // 3. Actualizamos el contador (si la foto existe)
            if ($photo) {
                $photo->decrement('comments_count');
            }
            
            return back()->with('status', 'Comentario eliminado.');
        }

        abort(403, 'No tienes permiso.');
    }
}