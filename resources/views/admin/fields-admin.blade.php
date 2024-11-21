@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Gestão de Campos</h1>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">ID</th>
                            <th class="px-6 py-3 text-left font-semibold">Nome do Campo</th>
                            <th class="px-6 py-3 text-left font-semibold">Tipo</th>
                            <th class="px-6 py-3 text-left font-semibold">Data de Criação</th>
                            <th class="px-6 py-3 text-center font-semibold">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fields as $field)
                            <tr class="border-t hover:bg-gray-100">
                                <td class="px-6 py-3">{{ $field->id }}</td>
                                <td class="px-6 py-3">{{ $field->name }}</td>
                                <td class="px-6 py-3">{{ $field->type }}</td> <!-- Tipo de campo -->
                                <td class="px-6 py-3">{{ $field->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-center">
                                    <a href="#modal-{{ $field->id }}" class="text-blue-500 hover:underline">Ver</a> | 
                                    <a href="{{ route('fields.edit', $field->id) }}" class="text-yellow-500 hover:text-yellow-600">Editar</a> | 
                                    <form action="{{ route('fields.destroy', $field->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">Apagar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach($fields as $field)
            <div id="modal-{{ $field->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h2 class="text-lg font-bold mb-4">Detalhes do Campo</h2>
                    <p><strong>ID:</strong> {{ $field->id }}</p>
                    <p><strong>Nome:</strong> {{ $field->name }}</p>
                    <p><strong>Tipo:</strong> {{ $field->type }}</p>
                    <p><strong>Data de Criação:</strong> {{ $field->created_at->format('d/m/Y') }}</p>
                    <button onclick="this.closest('.modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                        Fechar
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    @include('admin.footer')
</body>
</html>
