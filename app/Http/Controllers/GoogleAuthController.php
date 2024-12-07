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

            $fullName = trim($google_user->getName());
            $nameParts = explode(' ', $fullName, 2);
            $name = $nameParts[0];
            $surname = $nameParts[1] ?? '';

            //faz o username unico com os nomes
            $baseUsername = strtolower(str_replace(' ', '.', $fullName)); // Nome completo como base
            $username = $baseUsername;
            $counter = 1;

            // caso que exista um username igual ele faz username.1
            while (User::where('user_name', $username)->exists()) {
                $username = $baseUsername . '.' . $counter;
                $counter++;
            }

            $user = User::where('google_id', $google_user->getId())
                ->orWhere('email', $google_user->getEmail())
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'surname' => $surname,
                    'user_name' => $username,
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId()
                ]);

                $user->forceFill(['email_verified_at' => now()])->save();

                event(new Registered($user));
            } else {
                $user->update([
                    'google_id' => $user->google_id ?: $google_user->getId(),
                    'name' => $user->name ?: $name,
                    'surname' => $user->surname ?: $surname,
                    'user_name' => $user->user_name ?: $username,
                    'email_verified_at' => $user->email_verified_at ?: now(),
                ]);
            }

            Auth::login($user);

            return redirect()->route('index');
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('error', 'Algo deu errado: ' . $th->getMessage());
        }
    }
}
