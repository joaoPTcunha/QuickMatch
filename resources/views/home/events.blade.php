@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Eventos Disponíveis</h1>

        @if($events->isEmpty())
        <p class="text-center text-gray-500 text-xl">Nenhum evento criado ainda.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">{{ $event->description }}</h2>

                <div class="space-y-3">
                    <p class="text-gray-600"><strong>Data:</strong> {{ \Carbon\Carbon::parse($event->event_date_time)->format('d/m/Y H:i') }}</p>
                    <p class="text-gray-600"><strong>Campo:</strong> {{ $event->field->name }}</p>
                    <p class="text-gray-600"><strong>Modalidade:</strong> {{ $event->modality }}</p>
                    <p class="text-gray-600"><strong>Participantes:</strong> {{ $event->num_participantes }}</p>
                    <p class="text-gray-600"><strong>Preço:</strong> {{ number_format($event->price, 2) }} €</p>
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('new.match', ['id' => $event->field->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
                        Participar
                    </a>
                    <span class="text-sm text-gray-500">Criado por: {{ $event->user->name }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    @include('home.footer')
</body>