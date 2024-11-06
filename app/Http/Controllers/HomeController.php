<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;
use App\Models\Message;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function newmatch(){
        return view('home.newmatch');
    }

    public function seematch(){
        return view('home.seematch');
    }

    public function spinwheel(){
        return view('home.spinwheel');
    }

    public function chat()
    {
        // Lista todos os usuários, exceto o logado
        $users = User::where('id', '!=', Auth::id())->get(); 
        return view('home.chat', compact('users'));
    }
    

    public function sendMessage(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'receiver_id' => 'required|exists:users,id',  // Verifica se o receiver_id é válido
            'content' => 'required|string|max:255',  // Verifica se o conteúdo é uma string
        ]);
    
        // Criação da nova mensagem
        try {
            $message = Message::create([
                'sender_id' => Auth::id(),  // Usa o ID do usuário autenticado
                'receiver_id' => $request->receiver_id,  // O ID do destinatário
                'content' => $request->content,  // O conteúdo da mensagem
            ]);
    
            // Resposta de sucesso em formato JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Mensagem enviada com sucesso!',  // Mensagem de sucesso
            ]);
        } catch (\Exception $e) {
            // Em caso de erro, retorna uma resposta de erro
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível enviar a mensagem. Tente novamente.',  // Mensagem de erro
            ], 500); // Código HTTP 500 para erro interno
        }
    }

    public function getMessages($receiverId)
{
    // Obtém as mensagens entre o usuário logado e o receptor, carregando o nome do remetente
    $messages = Message::with('sender')  // Carrega o remetente da mensagem
        ->where(function($query) use ($receiverId) {
            $query->where('sender_id', auth::id())
                  ->where('receiver_id', $receiverId);
        })
        ->orWhere(function($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json($messages);
}
    
    public function field(){
        return view('home.field');
    }

    public function contact(){
        return view('home.contact');
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

public function my_fields()
{
   // $fields = Field::where('user_id', Auth::id())->get();
    return view('home.manage-fields', compact('fields'));
}
}
