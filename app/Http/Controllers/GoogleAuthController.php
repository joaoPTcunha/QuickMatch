<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered; // Adicione isso para disparar o evento de registro

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

            $user = User::where('google_id', $google_user->getId())
                        ->orWhere('email', $google_user->getEmail())
                        ->first();

            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'email_verified_at' => now(), 
                ]);

                event(new Registered($new_user));

                Auth::login($new_user);
            } else {
                if (!$user->google_id) {
                    $user->update(['google_id' => $google_user->getId()]);
                }

                if (!$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                Auth::login($user);
            }

            return redirect()->route('see.match');

        } catch (\Throwable $th) {
            dd('Algo Errado! ' . $th->getMessage());
        }
    }
}
