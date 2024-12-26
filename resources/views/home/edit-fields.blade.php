@include('home.css')
@include('home.header')

<body class="bg-gray-200 flex flex-col min-h-screen">
    <main class="container mx-auto px-4 py-6 flex-grow">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight mb-4 text-center">
            {{ __('Editar Campo: ' . $field->name) }}
        </h2>

        <div class="p-6 bg-white shadow-md rounded-lg max-w-2xl mx-auto">
            <form action="{{ route('update-field', $field->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex justify-center mb-4">
                    <label for="image" class="cursor-pointer block w-full sm:w-1/2">
                        <img id="avatar" src="{{ asset('Fields/' . $field->image) }}" alt="Avatar" class="w-full h-40 object-cover rounded-md mb-3">
                    </label>
                    
                    
                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                </div>
                <div class="text-center mb-4">
                    <label for="image" class="text-sm text-blue-600 hover:underline cursor-pointer">
                        Alterar foto do campo
                    </label>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Campo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $field->name) }}" required class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o nome do campo" />
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Descrição">{{ old('description', $field->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Localização</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $field->location) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira no mapa a localização do campo" readonly />
                </div>

                <!-- Mapa do Mapbox -->
                <div id="map" class="mb-4 w-full h-64"></div>

                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contato</label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact', $field->contact) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o contacto" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Horário de Disponibilidade</label>
                    <div class="mt-4">
                        <label for="availability" class="text-sm text-gray-700">Selecione os dias e horários</label>
                
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-2">
                            @foreach(['monday' => 'Segunda-feira', 'tuesday' => 'Terça-feira', 'wednesday' => 'Quarta-feira', 
                                     'thursday' => 'Quinta-feira', 'friday' => 'Sexta-feira', 'saturday' => 'Sábado', 
                                     'sunday' => 'Domingo'] as $day => $label)
                                <div>
                                    <!-- Checkbox para selecionar o dia -->
                                    <input type="checkbox" id="{{ $day }}" name="days[]" value="{{ $day }}" class="mr-2"
                                        @if(in_array($day, old('days', isset($availability[$day]) ? [$day] : []))) checked @endif>
                                    <label for="{{ $day }}">{{ $label }}</label>
                
                                    <!-- Campos de horário dinâmico de início e fim -->
                                    <div id="{{ $day }}-times" class="mt-2 {{ in_array($day, old('days', isset($availability[$day]) ? [$day] : [])) ? '' : 'hidden' }}">
                                        <div class="timeslot-container">
                                            @foreach(old($day.'_start', isset($availability[$day]) ? $availability[$day] : []) as $index => $time)
                                                <div class="timeslot">
                                                    <label for="{{ $day }}_start_{{ $index }}" class="text-sm text-gray-700">Início</label>
                                                    <input type="time" name="{{ $day }}_start[]" id="{{ $day }}_start_{{ $index }}"
                                                        value="{{ old($day.'_start.'.$index, $time['start'] ?? '') }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                                                    
                                                    <label for="{{ $day }}_end_{{ $index }}" class="text-sm text-gray-700">Fim</label>
                                                    <input type="time" name="{{ $day }}_end[]" id="{{ $day }}_end_{{ $index }}"
                                                        value="{{ old($day.'_end.'.$index, $time['end'] ?? '') }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                
                                                    <button type="button" class="remove-time-btn text-red-500 hover:underline mt-2" onclick="removeTimeSlot('{{ $day }}', {{ $index }})">Remover</button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="add-time-btn text-blue-500 hover:underline mt-4" onclick="addTimeSlot('{{ $day }}')">Adicionar horário</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>                
                    </div>                         
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço por Hora</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $field->price) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o valor" />
                </div>

                <div class="mb-4">
                    <label for="modality" class="block text-sm font-medium text-gray-700">Modalidades</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="futebol" class="mr-2"
                                {{ in_array('futebol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Futebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="futebol 7" class="mr-2"
                                {{ in_array('futebol 7', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Futebol 7
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="futsal" class="mr-2"
                                {{ in_array('futsal', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Futsal
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="basquetebol" class="mr-2"
                                {{ in_array('basquetebol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Basquetebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="voleibol" class="mr-2"
                                {{ in_array('voleibol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Voleibol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="andebol" class="mr-2"
                                {{ in_array('andebol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Andebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="ténis" class="mr-2"
                                {{ in_array('ténis', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Ténis
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="raguebi" class="mr-2"
                                {{ in_array('raguebi', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Raguebi
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="padel" class="mr-2"
                                {{ in_array('padel', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Padel
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="outro" class="mr-2"
                                {{ in_array('outro', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Outro
                        </label>
                    </div>

                    <!-- Campo Modalidade Personalizada (aparece quando 'Outro' é selecionado) -->
                    <div class="mb-4 {{ in_array('outro', old('modality', explode(',', $field->modality))) ? '' : 'hidden' }}">
                        <label for="customModality" class="block text-sm font-medium text-gray-700">Qual a modalidade?</label>
                        <input type="text" name="customModality" id="customModality" value="{{ old('customModality') }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    Atualizar Campo
                </button>
            </form>
        </div>
    </main>

    @include('home.footer')

    <style>
        #map { height: 400px; }
    </style>

    <script>
        let map, marker;
        const mapboxApiKey = 'pk.eyJ1Ijoiam9zZTAxMCIsImEiOiJjbTN6dWxmOW8yMHptMmpzY2tmZnp6cDkxIn0.RDV-Y71ZzX5d8sq8CFy0Fg';

        function initMap() {
            mapboxgl.accessToken = mapboxApiKey;
            
            // Initialize with field's current location or default to Portugal center
            const initialLat = {{ $field->latitude ?? 39.3999 }};
            const initialLng = {{ $field->longitude ?? -8.2242 }};

            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/satellite-streets-v11',
                center: [initialLng, initialLat],
                zoom: 15
            });

            marker = new mapboxgl.Marker({
                draggable: true
            })
            .setLngLat([initialLng, initialLat])
            .addTo(map)
            .on('dragend', function() {
                const lngLat = marker.getLngLat();
                reverseGeocode(lngLat);
            });

            const geocoder = new MapboxGeocoder({
                accessToken: mapboxApiKey,
                mapboxgl: mapboxgl,
                placeholder: 'Pesquisar localização',
                countries: 'pt'
            });
            
            // Adicionar o geocoder no mapa e ajustar largura
            map.addControl(geocoder, 'top-right');
            const geocoderElement = document.querySelector('.mapboxgl-ctrl-geocoder');
            
            // Configurar largura total no carregamento
            geocoderElement.style.width = '80%';
            geocoderElement.style.maxWidth = 'none';
            geocoderElement.style.margin = '10px';
            

            map.on('click', function(event) {
                placeMarker(event.lngLat);
            });

            geocoder.on('result', function(event) {
                const lngLat = event.result.geometry.coordinates;
                placeMarker(lngLat);
            });
        }

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

        document.addEventListener('DOMContentLoaded', function() {
            initMap();

            // Image preview handler
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

            // Availability time slots handler
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

        function addTimeSlot(day) {
            const timeslotContainer = document.querySelector(`#${day}-times .timeslot-container`);
            const index = timeslotContainer.children.length;
            const timeslotHTML = `
                <div class="timeslot">
                    <label for="${day}_start_${index}" class="text-sm text-gray-700">Início</label>
                    <input type="time" name="${day}_start[]" id="${day}_start_${index}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                        
                    <label for="${day}_end_${index}" class="text-sm text-gray-700">Fim</label>
                    <input type="time" name="${day}_end[]" id="${day}_end_${index}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-lg" />
                    
                    <button type="button" class="remove-time-btn text-red-500 hover:underline mt-2" onclick="removeTimeSlot('${day}', ${index})">Remover</button>
                </div>
            `;
            timeslotContainer.insertAdjacentHTML('beforeend', timeslotHTML);
        }

        function removeTimeSlot(day, index) {
            const timeslot = document.querySelector(`#${day}-times .timeslot:nth-child(${index + 1})`);
            timeslot.remove();
        }
    </script>
</body>