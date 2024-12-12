<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;
use App\Models\Field;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function participateInEvent($id)
    {
        $event = Event::findOrFail($id); // Obtém o evento com o ID fornecido
        $userId = Auth::id(); // Obtém o ID do usuário autenticado

        // Verificar se o evento já está cheio
        if ($event->num_subscribers >= $event->num_participants) {
            toastr()->error('O evento já está lotado!');
            return redirect()->route('events'); // Redireciona de volta para a página de eventos
        }

        // Verifica se o usuário já está inscrito no evento
        $participants = json_decode($event->participants_user_id, true) ?? [];
        if (in_array($userId, array_column($participants, 'user_id'))) {
            toastr()->error('Você já está inscrito neste evento!');
            return redirect()->route('events'); // Redireciona de volta para a página de eventos
        }

        // Adiciona o usuário à lista de participantes
        $participants[] = ['user_id' => $userId, 'user_name' => Auth::user()->user_name];
        $event->participants_user_id = json_encode($participants); // Atualiza o campo de participantes
        $event->increment('num_inscritos'); // Incrementa o número de inscritos
        $event->save(); // Salva as alterações no banco de dados

        toastr()->success('Você inscreveu se com sucesso no evento!');
        return redirect()->route('events'); // Redireciona de volta para a página de eventos
    }

    public function newMatch(Request $request)
    {
        $field = null;
        $modalities = [];

        if ($request->filled('field_id')) {
            $field = Field::findOrFail($request->field_id);
            $modalities = explode(',', $field->modality); // Converte modalidades para array
        }

        return view('home.newmatch', compact('field', 'modalities'));
    }

    public function newMatchField($id)
    {
        $field = Field::findOrFail($id);
        $modalities = explode(',', $field->modality); // Converte modalidades para array

        return view('home.newmatch', compact('field', 'modalities'));
    }

    public function seeMatch()
    {
        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $events = Event::with(['user', 'field'])
            ->where('user_id', $userId) // Filtra apenas eventos do usuário logado
            ->get();

        return view('home.seematch', compact('events'));
    }

    public function spinWheel()
    {
        return view('home.spinwheel');
    }

    public function field(Request $request)
    {
        $query = Field::query();

        if ($request->filled('modality')) {
            $query->where('modality', $request->modality);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('modality', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $fields = $query->paginate(10); // Paginação

        $from = $request->input('from', null); // Pega o parâmetro 'from' da URL
        $redirect = $request->input('redirect', null); // Pega o parâmetro 'redirect'

        return view('home.field', compact('fields', 'from', 'redirect'));
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
        toastr()->timeout(10000)->closeButton()->success('Reclamação enviada com sucesso');

        return redirect()->route('help');
    }

    public function manageFields()
    {
        $user = Auth::user();

        #if ($user->type !== 'user_field') {
            #toastr()->timeout(10000)->closeButton()->warning('Precisa de ser um dono de campo para registar o seu Campo. Atualize o seu perfil.');
            #return redirect()->route('profile.edit');
        #}

        $fields = Field::where('user_id', $user->id)->get();

        return view('home.manage-fields', compact('fields'));
    }

    public function createField()
    {
        return view('home.create-field');
    }

    public function storeEvent(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'descricao' => 'required|string',
            'date-time' => 'required|date',
            'price' => 'required|numeric|min:0',
            'modality' => 'required|string',
            'num_participants' => 'required|integer|min:1',
            'participar' => 'required|boolean',
        ]);

        // Criação do evento
        $event = new Event();
        $event->field_id = $validatedData['field_id'];
        $event->description = $validatedData['descricao'];
        $event->event_date_time = $validatedData['date-time'];
        $event->price = $validatedData['price'];
        $event->modality = $validatedData['modality'];
        $event->num_participants = $validatedData['num_participantes'];
        $event->num_subscribers = 0; // Nenhum inscrito inicialmente
        $event->user_id = Auth::id(); // Usuário criador do evento
        $event->status = 'pending'; // Status padrão
        $event->participants_user_id = json_encode([]); // Lista de participantes vazia
        $event->save();

        // Inscrição automática do criador, se desejado
        if ($validatedData['participar']) {
            // Incrementar o número de inscritos
            $event->increment('num_subscribers');
            // Adicionar o criador à lista de participantes
            $participants = json_decode($event->participants_user_id, true) ?? [];
            $participants[] = [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->user_name,
            ];
            $event->participants_user_id = json_encode($participants);

            // Salvar as alterações no evento
            $event->save();
        }

        toastr()->success('Evento publicado com sucesso!');
        return redirect()->route('seematch');
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

        toastr()->timeout(10000)->closeButton()->success('Pedido de adição de campo com sucesso');
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

    public function showEvents(Request $request)
    {
        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $query = Event::with(['field', 'user']); // Carrega os eventos com relação aos campos e usuários

        // Filtro de ordenação
        if ($request->filled('sort')) {
            if ($request->sort === 'recent') {
                // Ordena por data mais recente
                $query->orderBy('event_date_time', 'desc');
            } elseif ($request->sort === 'alphabetical') {
                // Ordena por descrição (ordem alfabética)
                $query->orderBy('description', 'asc');
            }
        }

        // Paginação dos eventos
        $events = $query->paginate(9); // Paginação com 9 eventos por página

        // Adiciona a propriedade isSubscribed para cada evento (para ser usado no front-end)
        foreach ($events as $event) {
            // Converte o campo 'participants_user_id' (JSON) em array e verifica se o usuário está inscrito
            $participants = json_decode($event->participants_user_id, true) ?? [];
            $event->isSubscribed = in_array($userId, array_column($participants, 'user_id'));
        }

        // Retorna a view com os eventos filtrados
        return view('home.events', compact('events'));
    }
}
