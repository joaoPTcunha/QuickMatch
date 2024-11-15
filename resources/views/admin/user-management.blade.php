@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Gestão de Utilizadores</h1>

            <div class="flex items-center mb-6">
                <form action="{{ route('admin.user-search') }}" method="GET" class="flex w-full max-w-lg mx-auto">
                    <input type="search" name="search" placeholder="Pesquisar utilizadores..." class="border border-gray-300 rounded-l-md px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 transition">
                        Pesquisar
                    </button>
                </form>

                <div class="ml-auto flex space-x-2">
                    <form action="{{ route('admin.user-search') }}" method="GET">
                        <input type="hidden" name="usertype" value="user">
                        <button type="submit" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition">
                            Utilizador
                        </button>
                    </form>
                    <form action="{{ route('admin.user-search') }}" method="GET">
                        <input type="hidden" name="usertype" value="user_field">
                        <button type="submit" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition">
                            Utilizador Campo
                        </button>
                    </form>
                    <form action="{{ route('admin.user-search') }}" method="GET">
                        <input type="hidden" name="usertype" value="admin">
                        <button type="submit" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition">
                            Admin
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Nome</th>
                            <th class="px-6 py-3 text-left font-semibold">Tipo de Utilizador</th>
                            <th class="px-6 py-3 text-left font-semibold">Email</th>
                            <th class="px-6 py-3 text-center font-semibold">Detalhes</th>
                            <th class="px-6 py-3 text-center font-semibold">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-t hover:bg-gray-100">
                                <td class="px-6 py-3">{{ $user->name }}</td>
                                <td class="px-6 py-3">{{ $user->usertype }}</td>
                                <td class="px-6 py-3">{{ $user->email }}</td>
                                <td class="px-6 py-3 text-center">
                                    <a href="#modal-{{ $user->id }}" class="text-blue-500 hover:underline">Ver</a>
                                </td>
                                <td class="px-6 py-3 text-center flex justify-center space-x-4">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach($users as $user)
                <div id="modal-{{ $user->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                        <h2 class="text-lg font-bold mb-4">Detalhes do Utilizador</h2>
                        <p><strong>Nome:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Tipo de Utilizador:</strong> {{ $user->usertype }}</p>
                        <button onclick="this.closest('.modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                            Fechar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex justify-center mt-8">
        <div class="inline-flex rounded-md shadow">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>

    @include('admin.footer')
</body>
