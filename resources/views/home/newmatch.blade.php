@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow px-3">
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Criar um Evento</h1>
            <form action="{{ route('store.event') }}" method="POST">
                @csrf
                <input type="hidden" name="field_id" value="{{ $field->id ?? '' }}">
                <div class="mb-4">
                    <label for="campo" class="block text-gray-700">Nome do Campo</label>
                    <div class="flex items-center">
                        <input
                            type="text"
                            id="campo"
                            name="field_name"
                            class="w-full mt-2 p-2 border rounded"
                            placeholder="Adicione um campo ->"
                            value="{{ old('field_name', $field->name ?? '') }}"
                            required
                            readonly>
                        <a href="{{ route('field', ['from' => 'newmatch', 'redirect' => url()->current()]) }}"
                            class="ml-2 px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" class="w-full mt-2 p-2 border rounded" placeholder="Descrição do evento" required>{{ old('descricao') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="date-time" class="block text-gray-700">Data e Hora</label>
                    <input type="datetime-local" id="date-time" name="date-time" class="w-full mt-2 p-2 border rounded" value="{{ old('date-time', now()->addDay()->startOfDay()->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Preço Total (€)</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="w-full mt-2 p-2 border rounded"
                        placeholder="Preço do Evento"
                        value="{{ old('price', $field->price ?? '') }}"
                        min="0"
                        step="0.01"
                        required
                        readonly>
                </div>

                <div class="mb-4">
                    <label for="modality" class="block text-gray-700">Modalidade</label>
                    <select id="modality" name="modality" class="w-full mt-2 p-2 border rounded" required>
                        @foreach ($modalities as $modality)
                        <option value="{{ $modality }}" {{ (old('modality', $field->modality ?? '') == $modality) ? 'selected' : '' }}>
                            {{ $modality }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="participar" class="inline-flex items-center">
                        <input type="hidden" name="participar" value="0">
                        <input type="checkbox" id="participar" name="participar" class="form-checkbox h-5 w-5 text-blue-600" value="1" {{ old('participar') ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Participar neste evento</span>
                    </label>
                </div>


                <div class="mb-4 flex items-center">
                    <label for="num-participantes" class="block text-gray-700 mr-4">Número de Participantes</label>
                    <input type="number" id="num-participantes" name="num_participantes" class="w-20 p-2 border rounded" value="{{ old('num-participantes', 5) }}" min="1" required>
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