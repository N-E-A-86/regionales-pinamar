<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// PÁGINA DE INICIO (PÚBLICA)

// Página de Ranking
Route::get('/ranking', [PhotoController::class, 'ranking'])->name('ranking');

    
Route::get('/', function () {
    // Buscamos SOLO las fotos aprobadas, de la más nueva a la más vieja
    // Eager loading de 'user' para no hacer muchas consultas
    $photos = App\Models\Photo::with('user')
                ->withCount('comments') // <--- Cuenta los comentarios reales
                ->where('status', 'approved')
                ->latest()
                ->get();

    return view('welcome', compact('photos'));
});
// Ver foto individual
Route::get('/photos/{id}', [PhotoController::class, 'show'])->name('photos.show');

// --- GRUPO DE RUTAS PROTEGIDAS (Solo usuarios logueados) ---
Route::middleware(['auth'])->group(function () {
    
    // 1. El Dashboard (ACTUALIZADO: Ahora busca las fotos antes de mostrar la vista)
   // Dashboard (Ahora carga fotos Y promociones)
    Route::get('/dashboard', function () {
        $photos = Illuminate\Support\Facades\Auth::user()->photos()->latest()->get();
        
        // Traemos las promos activas
        $promotions = App\Models\Promotion::where('is_active', true)->latest()->get();
        
        return view('dashboard', compact('photos', 'promotions'));
    })->name('dashboard');

    // 2. La Ruta para Subir Fotos
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');

    // Ruta para Dar/Quitar Like (AJAX)
    Route::post('/photos/{id}/like', [App\Http\Controllers\LikeController::class, 'toggle'])->name('likes.toggle');
   // LA RUTA DEL LIKE ---
    Route::post('/photos/{id}/like', [App\Http\Controllers\LikeController::class, 'toggle'])->name('likes.toggle');

    // Ruta para Agregar Comentario
    Route::post('/photos/{id}/comment', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

    // Ruta para Borrar Comentario
    Route::delete('/comments/{id}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');


    // Gestión de Promociones (Admin y Moderadores)
    Route::post('/admin/promotions', [App\Http\Controllers\PromotionController::class, 'store'])->name('promotions.store');
    Route::delete('/admin/promotions/{id}', [App\Http\Controllers\PromotionController::class, 'destroy'])->name('promotions.destroy');

    // Ruta para borrar fotos
    Route::delete('/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');
});

// --- RUTAS DE GOOGLE ---
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');



// --- ZONA DE ADMINISTRACIÓN (Solo Admin) ---
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Ver el panel
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
    // Botones de acción
    Route::put('/admin/photos/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::put('/admin/photos/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');

});
require __DIR__.'/auth.php';