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

    //MOSTRAR EVENTOS
    public function showEvents(Request $request)
    {
        $userId = Auth::id(); 
        $query = Event::with(['field', 'user']); 

        if ($request->filled('filter') && $request->filter !== 'all') {
            $query->where('modality', $request->filter); 
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('description', 'like', '%' . $search . '%'); 
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'recent') {
                $query->orderBy('event_date_time', 'desc');
            } elseif ($request->sort === 'alphabetical') {
                $query->orderBy('description', 'asc');
            } elseif ($request->sort === 'registered') {
            }
        }

        $events = $query->paginate(9);

        foreach ($events as $event) {
            $participants = json_decode($event->participants_user_id, true) ?? [];
            $event->isSubscribed = in_array($userId, array_column($participants, 'user_id'));
        }

        return view('home.events', compact('events'));
    }

    //PARTICIPAR EM EVENTOS
    public function participateInEvent($id)
    {
        $event = Event::findOrFail($id); 
        $userId = Auth::id(); 

        
        if ($event->num_subscribers >= $event->num_participants) {
            toastr()->error('O evento já está lotado!');
            return redirect()->route('events'); 
        }

       
        $participants = json_decode($event->participants_user_id, true) ?? [];
        if (in_array($userId, array_column($participants, 'user_id'))) {
            toastr()->error('Você já está inscrito neste evento!');
            return redirect()->route('events'); 
        }

        $participants[] = ['user_id' => $userId, 'user_name' => Auth::user()->user_name];
        $event->participants_user_id = json_encode($participants); 
        $event->increment('num_subscribers'); 
        $event->save(); 

        toastr()->success('Você inscreveu se com sucesso no evento!');
        return redirect()->route('events'); 
    }

    //CANCELAR INSCRIÇÃO
    public function cancelParticipation($id)
    {
        $event = Event::findOrFail($id);

        $userId = Auth::id();

        $participants = json_decode($event->participants_user_id, true) ?? [];

        $participantKey = array_search($userId, array_column($participants, 'user_id'));

        if ($participantKey !== false) {
            unset($participants[$participantKey]);

            $event->participants_user_id = json_encode(array_values($participants));

            $event->decrement('num_subscribers');

            $event->save();

            toastr()->success('Sua inscrição foi cancelada com sucesso.');
        } else {
            toastr()->error('Você não está inscrito neste evento.');
        }

        return redirect()->route('showEvents');
    }


    //CRIAR EVENTOS
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

    //CRIAR CAMPOS (IR BUSCAR OS DADOS DO CAMPO)
    public function newMatchField($id)
    {
        $field = Field::findOrFail($id);

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

    //FUNÇÃO PARA DISPONIBILIZAR OS HORÁRIOS DOS CAMPOS
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

    //PUBLICAÇÃO DO EVENTO
    public function storeEvent(Request $request)
    {
        $validatedData = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'field_name' => 'required|string',
            'schedule' => 'required|string',  
            'specific-date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'modality' => 'required|string',
            'num_participants' => 'required|integer|min:1',
            'participar' => 'boolean',
        ]);
    
        try {
            [$dayOfWeek, $time] = explode('|', $validatedData['schedule']);
    
            $eventDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $validatedData['specific-date'] . ' ' . $time
            );
    
            $dayOfWeekFromDate = strtolower($eventDateTime->format('l'));
            if ($dayOfWeekFromDate !== $dayOfWeek) {
                toastr()->error('A data selecionada não corresponde ao dia da semana escolhido.');
                return back()->withInput();
            }
    
            $existingEvent = Event::where('field_id', $validatedData['field_id'])
                ->whereDate('event_date_time', $eventDateTime->toDateString()) // Verificar pela data
                ->whereTime('event_date_time', $eventDateTime->toTimeString()) // Verificar pelo horário
                ->first();
    
            if ($existingEvent) {
                toastr()->error('Já existe um evento agendado para esse horário neste campo.');
                return back()->withInput();
            }
    
            $event = new Event();
            $event->field_id = $validatedData['field_id'];
            $event->description = $request->input('descricao', 'Evento esportivo');
            $event->event_date_time = $eventDateTime; 
            $event->price = $validatedData['price'];
            $event->modality = $validatedData['modality'];
            $event->num_participants = $validatedData['num_participants'];
            $event->num_subscribers = 0;
            $event->user_id = Auth::id();
            $event->status = 'pending';
            $event->participants_user_id = json_encode([]);
    
            $event->save();
    
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
    
    //VER EVENTOS CRIADOS
    public function seeMatch()
    {
        $userId = Auth::id(); 
        $events = Event::with(['user', 'field'])
            ->where('user_id', $userId) 
            ->get();

        return view('home.seematch', compact('events'));
    }

    public function destroyEvent($id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $event->delete();

        toastr()->timeout(10000)->closeButton()->success('Evento apagado com sucesso!');

        return redirect()->route('seematch');
    }

    //ROLETA
    public function spinWheel()
    {
        return view('home.spinwheel');
    }

    //CAMPOS
    public function field(Request $request)
{
    $query = Field::query();

    if ($request->filled('modality')) {
        $modality = $request->modality;
        $query->where('modality', 'LIKE', "%{$modality}%");
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

    $fields = $query->paginate(9); 

    $from = $request->input('from', null); 
    $redirect = $request->input('redirect', null);

    return view('home.field', compact('fields', 'from', 'redirect'));
}

    //CONTACTOS
    public function contact()
    {
        return view('home.contact');
    }

    //AJUDA
    public function help()
    {
        return view('home.help', compact('faqs'));
    }

    //CENTRAL DE AJUDA
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

    //VER CAMPOS CRIADOS (DONO DE CAMPO)
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

    //PÁGINA CRIAR CAMPOS
    public function createField()
    {
        return view('home.create-field');
    }


    //FUNÇÃO PARA CRIAR PDFS DO EVENTO CRIADO
    public function print_pdf($id)
    {
        $event = Event::findOrFail($id);
        $pdf = Pdf::loadView('home.invoice', compact('event'))->setOptions([
            'image_path' => public_path('Logo.png'), 
        ]);
        $pdf = Pdf::loadView('home.invoice', compact('event'));
        return $pdf->download('Comprovativo de inscrição.pdf');
    }

    //FUNÇÃO PARA PUBLICAR CAMPOS
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
        'days' => 'required|array', 
    ]);

    $modality = $request->input('modality');
    if (is_array($modality)) {
        $validatedData['modality'] = implode(',', $modality);
    } else {
        $validatedData['modality'] = '';
    }

    try {
        $imageName = $this->storeFieldImage($request);
        if ($imageName) {
            $validatedData['image'] = $imageName;
        }
    } catch (\Exception $e) {
        toastr()->error('Erro ao salvar a imagem: ' . $e->getMessage());
        return back();
    }

    $validatedData['user_id'] = Auth::id();

    $availability = [];

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

    try {
        Field::create($validatedData);
    } catch (\Exception $e) {
        toastr()->error('Erro ao criar o campo: ' . $e->getMessage());
        return back();
    }

    toastr()->timeout(10000)->closeButton()->success('Campo adicionado com sucesso!');

    return redirect()->route('manage-fields');
}

    //GUARDAR IMAGEM DO CAMPO NA BASE DE DADOS
    private function storeFieldImage($request)
    {
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Fields'), $imageName);
            return $imageName;
        }

        return null;
    }

    //EDITAR CAMPOS CRIADOS
    public function editField($id)
    {
        $field = Field::findOrFail($id);
        return view('home.edit-fields', compact('field'));
    }

    //EDITAR CAMPOS CRIADOS
    public function updateField(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'price' => 'required|numeric',
        'modality' => 'required|array',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'days' => 'required|array',
    ]);

    $modality = $request->input('modality');
    if (is_array($modality)) {
        $validatedData['modality'] = implode(',', $modality);
    } else {
        $validatedData['modality'] = '';
    }

    try {
        if ($request->hasFile('image')) {
            $imageName = $this->storeFieldImage($request);  
            if ($imageName) {
                $validatedData['image'] = $imageName;
            }
        }
    } catch (\Exception $e) {
        toastr()->error('Erro ao salvar a imagem: ' . $e->getMessage());
        return back();
    }

    $field = Field::findOrFail($id);

    $validatedData['user_id'] = $field->user_id;

    $availability = [];

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

    try {
        $field->update($validatedData);
    } catch (\Exception $e) {
        toastr()->error('Erro ao atualizar o campo: ' . $e->getMessage());
        return back();
    }

    toastr()->timeout(10000)->closeButton()->success('Campo atualizado com sucesso!');

    return redirect()->route('manage-fields');
}

    //APAGAR CAMPOS CRIADOS
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

   
}
