<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

    public function newMatch()
    {
        $selectedField = session('selected_field');
    
        if (!$selectedField) {
            sweetalert()->info('Escolha o campo que quer para criar um evento.');
            return redirect('/field');
        }
    }

    public function newMatchField($id)
    {
        $field = Field::find($id);
        $modalities = explode(',', $field->modality); 

    
        return view('home.newmatch', compact('field', 'modalities')); 
    }
    

    public function seeMatch()
    {
        return view('home.seematch');
    }

    public function spinWheel()
    {
        return view('home.spinwheel');
    }

    public function chat()
    {
        $users = User::where('id', '!=', Auth::id())->get(); // Carrega todos os usuários, exceto o logado
        $conversations = $this->getUserConversations(); // Carrega as conversas do usuário
        
        return view('home.chat', compact('users', 'conversations')); // Passa as conversas e usuários para a view
    }

    public function sendMessage(Request $request)
    {
        $validatedData = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        try {
            // Crie a nova mensagem
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $validatedData['receiver_id'],
                'content' => $validatedData['content'],
            ]);

            // Retorne uma resposta de sucesso
            return response()->json([
                'status' => 'success',
                'message' => 'Mensagem enviada com sucesso!',
                'message_data' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao enviar a mensagem. Tente novamente.',
            ]);
        }
    }

    private function getUserConversations()
    {
        $userId = Auth::id();
        return Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
            });
    }
    

    public function getMessages($receiverId)
    {
        $userId = Auth::id();
        $messages = $this->getMessagesBetweenUsers($userId, $receiverId);

        return response()->json($messages);
    }

    private function getMessagesBetweenUsers($userId, $receiverId)
    {
        return Message::where(function ($query) use ($userId, $receiverId) {
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
    }

    public function field(Request $request)
    {
        $query = Field::query();
    
        if ($request->filled('modality')) {
            $query->where('modality', $request->modality);
        }
    
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('modality', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('user_name', 'like', "%{$search}%");
                  });
            });
        }
    
        $fields = $query->get();
    
        return view('home.field', compact('fields'));
    }
    

    public function contact()
    {
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'price' => 'required|numeric',
            'modality' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $modality = $request->input('modality');
        if (is_array($modality)) {
            $validatedData['modality'] = implode(',', $modality); 
        } else {
            $validatedData['modality'] = ''; 
        }
        $imageName = $this->storeFieldImage($request);
    
        if ($imageName) {
            $validatedData['image'] = $imageName;
        }
        $validatedData['user_id'] = Auth::id();
    
        Field::create($validatedData);
    
        toastr()->success('Pedido de adição de campo com sucesso');
        return redirect()->route('manage-fields');
    }
    
    private function storeFieldImage($request)
    {
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Fields'), $imageName);
            return $imageName; 
        }
        
        return null; 
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $modalities = $request->input('modality', []);
    
        if (in_array('outro', $modalities) && $request->filled('customModality')) {
            $modalities[] = $request->input('customModality');
        }
    
        $validatedData['modality'] = implode(',', $modalities);
    
        $field = Field::findOrFail($id);
    
        $field->name = $validated['name'];
        $field->description = $validated['description'];
        $field->location = $validated['location'];
        $field->contact = $validated['contact'];
        $field->price = $validated['price'];
        $field->modality = $validatedData['modality'];
    
        if ($request->hasFile('image')) {
            if ($field->image && file_exists(public_path('Fields/' . $field->image))) {
                unlink(public_path('Fields/' . $field->image));
            }
    
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Fields'), $imageName);
    
            $field->image = $imageName;
        }
    
        $field->save();
    
        toastr()->timeout(10000)->closeButton()->success('Campo atualizado com sucesso');
    
        return redirect()->route('manage-fields');
    }
    
    

    public function showFields($id)
    {
        $field = Field::with('user')->findOrFail($id);
        return view('home.show-fields', compact('field')); 
    }
}

