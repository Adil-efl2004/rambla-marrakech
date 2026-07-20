<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirige l'utilisateur vers la page d'authentification Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Gère le callback de Google après authentification.
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cherche un utilisateur existant par email ou en crée un nouveau
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'              => $googleUser->getName(),
                'password'          => bcrypt(Str::random(32)),
                'role'              => 'client',
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, remember: true);

        // Redirection selon le rôle
        return match ($user->role) {
            'client'                  => redirect()->route('client.dashboard'),
            'serveur'                 => redirect()->route('staff.orders.index'),
            'technicien', 'admin'     => redirect()->route('admin.dashboard'),
            default                   => redirect('/'),
        };
    }
}
