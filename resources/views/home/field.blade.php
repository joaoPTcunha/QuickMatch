@include('home.css')

@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-3xl text-center py-6 text-gray-800 font-bold">Lista de Campos</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4 px-20">
            @foreach($fields as $field)
                <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out">
                    <h2 class="text-xl font-semibold text-center text-gray-800 mb-2">{{ $field->name }}</h2>
                    <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-48 object-cover rounded-md mb-6">
                    <p class="text-gray-600 text-sm mb-4">Descrição:{{ $field->description }}</p>
                    <p class="text-gray-500 text-sm mb-4">Localização: {{ $field->location }}</p>
                    <p class="text-gray-700 font-semibold text-lg">Preço: {{ number_format($field->price, 2, ',', '.') }}</p>
                    
                    <a href="{{ url('/field/'.$field->id) }}" class="text-blue-500 hover:text-blue-700 font-medium mt-4 block">Ver mais</a>
                </div>
            @endforeach
        </div>
    </div>

    @include('home.footer')
</body>
</html>
