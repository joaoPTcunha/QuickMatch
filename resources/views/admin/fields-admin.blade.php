@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Gestão de Campos</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4 lg:px-20">
                @foreach($fields as $field)
                    <div class="bg-white p-4 rounded-md border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300 ease-in-out">
                        <div class="flex flex-col">
                            <div class="mb-4">
                                <p class="text-gray-700"><strong>ID:</strong> {{ $field->id }}</p>
                                <h2 class="text-xl font-bold text-gray-800">{{ $field->name }}</h2>
                                <p class="text-gray-700"><strong>Tipo:</strong> {{ $field->type }}</p>
                                <p class="text-gray-700"><strong>Data de Criação:</strong> {{ $field->created_at->format('d/m/Y') }}</p>
                            </div>
                            
                            <div class="mt-auto flex justify-between items-center">
                                <div class="space-x-2">
                                    <a href="#" onclick="openModal({{ $field->id }})" class="text-blue-500 hover:underline">Ver</a>
                                    <a href="{{ route('fields.edit', $field->id) }}" class="text-yellow-500 hover:text-yellow-600">Editar</a>
                                    <form action="{{ route('fields.destroy', $field->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">Apagar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        @foreach($fields as $field)
            <div id="modal-{{ $field->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                    <button onclick="closeModal({{ $field->id }})" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <h2 class="text-lg font-bold mb-4">Detalhes do Campo</h2>
                    <p><strong>ID:</strong> {{ $field->id }}</p>
                    <p><strong>Nome:</strong> {{ $field->name }}</p>
                    <p><strong>Tipo:</strong> {{ $field->type }}</p>
                    <p><strong>Data de Criação:</strong> {{ $field->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
    @include('admin.footer')
    
    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
            document.getElementById('modal-' + id).classList.add('flex');
        }
        
        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
            document.getElementById('modal-' + id).classList.remove('flex');
        }
    </script>
</body>
</html>