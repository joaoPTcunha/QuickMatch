@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-3xl text-center py-6 text-gray-800 font-bold">Eventos Criados</h1>
        <div class="px-10 sm:px-20 mb-6">
            @if($events->isEmpty())
                <p class="text-center text-gray-500">Nenhum evento criado ainda.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 sm:p-6 lg:p-8">
                    @foreach($events as $event)
                        <div class="flex flex-col bg-white p-4 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300">
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('Fields/' . $event->field->image) }}" alt="{{ $event->field->name }}" class="w-full h-36 object-cover rounded-md shadow-md">
                            </div>
                            <h2 class="text-lg font-bold text-gray-800 mb-2 text-center">{{ $event->description }}</h2>
                            <div class="text-gray-700 text-sm space-y-1">
                                <p><strong>Data e Hora:</strong> {{ $event->event_date_time }}</p>
                                <div class="text-gray-700 font-semibold">
                                        {{ $event->num_participantes_atuais }} / {{ $event->num_participantes }}
                                    </div>
                                <p><strong>Modalidade:</strong> {{ $event->modality }}</p>
                                <p><strong>Preço:</strong> {{ $event->price }} €</p>
                                <p><strong>Campo:</strong> {{ $event->field->name }}</p>
                                <p><strong>Descrição do Campo:</strong> {{ $event->field->description }}</p>
                                <p><strong>Localização:</strong> {{ $event->field->location }}</p>
                                <p><strong>Contacto:</strong> {{ $event->field->contact }}</p>
                            </div>
                            <div class="mt-4 text-center">
                                <div class="flex justify-between items-center">
                                    <div>
                                        @php
                                            $contactNumber = preg_replace('/[^0-9]/', '', $event->field->contact); // Remove caracteres não numéricos
                                            $whatsappMessage = urlencode("Olá, estou interessado no evento realizado no campo: {$event->field->name}. Gostaria de mais informações.");
                                        @endphp
                                        <a href="https://wa.me/{{ $contactNumber }}?text={{ $whatsappMessage }}" 
                                           target="_blank" 
                                           class="inline-block bg-green-500 text-white px-6 py-2 rounded-md font-semibold hover:bg-green-600 transition-all duration-300">
                                            Conversar com o Dono
                                        </a>
                                    </div>
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
