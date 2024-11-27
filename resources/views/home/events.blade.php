@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-3xl text-center py-6 text-gray-800 font-bold">Eventos Disponíveis</h1>
        <div class="px-10 sm:px-20 mb-6">
            <!-- Filtros ou pesquisa podem ser adicionados aqui, se necessário -->
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 px-10 sm:px-20">
            @foreach($events as $event)
            <div class="flex flex-col bg-white p-4 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('Fields/' . $event->field->image) }}" alt="{{ $event->field->name }}" class="w-full h-36 object-cover rounded-md shadow-md">
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-2 text-center">{{ $event->description }}</h2>
                <div class="text-gray-700 text-sm space-y-1">
                    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($event->event_date_time)->format('d/m/Y H:i') }}</p>
                    <p><strong>Campo:</strong> {{ $event->field->name }}</p>
                    <p><strong>Modalidade:</strong> {{ $event->modality }}</p>
                    <p><strong>Participantes:</strong> {{ $event->num_participantes }}</p>
                    <p><strong>Preço:</strong> {{ number_format($event->price, 2) }} €</p>
                    <p><strong>Nome do Dono:</strong> {{ $event->user->name }}</p>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('new.match', ['id' => $event->field->id]) }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-600 transition-all duration-300">
                        Participar
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6 px-10 sm:px-20">
            {{ $events->links() }}
        </div>
    </div>
    @include('home.footer')
</body>
</html>
