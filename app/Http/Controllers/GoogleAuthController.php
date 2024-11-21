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

            $user = User::where('google_id', $google_user->getId())
                        ->orWhere('email', $google_user->getEmail())
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId()
                ]);

                $user->forceFill(['email_verified_at' => now()])->save();

                event(new Registered($user));
            } else {
                if (!$user->google_id) {
                    $user->update(['google_id' => $google_user->getId()]);
                }

                if (is_null($user->email_verified_at)) {
                    $user->forceFill(['email_verified_at' => now()])->save();
                }
            }

            Auth::login($user);

            return redirect()->route('index');

        } catch (\Throwable $th) {
            return redirect()->route('login')->with('error', 'Algo deu errado: ' . $th->getMessage());
        }
    }
}
