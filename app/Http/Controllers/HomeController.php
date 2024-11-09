<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Models\User;
use App\Models\Problem;
use App\Models\Message;
use App\Models\Field;


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
        $users = User::where('id', '!=', Auth::id())->get(); 
        return view('home.chat', compact('users'));
    }
    

    public function conversations(){
    
        $userId = Auth::id();

        // Busca todos os usuários com os quais o usuário logado teve uma conversa.
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->latest('created_at')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                // Agrupando por usuário (outro participante da conversa)
                return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            })
            ->map(function ($messages) {
                // Retorna apenas a última mensagem de cada conversa
                return $messages->first();
            });

        return view('chat.conversations', compact('conversations'));
    
}

    public function getMessages($receiverId)
    {
        $userId = Auth::id();

        $messages = Message::where(function ($query) use ($userId, $receiverId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($query) use ($userId, $receiverId) {
                $query->where('sender_id', $receiverId)
                      ->where('receiver_id', $userId);
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $message,
        ]);
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
        toastr()->timeout(10000)->closeButton()->success('Reclamação enviada com sucesso');

        return redirect()->route('help');
    }

    public function manageFields()
    {
        $user = Auth::user();  
        $fields = Field::where('user_id', $user->id)->get();  

        return view('home.manage-fields', compact('fields'));  
    }

    public function createField()
    {
        return view('home.create-field');  
    }

    public function storeFields(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'price' => 'required|numeric',
            'modality' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Fields'), $imageName);
            $validated['image'] = $imageName;
        }
        $validated['user_id'] = Auth::id();

        Field::create($validated);

        toastr()->timeout(10000)->closeButton()->success('Pedido de adição de campo com sucessso');

        return redirect()->route('manage-fields');
    }
    public function editFields($id)
    {
        $field = Field::findOrFail($id);
        return view('home.edit-fields', compact('field'));
    }
    

    public function updateFields(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', 
        ]);
    
        $field = Field::findOrFail($id);
    
        $field->name = $validated['name'];
        $field->description = $validated['description'];
        $field->location = $validated['location'];
        $field->contact = $validated['contact'];
        $field->price = $validated['price'];
    
        if ($request->hasFile('image')) {
            if ($field->image && file_exists(public_path('Campos/' . $field->image))) {
                unlink(public_path('Fields/' . $field->image)); // Excluindo a imagem antiga
            }
    
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Fields'), $imageName); 
    
            $field->image = $imageName;
        }
    
        $field->save();
    
        toastr()->timeout(10000)->closeButton()->success('Campo atualizado com sucesso');
    
        return redirect()->route('manage-fields');
    }
    
    
}

