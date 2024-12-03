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
                    <a href="{{ route('new.match', ['id' => $event->field->id]) }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 transition-all duration-300">
                        Participar
                    </a>
                    <button class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-600 transition-all duration-300 ml-2" data-location="{{ $event->field->location }}">
                        Ver Localização
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6 px-10 sm:px-20">
            {{ $events->links() }}
        </div>
    </div>
    @include('home.footer')

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet" />

    <!-- Modal -->
    <div id="locationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-bold">Localização do Campo</h5>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="distanceInfo" class="mt-4 text-gray-700 text-center">
                <p id="distanceText" class="text-xl font-bold"></p>
                <p id="durationText" class="text-lg"></p>
            </div>
            <div id="modalMap" class="h-96 mt-4"></div>
            <div class="mt-4 flex justify-end">
                <button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('locationModal');
            const closeModalButtons = document.querySelectorAll('#closeModal, #closeModalButton');
            const openModalButtons = document.querySelectorAll('button[data-location]');

            openModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const location = button.getAttribute('data-location');
                    geocodeAddress(location);
                    modal.classList.remove('hidden');
                });
            });

            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    modal.classList.add('hidden');
                });
            });

            // Chave de API do Mapbox
            const mapboxApiKey = 'pk.eyJ1Ijoiam9zZTAxMCIsImEiOiJjbTN6dWxmOW8yMHptMmpzY2tmZnp6cDkxIn0.RDV-Y71ZzX5d8sq8CFy0Fg';

            // Função para obter as coordenadas a partir do endereço
            function geocodeAddress(address) {
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${mapboxApiKey}&country=pt`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.features.length > 0) {
                            const lngLat = data.features[0].center;
                            initMap(lngLat);
                        } else {
                            alert('Localização não encontrada.');
                        }
                    })
                    .catch(error => console.error("Erro ao obter as coordenadas:", error));
            }

            // Função para inicializar o mapa
            function initMap(lngLat) {
                mapboxgl.accessToken = mapboxApiKey;
                var map = new mapboxgl.Map({
                    container: 'modalMap',
                    style: 'mapbox://styles/mapbox/satellite-streets-v11', // Estilo de satélite com rótulos
                    center: lngLat,
                    zoom: 15
                });

                // Adiciona marcador do campo
                var fieldMarker = new mapboxgl.Marker({ color: 'green' })
                    .setLngLat(lngLat)
                    .addTo(map);

                // Obtém a localização do usuário
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLngLat = [position.coords.longitude, position.coords.latitude];

                        // Adiciona marcador do usuário
                        var userMarker = new mapboxgl.Marker({ color: 'red' })
                            .setLngLat(userLngLat)
                            .addTo(map);

                        // Calcula a distância entre o usuário e o campo
                        const distance = calculateDistance(userLngLat, lngLat);
                        document.getElementById('distanceText').innerText = `Distância: ${distance.toFixed(2)} km`;

                        // Obtém a rota e as informações de tempo de viagem
                        getRoute(userLngLat, lngLat, map);

                        // Exibe a informação de distância
                        document.getElementById('distanceInfo').classList.remove('hidden');
                    }, function(error) {
                        console.error("Erro ao obter a localização do usuário:", error);
                        document.getElementById('distanceText').innerText = 'Não foi possível obter a sua localização.';
                        document.getElementById('distanceInfo').classList.remove('hidden');
                    });
                } else {
                    console.error("Geolocalização não suportada pelo navegador.");
                    document.getElementById('distanceText').innerText = 'Geolocalização não suportada pelo navegador.';
                    document.getElementById('distanceInfo').classList.remove('hidden');
                }
            }

            // Função para calcular a distância entre dois pontos (Haversine Formula)
            function calculateDistance(point1, point2) {
                const R = 6371; // Raio da Terra em km
                const dLat = toRadians(point2[1] - point1[1]);
                const dLon = toRadians(point2[0] - point1[0]);
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(toRadians(point1[1])) * Math.cos(toRadians(point2[1])) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                const distance = R * c;
                return distance;
            }

            // Função para converter graus para radianos
            function toRadians(degrees) {
                return degrees * (Math.PI / 180);
            }
            function getRoute(userLngLat, fieldLngLat, map) {
                fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${userLngLat[0]},${userLngLat[1]};${fieldLngLat[0]},${fieldLngLat[1]}?access_token=${mapboxApiKey}&geometries=geojson`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.routes.length > 0) {
                            const route = data.routes[0];
                            const durationMinutes = Math.round(route.duration / 60); // Tempo em minutos, arredondado
            
                            let durationText;
                            if (durationMinutes >= 60) {
                                const hours = Math.floor(durationMinutes / 60);
                                const minutes = durationMinutes % 60;
                                durationText = `${hours}h ${minutes}min`;
                            } else {
                                durationText = `${durationMinutes} min`;
                            }
            
                            // Exibe o tempo de viagem
                            document.getElementById('durationText').innerText = `Tempo de Viagem: ${durationText}`;
            
                            // Adiciona a rota ao mapa
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
                                    'line-opacity': 1
                                }
                            });
                        } else {
                            alert('Não foi possível obter a rota.');
                        }
                    })
                    .catch(error => console.error("Erro ao obter a rota:", error));
            }
            
        });
    </script>
</body>
</html>
