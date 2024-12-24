@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-4xl text-center py-6 text-gray-800 font-semibold">Eventos Disponíveis</h1>

        <form method="GET" action="{{ route('showEvents') }}">
            @csrf
            <div class="flex flex-wrap justify-between items-center ml-5 mr-5 px-4 text-gray-800 mb-6 space-y-4 sm:space-y-0">
                <!-- Modalidades como texto clicável (desktop) -->
                <div class="hidden sm:flex flex-wrap space-x-4">
                    <span class="filter-link cursor-pointer hover:underline text-gray-700 text-lg">
                        <a href="{{ route('showEvents', ['filter' => 'all']) }}" class="{{ request('filter') == 'all' ? 'text-gray-800' : 'text-gray-700' }}">Todos</a>
                    </span>
                    <span class="filter-link cursor-pointer hover:underline text-gray-500 text-lg">
                        <a href="{{ route('showEvents', ['filter' => 'Futebol']) }}" class="{{ request('filter') == 'Futebol' ? 'text-gray-800' : 'text-gray-500' }}">Futebol</a>
                    </span>
                    <span class="filter-link cursor-pointer hover:underline text-orange-500 text-lg">
                        <a href="{{ route('showEvents', ['filter' => 'Basquetebol']) }}" class="{{ request('filter') == 'Basquetebol' ? 'text-gray-800' : 'text-orange-500' }}">Basquetebol</a>
                    </span>
                    <span class="filter-link cursor-pointer hover:underline text-green-600 text-lg">
                        <a href="{{ route('showEvents', ['filter' => 'Ténis']) }}" class="{{ request('filter') == 'Ténis' ? 'text-gray-800' : 'text-green-600' }}">Ténis</a>
                    </span>
                    <span class="filter-link cursor-pointer hover:underline text-yellow-500 text-lg">
                        <a href="{{ route('showEvents', ['filter' => 'Voleibol']) }}" class="{{ request('filter') == 'Voleibol' ? 'text-gray-800' : 'text-yellow-500' }}">Voleibol</a>
                    </span>
                    <span class="filter-link cursor-pointer hover:underline text-green-500 text-lg">
                        <a href="{{ route('showEvents', ['filter' => 'Padel']) }}" class="{{ request('filter') == 'Padel' ? 'text-gray-800' : 'text-green-500' }}">Padel</a>
                    </span>
                    <span class="filter-link cursor-pointer hover:underline text-blue-500 text-lg">
                        <a href="{{ route('showEvents', ['filter' => 'Futsal']) }}" class="{{ request('filter') == 'Futsal' ? 'text-gray-800' : 'text-blue-500' }}">Futsal</a>
                    </span>
                </div>
        
                <!-- Modalidades como dropdown (mobile) -->
                <div class="sm:hidden relative flex justify-start w-full">
                    <select name="filter" id="mobileFilter" class="w-full px-2 py-2 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Todos</option>
                        <option value="Futebol" {{ request('filter') == 'Futebol' ? 'selected' : '' }}>Futebol</option>
                        <option value="Basquetebol" {{ request('filter') == 'Basquetebol' ? 'selected' : '' }}>Basquetebol</option>
                        <option value="Ténis" {{ request('filter') == 'Ténis' ? 'selected' : '' }}>Ténis</option>
                        <option value="Voleibol" {{ request('filter') == 'Voleibol' ? 'selected' : '' }}>Voleibol</option>
                        <option value="Padel" {{ request('filter') == 'Padel' ? 'selected' : '' }}>Padel</option>
                        <option value="Futsal" {{ request('filter') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                    </select>
                </div>
            </div>

            <!-- Filtro de ordens -->
            <div class="flex flex-wrap items-center px-4 sm:px-6 lg:px-8 mb-6 space-y-4 sm:space-y-0 sm:space-x-4">
                <select name="sort" id="sortOptions" class="w-full sm:w-auto px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                    <option value="all">Selecione um filtro..</option>
                    <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Mais Recente</option>
                    <option value="alphabetical" {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>Ordem Alfabética</option>
                    <option value="registered" {{ request('sort') === 'registered' ? 'selected' : '' }}>Eventos nos quais estou inscrito</option>
                </select>

                <!-- Barra de pesquisa -->
                <div class="flex items-center w-full sm:w-1/2 focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="search" id="searchBar" placeholder="Procurar por nome do evento" class="w-full px-4 py-2 border rounded-lg focus:ring-2" value="{{ request('search') }}">
                </div>
            </div>

            <div id="eventGridContainer">
                @if($events->isEmpty())
                    <div class="text-center text-gray-500 text-lg mt-4">
                        Nenhum resultado encontrado.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 sm:p-6 lg:p-8" id="eventGrid">
                        @foreach($events as $event)
                        <div class="event-card flex flex-col bg-white p-6 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300 h-fit">
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('Fields/' . $event->field->image) }}" alt="{{ $event->field->name }}" class="w-full h-40 object-cover rounded-md shadow-md">
                            </div>
                            <h2 class="text-xl font-bold text-gray-800 mb-2 text-center">{{ $event->description }}</h2>
                            <div class="flex-grow">
                                <div class="flex justify-between text-gray-700 text-base">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Data e Hora:</span> {{ \Carbon\Carbon::parse($event->event_date_time)->format('d/m/Y H:i') }}</p>
                                        <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Campo:</span> {{ $event->field->name }}</p>
                                        <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Modalidade:</span> {{ $event->modality }}</p>
                                        <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Preço:</span> {{ number_format($event->price, 2) }} €</p>
                                        <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Nome do Criador:</span> {{ $event->user->name }}</p>
                                    </div>
                                    <div class="text-right text-lg font-semibold">
                                        {{ $event->num_subscribers }} / {{ $event->num_participants }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                @php
                                    $isFull = $event->num_subscribers >= $event->num_participants;
                                @endphp
                            
                                @if ($event->isSubscribed)
                                    <a href="#" onclick="cancelParticipation({{ $event->id }}); return false;" 
                                       class="inline-block bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600 transition-all duration-300 w-full sm:w-auto mb-2">
                                       Cancelar Inscrição
                                    </a>
                                @elseif ($isFull)
                                    <button class="bg-gray-500 text-white px-6 py-2 rounded-lg cursor-not-allowed w-full sm:w-auto mb-2" disabled>Evento Lotado</button>
                                @else
                                    <a href="#" onclick="confirmParticipation({{ $event->id }}); return false;" 
                                       class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 transition-all duration-300 w-full sm:w-auto mb-2">
                                       Participar
                                    </a>
                                @endif
                            
                                <button type="button" class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-600 transition-all duration-300 w-full sm:w-auto" data-location="{{ $event->field->location }}">
                                        Ver Localização
                                </button>
                            </div>                        
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </form>
    </div>
    @include('home.footer')

    <div id="locationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 sm:p-8 lg:p-10 rounded-lg shadow-lg w-full max-w-3xl">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-2xl font-semibold">Localização do Campo</h5>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
    
            <div id="distanceInfo" class="mt-4 text-gray-700 text-center mb-4">
                <p id="distanceText" class="text-xl font-bold"></p>
                <p id="durationText" class="text-lg"></p>
            </div>
            
            <!-- Transport Mode Selection -->
            <select id="travelMode" class="shadow appearance-none border rounded p-2 font-semibold text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-auto mb-4">
                <option value="driving">🚗 Carro</option>
                <option value="walking">🚶‍♂️ A Pé</option>
                <option value="cycling">🚴‍♂️ Bicicleta</option>
            </select>
    
            <!-- Location Display with horizontal scroll -->
                <label id="locationName" class="block w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base break-words min-h-[1rem] overflow-y-auto max-h-24"></label>

                <!-- Map -->
            <div id="modalMap" class="h-64 sm:h-96 mt-4 w-full"></div>
    
            <div class="mt-4 flex justify-end">
                <button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Fechar
                </button>
            </div>
        </div>
    </div>
    
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Map modal elements
            const modal = document.getElementById('locationModal');
            const closeModalButtons = document.querySelectorAll('#closeModal, #closeModalButton');
            const openModalButtons = document.querySelectorAll('button[data-location]');
            const travelModeSelect = document.getElementById('travelMode');
            let isModalOpen = false;
    
            // Modal event listeners
            openModalButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const location = button.getAttribute('data-location');
                    geocodeAddress(location);
                    modal.classList.remove('hidden');
                    isModalOpen = true;
                });
            });
    
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function () {
                    modal.classList.add('hidden');
                    isModalOpen = false;
                });
            });
    
            modal.addEventListener('click', function (e) {
                if (e.target === modal && isModalOpen) {
                    modal.classList.add('hidden');
                    isModalOpen = false;
                }
            });
    
            travelModeSelect.addEventListener('change', function () {
                const location = document.querySelector('button[data-location]:not([style*="display: none;"])').getAttribute('data-location');
                geocodeAddress(location);
            });
    
            // Mapbox configuration
            const mapboxApiKey = 'pk.eyJ1Ijoiam9zZTAxMCIsImEiOiJjbTN6dWxmOW8yMHptMmpzY2tmZnp6cDkxIn0.RDV-Y71ZzX5d8sq8CFy0Fg';
    
            function geocodeAddress(address) {
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${mapboxApiKey}&country=pt`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.features.length > 0) {
                            const lngLat = data.features[0].center;
                            const placeName = data.features[0].place_name;
                            displayLocation(placeName);
                            initMap(lngLat);
                        } else {
                            alert('Localização não encontrada.');
                        }
                    })
                    .catch(error => console.error("Erro ao obter as coordenadas:", error));
            }
    
            function displayLocation(placeName) {
                const locationText = document.getElementById('locationName');
                locationText.textContent = placeName;
            }
    
            function initMap(lngLat) {
                mapboxgl.accessToken = mapboxApiKey;
                const map = new mapboxgl.Map({
                    container: 'modalMap',
                    style: 'mapbox://styles/mapbox/satellite-streets-v12',
                    center: lngLat,
                    zoom: 15
                });
    
                new mapboxgl.Marker({ color: 'green' })
                    .setLngLat(lngLat)
                    .addTo(map);
    
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const userLngLat = [position.coords.longitude, position.coords.latitude];
                        new mapboxgl.Marker({ color: 'red' })
                            .setLngLat(userLngLat)
                            .addTo(map);
                        getRoute(userLngLat, lngLat, map);
                    }, function (error) {
                        console.error("Erro ao obter a localização do usuário:", error);
                        document.getElementById('distanceText').innerText = 'Não foi possível obter a sua localização.';
                    });
                } else {
                    console.error("Geolocalização não suportada.");
                }
            }
    
            function getRoute(userLngLat, fieldLngLat, map) {
                const travelMode = travelModeSelect.value;
                fetch(`https://api.mapbox.com/directions/v5/mapbox/${travelMode}/${userLngLat[0]},${userLngLat[1]};${fieldLngLat[0]},${fieldLngLat[1]}?access_token=${mapboxApiKey}&geometries=geojson`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.routes.length > 0) {
                            const route = data.routes[0];
                            const distanceKm = (route.distance / 1000).toFixed(2);
                            const durationMinutes = Math.round(route.duration / 60);
    
                            const durationText = durationMinutes >= 60
                                ? `${Math.floor(durationMinutes / 60)}h ${durationMinutes % 60}min`
                                : `${durationMinutes} min`;
    
                            document.getElementById('distanceText').innerText = `Distância: ${distanceKm} km`;
                            document.getElementById('durationText').innerText = `Tempo de Viagem: ${durationText}`;
    
                            if (map.getLayer('route')) {
                                map.removeLayer('route');
                                map.removeSource('route');
                            }
    
                            map.addLayer({
                                id: 'route',
                                type: 'line',
                                source: {
                                    type: 'geojson',
                                    data: route.geometry
                                },
                                layout: {
                                    'line-join': 'round',
                                    'line-cap': 'round'
                                },
                                paint: {
                                    'line-color': 'blue',
                                    'line-width': 6,
                                    'line-opacity': 0.75
                                }
                            });
                        } else {
                            alert('Não foi possível calcular a rota.');
                        }
                    })
                    .catch(error => console.error("Erro ao obter a rota:", error));
            }
        });
    
        // Participation confirmation functions
        function confirmParticipation(eventId) {
            Swal.fire({
                title: 'Confirmação',
                text: "Deseja participar deste evento?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('participateInEvent', ['id' => ':id']) }}".replace(':id', eventId);
                }
            });
        }
    
        function cancelParticipation(eventId) {
            Swal.fire({
                title: 'Confirmação',
                text: "Deseja cancelar sua inscrição neste evento?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, cancelar',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('cancelParticipation', ['id' => ':id']) }}".replace(':id', eventId);
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchBar = document.getElementById('searchBar');
            const eventGrid = document.getElementById('eventGrid');
            const noResultsMessage = document.createElement('div');
            noResultsMessage.className = 'text-center text-gray-500 text-lg mt-4 hidden';
            noResultsMessage.id = 'noResultsMessage';
            noResultsMessage.innerText = 'Nenhum resultado encontrado.';
            eventGrid.parentElement.appendChild(noResultsMessage);
        
            searchBar.addEventListener('input', function () {
                const searchTerm = searchBar.value.toLowerCase();
                const eventCards = eventGrid.querySelectorAll('.event-card');
        
                let hasResults = false;
        
                eventCards.forEach(card => {
                    const description = card.querySelector('h2').innerText.toLowerCase();
                    if (description.includes(searchTerm)) {
                        card.style.display = 'block';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
        
                if (hasResults) {
                    noResultsMessage.classList.add('hidden');
                } else {
                    noResultsMessage.classList.remove('hidden');
                }
            });
        });
    </script>        

</body>
