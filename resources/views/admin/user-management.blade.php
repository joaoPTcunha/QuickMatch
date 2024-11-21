@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8 px-4">
            <h1 class="text-4xl font-semibold text-center text-gray-900 mb-10">Gestão de Utilizadores</h1>
            <div class="flex items-center justify-between mb-8 flex-wrap">
                <!-- Formulário de Pesquisa -->
                <form action="{{ route('admin.user-search') }}" method="GET" class="flex w-full md:max-w-lg space-x-2 mb-4 md:mb-0">
                    <input type="search" name="search" placeholder="Pesquisar utilizadores..."
                        class="border border-gray-300 rounded-l-md px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none shadow-sm">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r-md hover:bg-blue-700 transition shadow-md">
                        Pesquisar
                    </button>
                </form>

                <div class="relative inline-block text-left">
                    <button id="dropdownButton" type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition shadow-sm inline-flex items-center">
                        <span class="mr-2">Todos</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                        <div class="py-1">
                            <form action="{{ route('admin.user-search') }}" method="GET">
                                <input type="hidden" name="usertype">
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Todos
                                </button>
                            </form>
                            <form action="{{ route('admin.user-search') }}" method="GET">
                                <input type="hidden" name="usertype" value="user">
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Utilizador
                                </button>
                            </form>
                            <form action="{{ route('admin.user-search') }}" method="GET">
                                <input type="hidden" name="usertype" value="user_field">
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Utilizador Campo
                                </button>
                            </form>
                            <form action="{{ route('admin.user-search') }}" method="GET">
                                <input type="hidden" name="usertype" value="admin">
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Admin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
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
                        <tr class="border-t hover:bg-gray-100 transition duration-200">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->usertype }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="javascript:void(0);" class="text-blue-500 hover:underline" onclick="openModal('modal-{{ $user->id }}')">Ver</a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-4">
                                    <a href="javascript:void(0);" class="text-yellow-500 hover:text-yellow-600" onclick="openEditModal('edit-modal-{{ $user->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach($users as $user)
            <!-- Modal de Detalhes -->
            <div id="modal-{{ $user->id }}" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Detalhes do Utilizador</h2>
                    <p><strong>Nome:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Tipo de Utilizador:</strong> {{ $user->usertype }}</p>
                    <button onclick="closeModal('modal-{{ $user->id }}')" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">Fechar</button>
                </div>
            </div>

            <!-- Modal de Edição -->
            <div id="edit-modal-{{ $user->id }}" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Editar Utilizador</h2>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm text-gray-700">Nome</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2 border rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="usertype" class="block text-sm text-gray-700">Tipo de Utilizador</label>
                            <select name="usertype" class="w-full px-4 py-2 border rounded-md shadow-sm" required>
                                <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>Utilizador</option>
                                <option value="user_field" {{ $user->usertype == 'user_field' ? 'selected' : '' }}>Utilizador Campo</option>
                            </select>
                        </div>
                        <div class="flex justify-between">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Salvar</button>
                            <button type="button" onclick="closeModal('edit-modal-{{ $user->id }}')" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Toggle dropdown visibility
        document.getElementById('dropdownButton').addEventListener('click', function() {
            const menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

@include('admin.footer')