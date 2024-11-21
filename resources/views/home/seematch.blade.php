@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-3xl text-center py-6 text-gray-800 font-bold">Eventos Criados</h1>

        <div class="px-20 mb-6">
            @if($events->isEmpty())
                <p class="text-center text-gray-500">Nenhum evento criado ainda.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 px-20">
                    @foreach($events as $event)
<div class="flex flex-col bg-white p-4 rounded-md border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300 ease-in-out">
    <div class="flex flex-col flex-grow">
        <h2 class="text-2xl font-bold text-gray-800 mb-3">{{ $event->description }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-700"><strong>Data e Hora:</strong> {{ $event->event_date_time }}</p>
                <p class="text-gray-700"><strong>Modalidade:</strong> {{ $event->modality }}</p>
                <p class="text-gray-700"><strong>Número de Participantes:</strong> {{ $event->num_participantes }}</p>
                <p class="text-gray-700"><strong>Preço:</strong> {{ $event->price }} €</p>
            </div>
            <div>
                <p class="text-gray-700"><strong>Campo:</strong> {{ $event->field->name }}</p>
                <p class="text-gray-700"><strong>Criado por:</strong> {{ $event->user->name }}</p>
                <p class="text-gray-700"><strong>Contacto:</strong> {{ $event->user->email }}</p>
            </div>
                            </div>
                            <div class="mt-auto text-right">
                                <a href="{{ url('/event/'.$event->id) }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-600 transition-all duration-300">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach                
</div>

            @endif
        </div>
    </div>
    @include('home.footer')
</body>
</html>
