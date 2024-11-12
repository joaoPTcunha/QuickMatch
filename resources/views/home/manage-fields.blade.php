@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-auto p-4">
        <h3 class="text-3xl font-semibold text-center mb-6">Meus Campos</h3>

        @if($fields->isEmpty())
            <div class="text-center py-4 px-6 bg-yellow-100 text-yellow-700 rounded-md shadow-md">
                <p>Ainda não tem campos registados</p>
            </div>
        @else
            <div class="flex justify-center">
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full max-w-6xl">
                    @foreach($fields as $field)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                            <img src="{{ asset('Fields/' . $field->image) }}" alt="Imagem do campo" class="w-full h-40 object-cover">
                            <div class="p-4 flex flex-col flex-grow">
                                <h4 class="text-xl font-semibold text-gray-800">{{ $field->name }}</h4>
                                <p class="text-gray-600">Localização:{{ $field->location }} </p>
                                <p class="text-gray-600">Custo: {{ $field->price }}€/hora</p>
                                <p class="text-gray-600">Tipo de desporto: {{ $field->modality }} </p>
                                <p class="text-gray-600">Contacto: {{ $field->contact }}</p>
                                <p class="text-gray-600">Descrição: {{ $field->description }}</p>

                                <div class="mt-4">
                                    <a href="{{ route('edit-fields', $field->id) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('create-fields') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Adicionar Novo Campo
            </a>
        </div>
    </div>

    @include('home.footer')
</body>
</html>
