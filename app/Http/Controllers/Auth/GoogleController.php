<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
   public function redirect()
{
    return Socialite::driver('google')
        ->redirect(config('services.google.redirect'));
}
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Busca si ya existe un usuario con ese email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Si existe, lo logueamos
                Auth::login($user);
            } else {
                // Si no existe, lo creamos y lo logueamos
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    // Creamos una contraseña aleatoria ya que no la necesitará
                    'password' => Hash::make(uniqid())
                ]);

                Auth::login($newUser);
            }

            return redirect('/dashboard');

        } catch (\Throwable $th) {
            // En caso de error, redirigimos a la página de login con un mensaje
            // (En un futuro se puede mejorar el manejo de errores)
            return redirect('/login')->with('error', 'Algo salió mal con la autenticación de Google.');
        }
    }
}