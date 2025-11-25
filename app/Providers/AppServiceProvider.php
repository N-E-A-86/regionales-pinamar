<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // Necesario para evitar errores de DB en Hostinger
use Carbon\Carbon; // Necesario para manipular fechas y el idioma

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 1. Previene errores de longitud de índice en MySQL (Recomendado para Hostinger)
        Schema::defaultStringLength(191);

        // 2. Configura las fechas de Carbon en Español
        Carbon::setLocale('es');
    }
}