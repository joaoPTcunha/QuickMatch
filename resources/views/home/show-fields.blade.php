@include('home.css')
@include('home.header')

<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex-grow max-w-4xl mx-auto p-6">
        <!-- Título -->
        <h1 class="text-4xl font-semibold text-gray-800 text-center mb-6">{{ $field->name }}</h1>    

        <!-- Card com borda arredondada e sombra -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- Imagem com borda arredondada e efeito de hover -->
            <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-64 object-cover rounded-t-2xl mb-4 transition-transform transform hover:scale-105 hover:shadow-xl duration-300">

            <!-- Conteúdo do card com layout de duas colunas -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Informações do campo -->
                <div class="space-y-4">
                    <p class="text-lg text-gray-700"><strong>Descrição:</strong> {{ $field->description }}</p>
                    <p class="text-lg text-gray-700"><strong>Localização:</strong> {{ $field->location }}</p>
                    <p class="text-lg text-gray-700"><strong>Preço:</strong> {{ $field->price }}€</p>
                    <p class="text-lg text-gray-700"><strong>Contacto:</strong> {{ $field->contact }}</p>
                    <p class="text-lg text-gray-700"><strong>Modalidades:</strong> {{ $field->modality }}</p>
                </div>

                <!-- Informações do dono do campo -->
                <div class="space-y-4">
                    <p class="text-lg text-gray-700"><strong>Nome do Dono do Campo:</strong> {{ $field->user->user_name }}</p>
                    <p class="text-lg text-gray-700"><strong>Email do Dono do Campo:</strong> {{ $field->user->email }}</p>
                    <p class="text-lg text-gray-700"><strong>Número do Dono do Campo:</strong> {{ $field->user->phone }}</p>
                </div>
            </div>

            <!-- Botão de Voltar com borda arredondada e efeito hover -->
            <div class="p-6 text-center">
                <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700 hover:underline text-lg font-semibold">Voltar</a>
            </div>
        </div>
    </div>

    @include('home.footer')
</body>
</html>
