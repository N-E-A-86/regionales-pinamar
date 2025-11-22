<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
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

require __DIR__.'/auth.php';