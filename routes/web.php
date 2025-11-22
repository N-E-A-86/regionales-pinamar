<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController; // Ya tenías esto, ¡bien!
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
    
    // 1. El Dashboard (Tu página principal privada)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. La Ruta para Subir Fotos (LA NUEVA)
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');

});

// --- RUTAS DE GOOGLE ---
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

require __DIR__.'/auth.php';