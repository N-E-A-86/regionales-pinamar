<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client; // <--- IMPORTANTE: Añadir esto

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirect(config('services.google.redirect'));
    }

    public function callback()
    {
        // OJO AQUÍ: Configuramos Guzzle para ignorar el certificado SSL localmente
        $googleUser = Socialite::driver('google')
            ->setHttpClient(new Client(['verify' => false])) 
            ->stateless()
            ->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            Auth::login($user, true);
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(uniqid())
            ]);

            Auth::login($user, true);
        }

        return redirect('/dashboard');
    }
}