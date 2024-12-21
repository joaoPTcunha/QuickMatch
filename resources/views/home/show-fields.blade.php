@include('home.css')
@include('home.header')

<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex-grow max-w-4xl mx-auto p-4">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-6">{{ $field->name }}</h1>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-48 object-contain mb-4 mt-4 rounded-lg">

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <p class="text-lg text-gray-700"><strong>Descrição:</strong> {{ $field->description }}</p>
                    <p class="text-lg text-gray-700"><strong>Localização:</strong> {{ $field->location }}</p>
                    <p class="text-lg text-gray-700"><strong>Preço:</strong> {{ $field->price }}€/hora</p>
                </div>
                <div class="space-y-4">
                    <p class="text-lg text-gray-700"><strong>Email do Dono do Campo:</strong> {{ $field->user->email }}</p>
                    <p class="text-lg text-gray-700"><strong>Modalidades:</strong> {{ $field->modality }}</p>
                    <p class="text-lg text-gray-700"><strong>Contacto:</strong> {{ $field->contact }}</p>
                </div>
            </div>

            <div class="p-6 flex justify-between items-center">
                <!-- Botão de Voltar -->
                <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700">Voltar</a>

                <a href="{{ route('create-field', ['field_id' => $field->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                    Criar Evento com este campo
                </a>
            </div>
        </div>
    </div>

    @include('home.footer')
</body>

</html>