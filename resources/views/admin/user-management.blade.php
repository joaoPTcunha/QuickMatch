@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Gestão de Utilizadores</h1>
            
            <form action="{{ route('admin.user-search') }}" method="GET" class="mb-6">
                <input type="search" name="search" placeholder="Pesquisar utilizadores..." class="border px-4 py-2">
                <button type="submit" class="border px-4 py-2 bg-blue-600 text-white">Pesquisar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2 bg-blue-600 text-white">ID</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Nome</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Tipo de Utilizador</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Detalhes</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="border px-4 py-2">{{ $user->id }}</td>
                                    <td class="border px-4 py-2">{{ $user->name }}</td>
                                    <td class="border px-4 py-2">{{ $user->usertype }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:underline">Ver -></a>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:underline">✏️</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Paginação -->
            <div class="mt-4 flex justify-center">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    
    @include('admin.footer')
</body>
</html>
