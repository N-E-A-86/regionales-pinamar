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
Route::get('/', function () {
    // Buscamos SOLO las fotos aprobadas, de la más nueva a la más vieja
    // Eager loading de 'user' para no hacer muchas consultas
    $photos = App\Models\Photo::with('user')
                ->where('status', 'approved')
                ->latest()
                ->get();

    return view('welcome', compact('photos'));
});

// --- GRUPO DE RUTAS PROTEGIDAS (Solo usuarios logueados) ---
Route::middleware(['auth'])->group(function () {
    
    // 1. El Dashboard (ACTUALIZADO: Ahora busca las fotos antes de mostrar la vista)
    Route::get('/dashboard', function () {
        // Buscamos las fotos del usuario logueado
        $photos = Illuminate\Support\Facades\Auth::user()->photos()->latest()->get();
        
        // Enviamos la variable $photos a la vista
        return view('dashboard', compact('photos'));
    })->name('dashboard');

    // 2. La Ruta para Subir Fotos
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');

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