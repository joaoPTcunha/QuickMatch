<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            // Verifica se o usuário já existe pelo Google ID ou e-mail
            $user = User::where('google_id', $google_user->getId())
                        ->orWhere('email', $google_user->getEmail())
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId()
                ]);

                // Marca o e-mail como verificado
                $user->forceFill(['email_verified_at' => now()])->save();

                // Dispara o evento de registro
                event(new Registered($user));
            } else {
                // Se o usuário já existe, associa o Google ID se ainda não estiver associado
                if (!$user->google_id) {
                    $user->update(['google_id' => $google_user->getId()]);
                }

                // Marca o e-mail como verificado se ainda não estiver
                if (is_null($user->email_verified_at)) {
                    $user->forceFill(['email_verified_at' => now()])->save();
                }
            }

            // Autentica o usuário
            Auth::login($user);

            // Redireciona para a rota desejada após o login com o Google
            return redirect()->route('see.match');

        } catch (\Throwable $th) {
            return redirect()->route('login')->with('error', 'Algo deu errado: ' . $th->getMessage());
        }
    }
}
