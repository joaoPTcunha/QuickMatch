@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow p-6">
        <div class="flex justify-end mb-4">
            <a href="{{ route('add.field') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Adicionar Campo
            </a>
        </div>

        <!-- Lista de Campos -->
        <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-xl font-semibold mb-4">Meus Campos</h2>
            @if($fields->isEmpty())
                <p class="text-gray-500">Nenhum campo disponível.</p>
            @else
                <ul>
                    @foreach($fields as $field)
                        <li class="p-2 border-b">{{ $field->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    @include('home.footer')
</body>
</html>
