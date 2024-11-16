@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Criar um evento</h1>
            <form action="{{ url('/create-event') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="categoria" class="block text-gray-700">Categoria</label>
                    <input type="text" id="categoria" name="categoria" class="w-full mt-2 p-2 border rounded" value="Futebol" readonly>
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" class="w-full mt-2 p-2 border rounded" placeholder="Descrição do evento">Mais 5 gajos para uma partida de futebol?</textarea>
                </div>

                <div class="mb-4">
                    <label for="data-hora" class="block text-gray-700">Data e Hora</label>
                    <input type="datetime-local" id="data-hora" name="data_hora" class="w-full mt-2 p-2 border rounded" value="2024-10-08T21:00">
                </div>

                <div class="mb-4">
                    <label for="campo" class="block text-gray-700">Selecione o campo</label>
                    <select id="campo" name="campo" class="w-full mt-2 p-2 border rounded">
                        <option value="{{ $field->name }}" selected>{{ $field->name }}</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="preco" class="block text-gray-700">Preço (€)</label>
                    <input type="number" id="preco" name="preco" class="w-full mt-2 p-2 border rounded" step="0.01" value="2.50">
                </div>

                <div class="mb-4 flex items-center">
                    <label for="num-participantes" class="block text-gray-700 mr-4">Número de Participantes</label>
                    <input type="number" id="num-participantes" name="num_participantes" class="w-20 p-2 border rounded" value="5">
                    <span class="ml-2">/ 22</span>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                        Publicar evento
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <a href="{{ url('/fields') }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition duration-200">
                    Procurar mais campos
                </a>
            </div>
        </div>
    </div>

    @include('home.footer')
</body>
</html>
