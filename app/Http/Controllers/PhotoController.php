<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    // Función para guardar la foto
    public function store(Request $request)
    {
        // 1. Validar que lo que suben es una imagen real
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // Máx 10MB
        ]);

        // 2. Guardar el archivo en el disco (carpeta 'public/photos')
        // Esto devuelve la ruta, ej: "photos/nombre_archivo.jpg"
        $path = $request->file('photo')->store('photos', 'public');

        // 3. Crear el registro en la base de datos
        Photo::create([
            'user_id' => Auth::id(),     // El usuario logueado
            'file_path' => $path,        // La ruta donde guardamos la imagen
            'status' => 'pending',       // Por defecto, pendiente de moderación
            'likes_count' => 0,
            'comments_count' => 0,
        ]);

        // 4. Redirigir al usuario con un mensaje de éxito
        return redirect()->route('dashboard')->with('status', '¡Tu foto ha sido subida! Espera a que sea aprobada.');
}
// Mostrar una foto individual en grande
    public function show($id)
    {
        // Buscamos la foto, su dueño, sus comentarios y los dueños de los comentarios
$photo = Photo::with(['user', 'comments.user'])->findOrFail($id);

        // Si la foto no está aprobada y el que mira NO es el dueño ni admin, error 404
        if ($photo->status != 'approved') {
             if (auth()->id() != $photo->user_id && (!auth()->user() || auth()->user()->role != 'admin')) {
                 abort(404);
             }
        }

        return view('photos.show', compact('photo'));
    }



    // Página de Ranking / Los Más Populares
    public function ranking()
    {
        // Traemos las 10 fotos con más likes
        $topPhotos = Photo::with('user')
                          ->where('status', 'approved')
                          ->orderBy('likes_count', 'desc') // Ordenar de mayor a menor
                          ->take(05) // Solo las 10 mejores
                          ->get();

        return view('ranking', compact('topPhotos'));
    }
    // Borrar foto (Acción para el Admin o el Dueño)
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // Seguridad: Solo Admin o el dueño pueden borrar
        if (auth()->check() && (auth()->user()->role == 'admin' || auth()->id() == $photo->user_id)) {
            
            // 1. (Opcional) Borrar archivo del disco para no ocupar espacio
            // \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->file_path);

            // 2. Borrar de la base de datos
            $photo->delete();

            return back()->with('status', 'Foto eliminada correctamente.');
        }

        abort(403, 'No tienes permiso.');
    }
}