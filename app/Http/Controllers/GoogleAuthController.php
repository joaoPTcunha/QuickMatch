<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }
    
    public function callbackGoogle(){
        try{
            $google_user = Socialite::driver('google')->user();
    
            $user = User::where('google_id', $google_user->getId())->orWhere('email', $google_user->getEmail())->first();
    
            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                ]);
    
                Auth::login($new_user);
            } else {
                if (!$user->google_id) {
                    $user->update(['google_id' => $google_user->getId()]);
                }
                Auth::login($user);
            }
    
            return redirect()->route('see.match');
    
        } catch (\Throwable $th) {
            dd('Algo Errado! ' . $th->getMessage());
        }
    }
}
