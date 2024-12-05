@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-3xl text-center py-6 text-gray-800 font-bold">Eventos Disponíveis</h1>
        <div class="px-4 sm:px-6 lg:px-8 mb-6">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 sm:p-6 lg:p-8">
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
        <div class="mt-6 px-4 sm:px-6 lg:px-8">
            {{ $events->links() }}
        </div>
    </div>
    @include('home.footer')

    <div id="locationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-lg w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-2xl font-bold">Localização do Campo</h5>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
            </div>
            <div id="distanceInfo" class="mt-4 text-gray-700 text-center">
                <p id="distanceText" class="text-xl font-bold"></p>
                <p id="durationText" class="text-lg"></p>
            </div>
            <select id="travelMode" class="shadow appearance-none border rounded p-2 font-semibold text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-auto">
                <option value="driving">
                    🚗 Carro
                </option>
                <option value="walking">
                    🚶‍♂️ A Pé
                </option>
                <option value="cycling">
                    🚴‍♂️ Bicicleta
                </option>
            </select>            
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
            const travelModeSelect = document.getElementById('travelMode');

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

            travelModeSelect.addEventListener('change', function() {
                const location = document.querySelector('button[data-location]:not([style*="display: none;"])').getAttribute('data-location');
                geocodeAddress(location);
            });

            // Chave de API do Mapbox
            const mapboxApiKey = 'pk.eyJ1Ijoiam9zZTAxMCIsImEiOiJjbTN6dWxmOW8yMHptMmpzY2tmZnp6cDkxIn0.RDV-Y71ZzX5d8sq8CFy0Fg';

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

            function initMap(lngLat) {
                mapboxgl.accessToken = mapboxApiKey;
                var map = new mapboxgl.Map({
                    container: 'modalMap',
                    style: 'mapbox://styles/mapbox/satellite-streets-v12', // Estilo de satélite com rótulos
                    center: lngLat,
                    zoom: 15
                });

                var fieldMarker = new mapboxgl.Marker({ color: 'green' })
                    .setLngLat(lngLat)
                    .addTo(map);

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLngLat = [position.coords.longitude, position.coords.latitude];

                        var userMarker = new mapboxgl.Marker({ color: 'red' })
                            .setLngLat(userLngLat)
                            .addTo(map);

                        getRoute(userLngLat, lngLat, map);

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

            function getRoute(userLngLat, fieldLngLat, map) {
                const travelMode = travelModeSelect.value;
                fetch(`https://api.mapbox.com/directions/v5/mapbox/${travelMode}/${userLngLat[0]},${userLngLat[1]};${fieldLngLat[0]},${fieldLngLat[1]}?access_token=${mapboxApiKey}&geometries=geojson`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.routes.length > 0) {
                            const route = data.routes[0];
                            const distanceKm = (route.distance / 1000).toFixed(2);
                            const durationMinutes = Math.round(route.duration / 60); // Tempo em minutos, arredondado

                            let durationText;
                            if (durationMinutes >= 60) {
                                const hours = Math.floor(durationMinutes / 60);
                                const minutes = durationMinutes % 60;
                                durationText = `${hours}h ${minutes}min`;
                            } else {
                                durationText = `${durationMinutes} min`;
                            }

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
