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
        // Buscamos la foto por ID, y traemos también los datos del usuario dueño
        $photo = Photo::with('user')->findOrFail($id);

        // Si la foto no está aprobada y el que mira NO es el dueño ni admin, error 404
        if ($photo->status != 'approved') {
             if (auth()->id() != $photo->user_id && (!auth()->user() || auth()->user()->role != 'admin')) {
                 abort(404);
             }
        }

        return view('photos.show', compact('photo'));
    }
}