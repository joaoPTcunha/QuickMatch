<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;
use App\Models\Field;
use App\Models\Event;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


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
        $event->increment('num_subscribers'); // Incrementa o número de inscritos
        $event->save(); // Salva as alterações no banco de dados

        toastr()->success('Você inscreveu se com sucesso no evento!');
        return redirect()->route('events'); // Redireciona de volta para a página de eventos
    }

    public function cancelParticipation($id)
    {
        $event = Event::findOrFail($id);

        // Get the user ID of the currently authenticated user
        $userId = Auth::id();

        // Decode the JSON to get the list of participants
        $participants = json_decode($event->participants_user_id, true) ?? [];

        // Check if the user is in the participants list
        $participantKey = array_search($userId, array_column($participants, 'user_id'));

        if ($participantKey !== false) {
            // If the user is a participant, remove them from the list
            unset($participants[$participantKey]);

            // Update the participants list in the event
            $event->participants_user_id = json_encode(array_values($participants));

            // Decrement the number of subscribers
            $event->decrement('num_subscribers');

            // Save the changes to the event
            $event->save();

            toastr()->success('Sua inscrição foi cancelada com sucesso.');
        } else {
            toastr()->error('Você não está inscrito neste evento.');
        }

        // Redirect to the events page
        return redirect()->route('showEvents');
    }



    public function newMatch(Request $request)
    {
        $field = null;
        $modalities = [];
        $availability = [];

        if ($request->filled('field_id')) {
            $field = Field::findOrFail($request->field_id);
            $modalities = !empty($field->modality) ? explode(',', $field->modality) : [];

            if ($field->availability) {
                $availabilityData = is_array($field->availability)
                    ? $field->availability
                    : json_decode($field->availability, true);

                if (is_array($availabilityData)) {
                    foreach ($availabilityData as $day => $time) {
                        if (isset($time['start']) && isset($time['end'])) {
                            $availability[strtolower($day)] = $this->generateTimeSlots($time['start'], $time['end']);
                        }
                    }
                }
            }
        }

        return view('home.newmatch', compact('field', 'modalities', 'availability'));
    }


    public function newMatchField($id)
    {
        $field = Field::findOrFail($id);

        // Certifique-se de que o nome do campo é uma string
        $field->name = is_array($field->name) ? implode(', ', $field->name) : $field->name;

        $modalities = explode(',', $field->modality);
        $availability = [];

        if ($field->availability) {
            $availabilityData = json_decode($field->availability, true);

            foreach ($availabilityData as $day => $time) {
                if (isset($time['start']) && isset($time['end'])) {
                    $availability[] = ucfirst($day) . ' ' . implode(' - ', $this->generateTimeSlots($time['start'], $time['end']));
                }
            }
        }

        return view('home.newmatch', compact('field', 'modalities', 'availability'));
    }


    private function generateTimeSlots($startTime, $endTime)
    {
        $slots = [];
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        if ($start < $end) {
            while ($start < $end) {
                $slots[] = $start->format('H:i');
                $start->addHour();
            }
        }

        return $slots;
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

    // Filtro de modalidade: Permite filtrar campos que contenham a modalidade desejada em qualquer parte da string de modalidades
    if ($request->filled('modality')) {
        $modality = $request->modality;
        // Verifica se a modalidade está em qualquer parte do campo 'modality', considerando que este pode ter mais de uma modalidade separada por vírgulas
        $query->where('modality', 'LIKE', "%{$modality}%");
    }

    // Filtro de busca: Pesquisa em nome, localização, modalidade e usuário
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

    // Ordenação (opcional)
    if ($request->filled('sort')) {
        $sort = $request->sort;
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
        }
    }

    // Paginação
    $fields = $query->paginate(10); // Paginação com 10 resultados por página

    // Outros parâmetros que você possa estar usando para redirecionamento ou controle de origem
    $from = $request->input('from', null); 
    $redirect = $request->input('redirect', null);

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

        if ($user->usertype !== 'user_field') {
            toastr()->timeout(10000)->closeButton()->warning('Precisa de ser um dono de campo para registar o seu Campo. Atualize o seu perfil.');
            return redirect()->route('profile.edit');
        }

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
            'field_name' => 'required|string',
            'schedule' => 'required|string',  // Formato: 'day|start|end'
            'specific-date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'modality' => 'required|string',
            'num_participants' => 'required|integer|min:1',
            'participar' => 'boolean',
        ]);
    
        try {
            // Extrair dia da semana e horário do campo "schedule"
            [$dayOfWeek, $time] = explode('|', $validatedData['schedule']);
    
            // Criar timestamp usando a data e o horário
            $eventDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $validatedData['specific-date'] . ' ' . $time
            );
    
            // Verificar se o dia da semana da data corresponde ao selecionado
            $dayOfWeekFromDate = strtolower($eventDateTime->format('l'));
            if ($dayOfWeekFromDate !== $dayOfWeek) {
                toastr()->error('A data selecionada não corresponde ao dia da semana escolhido.');
                return back()->withInput();
            }
    
            // Verificar se já existe um evento no mesmo campo, na mesma data e horário
            $existingEvent = Event::where('field_id', $validatedData['field_id'])
                ->whereDate('event_date_time', $eventDateTime->toDateString()) // Verificar pela data
                ->whereTime('event_date_time', $eventDateTime->toTimeString()) // Verificar pelo horário
                ->first();
    
            if ($existingEvent) {
                toastr()->error('Já existe um evento agendado para esse horário neste campo.');
                return back()->withInput();
            }
    
            // Criar o evento
            $event = new Event();
            $event->field_id = $validatedData['field_id'];
            // Se não tiver descrição, usar um valor padrão
            $event->description = $request->input('descricao', 'Evento esportivo');
            $event->event_date_time = $eventDateTime; // Usar o Carbon timestamp criado
            $event->price = $validatedData['price'];
            $event->modality = $validatedData['modality'];
            $event->num_participants = $validatedData['num_participants'];
            $event->num_subscribers = 0;
            $event->user_id = Auth::id();
            $event->status = 'pending';
            $event->participants_user_id = json_encode([]);
    
            $event->save();
    
            // Inscrição automática do criador, se marcado
            if ($request->has('participar') && $request->participar) {
                $event->num_subscribers = 1;
    
                $participants = [
                    [
                        'user_id' => Auth::id(),
                        'user_name' => Auth::user()->name
                    ]
                ];
    
                $event->participants_user_id = json_encode($participants);
                $event->save();
            }
    
            toastr()->success('Evento publicado com sucesso!');
            return redirect()->route('seematch');
        } catch (\Exception $e) {
            toastr()->error('Ocorreu um erro ao criar o evento: ' . $e->getMessage());
            return back()->withInput();
        }
    }
    

    public function print_pdf($id)
    {
        $event = Event::findOrFail($id);

        $pdf = Pdf::loadView('home.invoice', compact('event'));
        return $pdf->download('invoice.pdf');
    }


    public function storeFields(Request $request)
{
    // Validação dos dados recebidos
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'price' => 'required|numeric',
        'modality' => 'required|array',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'days' => 'required|array', // Garantir que os dias sejam enviados
    ]);

    // Tratamento da modalidade
    $modality = $request->input('modality');
    if (is_array($modality)) {
        $validatedData['modality'] = implode(',', $modality);
    } else {
        $validatedData['modality'] = '';
    }

    // Armazenamento da imagem
    try {
        $imageName = $this->storeFieldImage($request);
        if ($imageName) {
            $validatedData['image'] = $imageName;
        }
    } catch (\Exception $e) {
        toastr()->error('Erro ao salvar a imagem: ' . $e->getMessage());
        return back();
    }

    // Adicionando o ID do usuário
    $validatedData['user_id'] = Auth::id();

    // Adicionando o horário por dia da semana
    $availability = [];

    // Itera sobre os dias e coleta todos os horários
    foreach ($request->input('days', []) as $day) {
        $startTimes = $request->input("{$day}_start");
        $endTimes = $request->input("{$day}_end");

        if ($startTimes && $endTimes) {
            $dayAvailability = [];
            foreach ($startTimes as $index => $start) {
                $dayAvailability[] = [
                    'start' => $start,
                    'end' => $endTimes[$index],
                ];
            }
            $availability[$day] = $dayAvailability;
        }
    }

    $validatedData['availability'] = json_encode($availability);

    // Criando o novo campo no banco de dados
    try {
        Field::create($validatedData);
    } catch (\Exception $e) {
        toastr()->error('Erro ao criar o campo: ' . $e->getMessage());
        return back();
    }

    // Exibindo a mensagem de sucesso
    toastr()->timeout(10000)->closeButton()->success('Campo adicionado com sucesso!');

    // Redirecionando para a página de gerenciamento de campos
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

    public function editField($id)
    {
        $field = Field::findOrFail($id);
        return view('home.edit-fields', compact('field'));
    }


    public function updateField(Request $request, $id)
{
    // Validação dos dados recebidos
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'price' => 'required|numeric',
        'modality' => 'required|array',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'days' => 'required|array', // Garantir que os dias sejam enviados
    ]);

    // Tratamento da modalidade
    $modality = $request->input('modality');
    if (is_array($modality)) {
        $validatedData['modality'] = implode(',', $modality);
    } else {
        $validatedData['modality'] = '';
    }

    // Armazenamento da imagem (caso haja uma nova)
    try {
        if ($request->hasFile('image')) {
            $imageName = $this->storeFieldImage($request);  // Supondo que esse método seja o mesmo
            if ($imageName) {
                $validatedData['image'] = $imageName;
            }
        }
    } catch (\Exception $e) {
        toastr()->error('Erro ao salvar a imagem: ' . $e->getMessage());
        return back();
    }

    // Obtém o campo que será atualizado
    $field = Field::findOrFail($id);

    // Adicionando o ID do usuário (não precisa ser modificado, pois ele já pertence ao campo)
    $validatedData['user_id'] = $field->user_id;

    // Atualizando o horário por dia da semana
    $availability = [];

    // Itera sobre os dias e coleta todos os horários
    foreach ($request->input('days', []) as $day) {
        $startTimes = $request->input("{$day}_start");
        $endTimes = $request->input("{$day}_end");

        if ($startTimes && $endTimes) {
            $dayAvailability = [];
            foreach ($startTimes as $index => $start) {
                $dayAvailability[] = [
                    'start' => $start,
                    'end' => $endTimes[$index],
                ];
            }
            $availability[$day] = $dayAvailability;
        }
    }

    // Armazenando os horários atualizados
    $validatedData['availability'] = json_encode($availability);

    // Atualizando o campo no banco de dados
    try {
        $field->update($validatedData);
    } catch (\Exception $e) {
        toastr()->error('Erro ao atualizar o campo: ' . $e->getMessage());
        return back();
    }

    // Exibindo a mensagem de sucesso
    toastr()->timeout(10000)->closeButton()->success('Campo atualizado com sucesso!');

    // Redirecionando para a página de gerenciamento de campos
    return redirect()->route('manage-fields');
}

    public function destroyField($id)
    {
        $field = Field::find($id);

        if (!$field) {
            return redirect()->back()->with('error', 'Campo não encontrado.');
        }

        if ($field->image && file_exists(public_path('Fields/' . $field->image))) {
            unlink(public_path('Fields/' . $field->image));
        }

        $field->delete();

        toastr()->timeout(10000)->closeButton()->success('Campo apagado com sucesso!');
        return redirect()->route('manage-fields');
    }

    public function showEvents(Request $request)
    {
        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $query = Event::with(['field', 'user']); // Carrega os eventos com relação aos campos e usuários

        // Filtro de modalidade
        if ($request->filled('filter') && $request->filter !== 'all') {
            $query->where('modality', $request->filter); // Filtra pela modalidade selecionada
        }

        // Filtro de pesquisa (por nome do evento)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('description', 'like', '%' . $search . '%'); // Filtra pelo nome do evento
        }

        // Filtro de ordenação
        if ($request->filled('sort')) {
            if ($request->sort === 'recent') {
                // Ordena por data mais recente
                $query->orderBy('event_date_time', 'desc');
            } elseif ($request->sort === 'alphabetical') {
                // Ordena por descrição (ordem alfabética)
                $query->orderBy('description', 'asc');
            } elseif ($request->sort === 'registered') {
                // Ordena por eventos nos quais o usuário está inscrito
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
