@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-4xl text-center py-6 text-gray-800 font-semibold">Eventos Criados</h1>
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
                                <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Data e Hora:</span> {{ $event->event_date_time }}</p>
                                <p class="text-gray-700 text-lg font-semibold">
                                    {{ $event->num_subscribers }} / {{ $event->num_participants }}
                                </p>
                            </div>
                            <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Modalidade:</span> {{ $event->modality }}</p>
                            <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Preço:</span> {{ $event->price }} €</p>
                            <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Campo:</span> {{ $event->field->name }}</p>
                            <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Descrição do Evento:</span> {{ $event->description }}</p>
                            <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Localização:</span> {{ $event->field->location }}</p>
                            <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Contacto:</span> {{ $event->field->contact }}</p>
                        </div>

                        <div class="mt-4 text-center flex justify-between items-center">
                            <div class="flex space-x-4">
                                @php
                                $contactNumber = preg_replace('/[^0-9]/', '', $event->field->contact); 
                                $whatsappMessage = urlencode("Olá, estou interessado no evento realizado no campo: {$event->field->name}. Gostaria de mais informações.");
                                @endphp
                                <a href="https://wa.me/{{ $contactNumber }}?text={{ $whatsappMessage }}"
                                    target="_blank"
                                    class="inline-block bg-green-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-green-600 transition-all duration-300 text-m">
                                    Conversar com o Dono
                                </a>
                        
                                <button class="inline-block bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600 transition-all duration-300 text-m" id="deleteButton-{{ $event->id }}" data-event-id="{{ $event->id }}">
                                    Apagar Evento
                                </button>
                            </div>

                    <div class="relative">
                        <a href="{{ url('print_pdf/'.$event->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </a>
                        <button id="shareButton-{{ $event->id }}" class="text-gray-500 hover:text-gray-700">
                            <svg class="h-8 w-8 text-gray-500 hover:text-gray-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <circle cx="6" cy="12" r="3" />
                                <circle cx="18" cy="6" r="3" />
                                <circle cx="18" cy="18" r="3" />
                                <line x1="8.7" y1="10.7" x2="15.3" y2="7.3" />
                                <line x1="8.7" y1="13.3" x2="15.3" y2="16.7" />
                            </svg>
                        </button>

                        <div id="shareModal-{{ $event->id }}" class="absolute hidden top-0 left-1/2 transform -translate-x-1/2 mt-10 w-64 p-4 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold mb-2 text-center">Partilhar evento</h3>
                            <div class="flex justify-center space-x-4">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/events') . '?search=' . $event->description) }}&quote=Criei%20um%20evento%20no%20QuickMatch,%20venha%20jogar%20comigo!" target="_blank" class="text-blue-600">
                                    <svg class="h-8 w-8 text-blue-600" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
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
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                    </svg>
                                </a>
                                <button id="copyLinkButton-{{ $event->id }}" data-link="{{ url('/events') . '?search=' . $event->description }}" class="text-gray-600 hover:text-gray-800">
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
const shareButtons = document.querySelectorAll('[id^="shareButton-"]');
shareButtons.forEach(button => {
    button.addEventListener('click', function() {
        const eventId = button.id.split('-')[1]; 
        const modal = document.getElementById('shareModal-' + eventId);
        modal.classList.toggle('hidden');
    });
});

const copyLinkButtons = document.querySelectorAll('[id^="copyLinkButton-"]');
copyLinkButtons.forEach(button => {
    button.addEventListener('click', function() {
        const link = button.getAttribute('data-link');
        navigator.clipboard.writeText(link).then(function() {});
    });
});
</script>
<script>
    const deleteButtons = document.querySelectorAll('[id^="deleteButton-"]');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const eventId = button.getAttribute('data-event-id'); 
            
            Swal.fire({
                title: 'Tem certeza que deseja apagar este evento?',
                text: "Esta ação não pode ser desfeita.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, apagar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'bg-red-500 text-white hover:bg-red-600',
                    cancelButton: 'bg-gray-600 text-white hover:bg-gray-600'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/events/${eventId}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
</html>