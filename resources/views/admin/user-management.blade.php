@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Gestão de Utilizadores</h1>

            <div class="flex items-center mb-6">
                <!-- Formulário de pesquisa -->
                <form action="{{ route('admin.user-search') }}" method="GET" class="flex">
                    <input type="search" name="search" placeholder="Pesquisar utilizadores..." class="border px-4 py-2">
                    <button type="submit" class="border px-4 py-2 bg-blue-600 text-white ml-2">Pesquisar</button>
                </form>

                <!-- Botões de filtro alinhados à direita -->
                <div class="ml-auto flex space-x-2">
                    <form action="{{ route('admin.user-search') }}" method="GET">
                        <input type="hidden" name="usertype" value="user">
                        <button type="submit" class="border px-4 py-2 bg-gray-200 hover:bg-gray-300">Utilizador</button>
                    </form>
                    <form action="{{ route('admin.user-search') }}" method="GET">
                        <input type="hidden" name="usertype" value="user_field">
                        <button type="submit" class="border px-4 py-2 bg-gray-200 hover:bg-gray-300">Utilizador Campo</button>
                    </form>
                    <form action="{{ route('admin.user-search') }}" method="GET">
                        <input type="hidden" name="usertype" value="admin">
                        <button type="submit" class="border px-4 py-2 bg-gray-200 hover:bg-gray-300">Admin</button>
                    </form>
                </div>
            </div>

            <!-- Tabela de Utilizadores -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Nome</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Tipo de Utilizador</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Email</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Detalhes</th>
                            <th class="border px-4 py-2 bg-blue-600 text-white">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->usertype }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">
                                    <a href="#modal-{{ $user->id }}" class="text-blue-500 hover:underline">Ver -></a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:underline">
                                        <svg ...></svg>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline"><svg ...></svg></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modais para detalhes dos usuários -->
            @foreach($users as $user)
                <div id="modal-{{ $user->id }}" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden modal">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                        <h2 class="text-lg font-bold mb-4">Detalhes do Utilizador</h2>
                        <p><strong>Nome:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Tipo de Utilizador:</strong> {{ $user->usertype }}</p>
                        <a href="#" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-lg font-bold">&times;</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Paginação -->
    <div class="mt-4 flex justify-center">
        <div class="inline-flex rounded-md shadow">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>

    @include('admin.footer')
</body>

<style>
    .modal:target {
        display: flex;
    }
</style>
