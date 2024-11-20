
@include('home.header')
@include('home.css')
<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Criar um Evento</h1>
            <form action="{{ route('store.event') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="field_id" value="{{ $field->id }}">
                <div class="mb-4">
                    <label for="campo" class="block text-gray-700">Nome do Campo</label>
                    <p class="mt-2 p-2 border rounded">{{ $field->name }}</p>
                </div>
            
                <div class="mb-6 text-center">
                    <a href="{{ url('/field') }}" class="inline-block text-blue-700 px-6 py-2 rounded">
                        Procurar por outro campo
                    </a>
                </div>
            
                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" class="w-full mt-2 p-2 border rounded" placeholder="Descrição do evento"></textarea>
                </div>
            
                <div class="mb-4">
                    <label for="date-time" class="block text-gray-700">Data e Hora</label>
                    <input type="datetime-local" id="date-time" name="date-time" class="w-full mt-2 p-2 border rounded" value="{{ now()->addDay()->startOfDay()->format('Y-m-d\TH:i') }}">
                </div>
            
                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Preço Total (€)</label>
                    <p id="price" class="w-full mt-2 p-2 border rounded text-gray-600">{{ $field->price }} €</p>
                </div>
            
                <div class="mb-4">
                    <label for="modality" class="block text-gray-700">Modalidade</label>
                    <select id="modality" name="modality" class="w-full mt-2 p-2 border rounded">
                        @foreach ($modalities as $modality)
                            <option value="{{ $modality }}" {{ $field->modality == $modality ? 'selected' : '' }}>
                                {{ $modality }}
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <div class="mb-4 flex items-center">
                    <label for="num-participantes" class="block text-gray-700 mr-4">Número de Participantes</label>
                    <input type="number" id="num-participantes" name="num_participantes" class="w-20 p-2 border rounded" value="5">
                    <span class="ml-2"></span>
                </div>
            
                <div class="text-right">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                        Publicar Evento
                    </button>
                </div>
            </form>            
        </div>
    </div>

    @include('home.footer')
</body>
</html>
