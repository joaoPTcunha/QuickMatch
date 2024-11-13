@include('home.css')
@include('home.header')

<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex-grow max-w-4xl mx-auto p-4">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">{{ $field->name }}</h1>    
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Imagem ajustada e com efeito de borda arredondada e sombra -->
            <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}"  class="w-full h-64 object-contain mb-4 rounded-lg">
            
            <!-- Conteúdo do card -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <p class="text-lg text-gray-700"><strong>Descrição:</strong> {{ $field->description }}</p>
                    <p class="text-lg text-gray-700"><strong>Localização:</strong> {{ $field->location }}</p>
                    <p class="text-lg text-gray-700"><strong>Preço:</strong> {{ $field->price }}€</p>
                    <p class="text-lg text-gray-700"><strong>Contacto:</strong> {{ $field->contact }}</p>
                    <p class="text-lg text-gray-700"><strong>Modalidades:</strong> {{ $field->modality }}</p>
                </div>
                <div class="space-y-4">
                    <p class="text-lg text-gray-700"><strong>Nome do Dono do Campo:</strong> {{ $field->user->user_name }}</p>
                    <p class="text-lg text-gray-700"><strong>Email do Dono do Campo:</strong> {{ $field->user->email }}</p>
                    <p class="text-lg text-gray-700"><strong>Número do Dono do Campo:</strong> {{ $field->user->phone }}</p>
                </div>
            </div>

            <!-- Botão de Voltar -->
            <div class="p-6">
                <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700">Voltar</a>
            </div>
        </div>
    </div>
    
    @include('home.footer')
</body>
</html>
