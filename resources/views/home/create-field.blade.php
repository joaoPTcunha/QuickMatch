@include('home.css')
@include('home.header')

<body class="bg-gray-100 flex flex-col min-h-screen">
    <main class="container mx-auto px-4 py-6 flex-grow">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight mb-4 text-center">
            {{ __('Adicionar Novo Campo') }}
        </h2>
        <div class="p-6 bg-white shadow-md rounded-lg max-w-2xl mx-auto">
            <form action="{{ route('store-fields') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-center mb-4">
                    <label for="image" class="cursor-pointer">
                        <img id="avatar" src="https://via.placeholder.com/150" alt="Avatar" class="w-full h-36 object-cover rounded-md mb-3">
                    </label>
                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                </div>
                <div class="text-center mb-4">
                    <label for="image" class="text-sm text-blue-600 hover:underline cursor-pointer">
                        Adicionar foto do campo
                    </label>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Campo</label>
                    <input type="text" name="name" id="name" required class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o nome do campo" autocomplete="name" />
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Descrição"></textarea>
                </div>
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Localização</label>
                    <input type="text" name="location" id="location" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira no mapa a localização do campo" autocomplete="off" readonly />
                </div>

                <!-- Mapa do Mapbox -->
                <div id="map" class="mb-4 w-full h-64"></div>

                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contato</label>
                    <input type="text" name="contact" id="contact" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o contato" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Horário de Disponibilidade</label>
                    <div class="mt-4">
                        <label for="availability" class="text-sm text-gray-700">Selecione os dias e horários</label>
                        
                        <!-- Filtro para seleção dos dias -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-2">
                            <div>
                                <input type="checkbox" id="monday" name="days[]" value="monday" class="mr-2">
                                <label for="monday">Segunda-feira</label>
                                <div id="monday-times" class="mt-2 hidden">
                                    <label for="monday_start" class="text-sm text-gray-700">Início</label>
                                    <input type="time" name="monday_start" id="monday_start" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                    <label for="monday_end" class="text-sm text-gray-700">Fim</label>
                                    <input type="time" name="monday_end" id="monday_end" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                
                            <div>
                                <input type="checkbox" id="tuesday" name="days[]" value="tuesday" class="mr-2">
                                <label for="tuesday">Terça-feira</label>
                                <div id="tuesday-times" class="mt-2 hidden">
                                    <label for="tuesday_start" class="text-sm text-gray-700">Início</label>
                                    <input type="time" name="tuesday_start" id="tuesday_start" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                    <label for="tuesday_end" class="text-sm text-gray-700">Fim</label>
                                    <input type="time" name="tuesday_end" id="tuesday_end" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                
                            <div>
                                <input type="checkbox" id="wednesday" name="days[]" value="wednesday" class="mr-2">
                                <label for="wednesday">Quarta-feira</label>
                                <div id="wednesday-times" class="mt-2 hidden">
                                    <label for="wednesday_start" class="text-sm text-gray-700">Início</label>
                                    <input type="time" name="wednesday_start" id="wednesday_start" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                    <label for="wednesday_end" class="text-sm text-gray-700">Fim</label>
                                    <input type="time" name="wednesday_end" id="wednesday_end" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                
                            <div>
                                <input type="checkbox" id="thursday" name="days[]" value="thursday" class="mr-2">
                                <label for="thursday">Quinta-feira</label>
                                <div id="thursday-times" class="mt-2 hidden">
                                    <label for="thursday_start" class="text-sm text-gray-700">Início</label>
                                    <input type="time" name="thursday_start" id="thursday_start" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                    <label for="thursday_end" class="text-sm text-gray-700">Fim</label>
                                    <input type="time" name="thursday_end" id="thursday_end" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                
                            <div>
                                <input type="checkbox" id="friday" name="days[]" value="friday" class="mr-2">
                                <label for="friday">Sexta-feira</label>
                                <div id="friday-times" class="mt-2 hidden">
                                    <label for="friday_start" class="text-sm text-gray-700">Início</label>
                                    <input type="time" name="friday_start" id="friday_start" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                    <label for="friday_end" class="text-sm text-gray-700">Fim</label>
                                    <input type="time" name="friday_end" id="friday_end" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                
                            <div>
                                <input type="checkbox" id="saturday" name="days[]" value="saturday" class="mr-2">
                                <label for="saturday">Sábado</label>
                                <div id="saturday-times" class="mt-2 hidden">
                                    <label for="saturday_start" class="text-sm text-gray-700">Início</label>
                                    <input type="time" name="saturday_start" id="saturday_start" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                    <label for="saturday_end" class="text-sm text-gray-700">Fim</label>
                                    <input type="time" name="saturday_end" id="saturday_end" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                
                            <div>
                                <input type="checkbox" id="sunday" name="days[]" value="sunday" class="mr-2">
                                <label for="sunday">Domingo</label>
                                <div id="sunday-times" class="mt-2 hidden">
                                    <label for="sunday_start" class="text-sm text-gray-700">Início</label>
                                    <input type="time" name="sunday_start" id="sunday_start" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                    <label for="sunday_end" class="text-sm text-gray-700">Fim</label>
                                    <input type="time" name="sunday_end" id="sunday_end" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço por Hora</label>
                    <input type="text" name="price" id="price" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o valor" />
                </div>

                <div class="mb-4">
                    <label for="modality-futebol" class="block text-sm font-medium text-gray-700">Modalidades</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-futebol" name="modality[]" value="futebol" class="mr-2"> Futebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-futebol7" name="modality[]" value="futebol 7" class="mr-2"> Futebol 7
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-futsal" name="modality[]" value="futsal" class="mr-2"> Futsal
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-basquetebol" name="modality[]" value="basquetebol" class="mr-2"> Basquetebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-voleibol" name="modality[]" value="voleibol" class="mr-2"> Voleibol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-andebol" name="modality[]" value="andebol" class="mr-2"> Andebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-tenis" name="modality[]" value="ténis" class="mr-2"> Ténis
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-raguebi" name="modality[]" value="raguebi" class="mr-2"> Raguebi
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-atletismo" name="modality[]" value="atletismo" class="mr-2"> Atletismo
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="modality-outros" name="modality[]" value="outros" class="mr-2"> Outros
                        </label>
                
                        <!-- Campo de entrada para "Outros" -->
                        <div class="col-span-2 sm:col-span-3 lg:col-span-5 mt-2 hidden" id="other-sport-container">
                            <label for="other-sport" class="text-sm text-gray-700">Escreva o nome do desporto</label>
                            <input type="text" id="other-sport" name="other_sport" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" placeholder="Insira o nome do desporto" />
                        </div>
                    </div>
                </div>
                
                
                <div class="text-center mt-6">
                    <button type="submit" class="w-full bg-blue-900 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        Adicionar Campo
                    </button>
                </div>
            </form>
        </div>
        @include('home.footer')

    <style>
        #map {
            height: 600px;
        }
    </style>

    <script>
        let map, marker;

        // Chave de API do Mapbox
        const mapboxApiKey = 'pk.eyJ1Ijoiam9zZTAxMCIsImEiOiJjbTN6dWxmOW8yMHptMmpzY2tmZnp6cDkxIn0.RDV-Y71ZzX5d8sq8CFy0Fg';

        // Função para inicializar o mapa
        function initMap() {
            mapboxgl.accessToken = mapboxApiKey;
            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/satellite-streets-v11', // Estilo de satélite com rótulos
                center: [-8.2242, 39.3999], // Coordenadas do centro de Portugal
                zoom: 7
            });

            // Adiciona marcador padrão
            marker = new mapboxgl.Marker({
                    draggable: true
                })
                .setLngLat([-8.2242, 39.3999])
                .addTo(map)
                .on('dragend', function() {
                    const lngLat = marker.getLngLat();
                    reverseGeocode(lngLat);
                });

            // Adiciona o Geocoder ao mapa
            const geocoder = new MapboxGeocoder({
                accessToken: mapboxApiKey,
                mapboxgl: mapboxgl,
                placeholder: 'Pesquisar localização',
                countries: 'pt'
            });

            map.addControl(geocoder, 'top-right');

            // Ouvinte de clique no mapa
            map.on('click', function(event) {
                placeMarker(event.lngLat);
            });

            // Ouvinte de seleção de localização pelo Geocoder
            geocoder.on('result', function(event) {
                const lngLat = event.result.geometry.coordinates;
                placeMarker(lngLat);
            });
        }

        // Função para colocar o marcador e preencher o campo de localização
        function placeMarker(lngLat) {
            if (marker) {
                marker.remove();
            }
            marker = new mapboxgl.Marker({
                    draggable: true
                })
                .setLngLat(lngLat)
                .addTo(map)
                .on('dragend', function() {
                    const lngLat = marker.getLngLat();
                    reverseGeocode(lngLat);
                });

            reverseGeocode(lngLat);
        }

        // Função para obter o endereço a partir das coordenadas
        function reverseGeocode(lngLat) {
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lngLat.lng},${lngLat.lat}.json?access_token=${mapboxApiKey}&country=pt`)
                .then(response => response.json())
                .then(data => {
                    if (data.features.length > 0) {
                        document.getElementById("location").value = data.features[0].place_name;
                    } else {
                        document.getElementById("location").value = 'Localização desconhecida';
                    }
                })
                .catch(error => console.error("Erro ao obter o endereço:", error));
        }

        // Inicializa o mapa
        document.addEventListener('DOMContentLoaded', function() {
            initMap();

            // Script para exibir a imagem selecionada
            document.getElementById('image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('avatar').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <script>
        // Script para mostrar/esconder os horários conforme o dia é selecionado
        document.addEventListener('DOMContentLoaded', function() {
            const daysCheckboxes = document.querySelectorAll('input[type="checkbox"][name="days[]"]');
            
            daysCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const day = this.value;
                    const timesDiv = document.getElementById(day + '-times');
                    
                    if (this.checked) {
                        timesDiv.classList.remove('hidden');
                    } else {
                        timesDiv.classList.add('hidden');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otherSportCheckbox = document.getElementById('modality-outros');
            const otherSportContainer = document.getElementById('other-sport-container');
        
            // Inicializa o estado do campo de texto "Outros"
            if (otherSportCheckbox.checked) {
                otherSportContainer.classList.remove('hidden');
            } else {
                otherSportContainer.classList.add('hidden');
            }
        
            // Escuta as mudanças no checkbox "Outros"
            otherSportCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    otherSportContainer.classList.remove('hidden');
                } else {
                    otherSportContainer.classList.add('hidden');
                }
            });
        });
    </script>        
   
</body>

</html>