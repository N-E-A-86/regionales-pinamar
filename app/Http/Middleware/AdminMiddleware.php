<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificamos si el usuario está logueado Y si es admin
        if (auth()->check() && auth()->user()->role == 'admin') {
            return $next($request); // ¡Pase adelante, jefe!
        }

        // Si no es admin, lo mandamos al inicio con un error 403 (Prohibido)
        abort(403, 'No tienes permiso para acceder a esta zona.');
    }
}
