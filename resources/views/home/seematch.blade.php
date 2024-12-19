@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-3xl text-center py-6 text-gray-800 font-bold">Eventos Criados</h1>
            @if($events->isEmpty())
                <p class="text-center text-gray-500">Nenhum evento criado ainda.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 sm:p-6 lg:p-8">
                    @foreach($events as $event)
                    <div class="flex flex-col bg-white p-6 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300 ml-4 mr-4">
                        <div class="flex justify-center mb-4">
                            <img src="{{ asset('Fields/' . $event->field->image) }}" alt="{{ $event->field->name }}" class="w-full h-40 object-cover rounded-md shadow-md">
                        </div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2 text-center">{{ $event->description }}</h2>
                        <div class="text-gray-700 text-sm space-y-1">
                            <div class="flex justify-between items-center">
                                <p><strong>Data e Hora:</strong> {{ $event->event_date_time }}</p>
                                <p class="text-gray-700 text-lg font-semibold">
                                    {{ $event->num_subscribers }} / {{ $event->num_participants }}
                                </p>
                            </div>
                            <p><strong>Modalidade:</strong> {{ $event->modality }}</p>
                            <p><strong>Preço:</strong> {{ $event->price }} €</p>
                            <p><strong>Campo:</strong> {{ $event->field->name }}</p>
                            <p><strong>Descrição do Campo:</strong> {{ $event->field->description }}</p>
                            <p><strong>Localização:</strong> {{ $event->field->location }}</p>
                            <p><strong>Contacto:</strong> {{ $event->field->contact }}</p>
                        </div>

                        <!-- Buttons for Contact and Share -->
                        <div class="mt-4 text-center flex justify-between items-center">
                            <!-- Contact Button -->
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

                            <!-- Share Button with Icon (SVG) -->
                            <div class="relative">
                                <button id="shareButton" class="text-gray-500 hover:text-gray-700">
                                    <!-- SVG Share Icon -->
                                    <svg class="h-8 w-8 text-gray-500 hover:text-gray-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z"/>
                                        <circle cx="6" cy="12" r="3" />
                                        <circle cx="18" cy="6" r="3" />
                                        <circle cx="18" cy="18" r="3" />
                                        <line x1="8.7" y1="10.7" x2="15.3" y2="7.3" />
                                        <line x1="8.7" y1="13.3" x2="15.3" y2="16.7" />
                                    </svg>
                                </button>

                                <!-- Modal for sharing options -->
                                <div id="shareModal" class="absolute hidden top-0 left-1/2 transform -translate-x-1/2 mt-10 w-64 p-4 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <h3 class="text-lg font-semibold mb-2 text-center">Partilhar evento</h3>
                                    <div class="flex justify-center space-x-4">
                                        <!-- Facebook Icon -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/events') . '?search=' . $event->description) }}&quote=Criei%20um%20evento%20no%20QuickMatch,%20venha%20jogar%20comigo!" target="_blank" class="text-blue-600">
                                            <svg class="h-8 w-8 text-blue-600" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z"/>
                                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                                            </svg>
                                        </a>

                                        <!-- Instagram Icon -->
                                        <a href="https://www.instagram.com/?url={{ urlencode(url('/events') . '?search=' . $event->description) }}" target="_blank" class="text-pink-600">
                                            <svg class="h-8 w-8 text-pink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                                            </svg>
                                        </a>

                                        <!-- Twitter Icon -->
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('/events') . '?search=' . $event->description) }}&text=Criei%20um%20evento%20no%20QuickMatch,%20venha%20jogar%20comigo!" target="_blank" class="text-blue-400">
                                            <svg class="h-8 w-8 text-blue-400" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                                <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                            </svg>
                                        </a>

                                        <!-- Copy Link Icon -->
                                        <!-- Botão de copiar link -->
                                            <button id="copyLinkButton-{{ $event->id }}" data-link="{{ url('/events') . '?search=' . $event->description }}" class="text-gray-600 hover:text-gray-800">
                                        <!-- Copy Icon SVG -->
                                                <svg class="h-8 w-8 text-gray-600 hover:text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                                </svg>
                                            </button>
                                    </div>
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

<script>
    // Verifica se o botão de compartilhamento existe antes de adicionar o ouvinte de eventos
    const shareButton = document.getElementById('shareButton');
    if (shareButton) {
        shareButton.addEventListener('click', function() {
            const modal = document.getElementById('shareModal');
            modal.classList.toggle('hidden');
        });
    }

    const copyLinkButtons = document.querySelectorAll('[id^="copyLinkButton-"]');
    
    copyLinkButtons.forEach(button => {
        button.addEventListener('click', function() {
            const link = button.getAttribute('data-link');
            navigator.clipboard.writeText(link).then(function() {
            })
        });
    });
</script>
</html>
