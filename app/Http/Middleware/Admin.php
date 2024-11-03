<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado e se é admin ou owner
        if (Auth::check() && (Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'owner')) {
            return $next($request);
        }
    
        // Redireciona para o login caso o usuário não seja admin ou owner
        return redirect()->route('login');
    }
}    
