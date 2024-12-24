@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-4xl text-center py-6 text-gray-800 font-semibold">Lista de Campos</h1>
        
        <form method="GET" action="{{ url()->current() }}" class="mb-6">
            @csrf
            <!-- Modalidades texto clicável (desktop) --> 
            <div class="flex flex-wrap items-center px-4 sm:px-6 lg:px-8 mb-6 space-y-4 sm:space-y-0 sm:space-x-4">
                <!-- Modalidades para desktop -->
                <div class="hidden sm:flex flex-wrap items-center space-x-4 w-full mb-4">
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}" class="{{ !request('modality') ? 'text-gray-800 font-semibold' : 'text-gray-700' }}">Todos</a>
                    </span>
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}?modality=futebol" class="{{ request('modality') == 'futebol' ? 'text-gray-800 font-semibold' : 'text-gray-500' }}">Futebol</a>
                    </span>
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}?modality=basquetebol" class="{{ request('modality') == 'basquetebol' ? 'text-gray-800 font-semibold' : 'text-orange-500' }}">Basquetebol</a>
                    </span>
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}?modality=ténis" class="{{ request('modality') == 'ténis' ? 'text-gray-800 font-semibold' : 'text-green-600' }}">Ténis</a>
                    </span>
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}?modality=voleibol" class="{{ request('modality') == 'voleibol' ? 'text-gray-800 font-semibold' : 'text-yellow-500' }}">Voleibol</a>
                    </span>
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}?modality=padel" class="{{ request('modality') == 'padel' ? 'text-gray-800 font-semibold' : 'text-green-500' }}">Padel</a>
                    </span>
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}?modality=futsal" class="{{ request('modality') == 'futsal' ? 'text-gray-800 font-semibold' : 'text-blue-500' }}">Futsal</a>
                    </span>
                    <span class="filter-link cursor-pointer text-lg">
                        <a href="{{ url()->current() }}?modality=outros" class="{{ request('modality') == 'outros' ? 'text-gray-800 font-semibold' : 'text-gray-500' }}">Outros</a>
                    </span>
                </div>

                <!-- Modalidades dropdown para mobile -->
                <div class="sm:hidden w-full">
                    <select name="modality" class="w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring-2" onchange="this.form.submit()">
                        <option value="">Todas as Modalidades</option>
                        <option value="futebol" {{ request('modality') == 'futebol' ? 'selected' : '' }}>Futebol</option>
                        <option value="basquetebol" {{ request('modality') == 'basquetebol' ? 'selected' : '' }}>Basquetebol</option>
                        <option value="ténis" {{ request('modality') == 'ténis' ? 'selected' : '' }}>Ténis</option>
                        <option value="voleibol" {{ request('modality') == 'voleibol' ? 'selected' : '' }}>Voleibol</option>
                        <option value="padel" {{ request('modality') == 'padel' ? 'selected' : '' }}>Padel</option>
                        <option value="futsal" {{ request('modality') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="outros" {{ request('modality') == 'outros' ? 'selected' : '' }}>Outros</option>
                    </select>
                </div>

                <!-- Ordenação -->
                <div class="w-full sm:w-auto">
                    <select name="sort" class="w-full px-4 py-2 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">Ordenar por...</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nome (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nome (Z-A)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Preço (Menor-Maior)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Preço (Maior-Menor)</option>
                    </select>
                </div>

                <!-- Barra de pesquisa -->
                <div class="flex items-center w-full sm:w-1/2">
                    <div class="relative w-full">
                        <input type="text" 
                               name="search" 
                               id="searchBar" 
                               placeholder="Procurar..." 
                               class="w-full px-4 py-2 pl-10 border rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request('search') }}">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-4.35-4.35m1.49-2.83A9 9 0 1111 3a9 9 0 016.6 11.82z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mensagem de nenhum resultado encontrado (mover para perto da barra de pesquisa) -->
            @if($fields->isEmpty())
                <div class="text-center text-gray-500 text-lg mb-4">
                    Nenhum resultado encontrado.
                </div>
            @endif
        </form>
        
        <!-- Exibição dos campos -->
@if(!$fields->isEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 sm:p-6 lg:p-8">
        @foreach($fields as $field)
            <div class="flex flex-col bg-white p-4 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="w-full mb-4">
                    <label for="field_image_{{ $field->id }}" class="block w-full">
                        <!-- Imagem com largura total e altura fixa de 40 -->
                        <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-40 object-cover rounded-md shadow-md">
                    </label>
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-2 text-center">{{ $field->name }}</h2>
                <div class="text-gray-700 text-sm space-y-1">
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Localização:</span> {{ $field->location }}</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Preço:</span> {{ $field->price }}€</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Modalidade(s):</span> {{ $field->modality }}</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Descrição:</span> {{ $field->description }}</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Nome do Dono:</span> {{ $field->user->name }}</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Email:</span> {{ $field->user->email }}</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Contacto:</span> {{ $field->contact }}</p>

                    @if($field->availability)
                        <div class="text-sm text-gray-700 mb-4">
                            <span class="font-semibold">Disponibilidade:</span>                        
                            <ul class="list-inside list-disc space-y-1 mt-1">
                                @php
                                    $availabilitySlots = json_decode($field->availability, true);
                                    $dayTranslations = [
                                        'monday' => 'Segundas-feiras',
                                        'tuesday' => 'Terças-feiras',
                                        'wednesday' => 'Quartas-feiras',
                                        'thursday' => 'Quintas-feiras',
                                        'friday' => 'Sextas-feiras',
                                        'saturday' => 'Sábados',
                                        'sunday' => 'Domingos',
                                    ];
                                @endphp

                                @foreach($availabilitySlots as $day => $times)
                                    <li>
                                        <span class="font-semibold">{{ ucfirst($dayTranslations[$day] ?? $day) }}:</span>
                                        <ul class="list-inside list-disc pl-5">
                                            @foreach($times as $time)
                                                <li>{{ $time['start'] }} - {{ $time['end'] }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="text-sm text-gray-700 mb-3">Disponibilidade não definida.</p>
                    @endif
                </div>
                <!-- Garantir que o botão fique dentro do card -->
                <div class="mt-4 text-center">
                    <a href="{{ url('/newmatch/'.$field->id) }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-600 transition-all duration-300">
                        Marcar Evento
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif


        <div class="mt-6 px-10 sm:px-20">
            {{ $fields->links() }}
        </div>
    </div>

    @include('home.footer')
</body>
