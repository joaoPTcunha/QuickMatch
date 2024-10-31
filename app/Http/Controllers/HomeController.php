<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user) {
            $usertype = $user->usertype;
            $name = $user->name;
            return view('admin.index', compact('usertype', 'name'));
        }
    
        return redirect()->route('login');
    }

    public function aaa(){
        return view('home.seematch');
    }

    public function spinwheel(){
        return view('home.spinwheel');
    }

    public function field(){
        return view('home.field');
    }

    public function contact(){
        return view('home.contact');
    }

    public function newmatch(){
        return view('home.newmatch');
    }

    public function seematch(){
        return view('home.seematch');
    }

    public function help()
    {
        $faqs = [
            ['question' => 'Como posso redefinir minha senha?', 'answer' => 'Você pode redefinir sua senha clicando em "Esqueci a senha" na tela de login. Siga as instruções enviadas para o seu e-mail.'],
            ['question' => 'Como posso entrar em contato com o suporte?', 'answer' => 'Você pode entrar em contato com o suporte através do e-mail suporte@exemplo.com ou pelo telefone (11) 1234-5678.'],
            ['question' => 'Quais métodos de pagamento são aceitos?', 'answer' => 'Aceitamos cartões de crédito, débito e PayPal. Confira nossa página de pagamento para mais informações.'],
        ];

        return view('home.help', compact('faqs'));
    }

    public function sendProblem(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        Problem::create([
            'subject' => $validatedData['subject'], 
            'email' => Auth::user()->email,          
            'description' => $validatedData['description'],
        ]);
        toastr()->success('Reclamação enviada com sucesso');

        return redirect()->route('help');
    }
}
