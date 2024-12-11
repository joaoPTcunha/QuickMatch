@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8 px-4">
            <h1 class="text-4xl font-semibold text-center text-gray-900 mb-10">Gestão de Utilizadores</h1>
            <div class="flex items-center justify-between mb-8 flex-wrap">
                <form action="{{ route('admin.user-search') }}" method="GET" class="flex w-full md:max-w-lg space-x-2 mb-4 md:mb-0">
                    <input type="search" name="search" placeholder="Pesquisar utilizadores..."
                        class="border border-gray-300 rounded-l-md px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none shadow-sm">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r-md hover:bg-blue-700 transition shadow-md">
                        Pesquisar
                    </button>
                </form>

                <div class="relative inline-block text-left">
                    <button id="dropdownButton" type="button" class="px-6 py-2 bg-blue-600 hover:bg-blue-400 text-white rounded-md transition shadow-sm inline-flex items-center">
                        <span id="dropdownLabel" class="mr-2">Tipo de utlizador</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>


                    <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                        <form action="{{ route('admin.user-search') }}" method="GET" class="dropdown-option">
                            <input type="hidden" name="usertype">
                            <button type="submit" data-label="Todos" class="w-full block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100">
                                Todos
                            </button>
                        </form>
                        <form action="{{ route('admin.user-search') }}" method="GET" class="dropdown-option">
                            <input type="hidden" name="usertype" value="user">
                            <button type="submit" data-label="Utilizador" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Utilizador
                            </button>
                        </form>
                        <form action="{{ route('admin.user-search') }}" method="GET" class="dropdown-option">
                            <input type="hidden" name="usertype" value="user_field">
                            <button type="submit" data-label="Utilizador Campo" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Utilizador Campo
                            </button>
                        </form>
                        <form action="{{ route('admin.user-search') }}" method="GET" class="dropdown-option">
                            <input type="hidden" name="usertype" value="admin">
                            <button type="submit" data-label="Admin" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Admin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold w-24">Foto</th>
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
                            <td class="px-3 py-4 w-24">
                                @if($user->profile_picture)
                                <img src="{{ asset('Profile_Photo/' . $user->profile_picture) }}"
                                    alt="Foto de perfil de {{ $user->name }}"
                                    class="w-16 h-16 rounded-full border-2 shadow-md">
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-16 h-16 text-gray-400 border-2 rounded-full p-2 shadow-md">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                @endif
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->usertype }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="javascript:void(0);" class="text-blue-500 hover:underline" onclick="openModal('modal-{{ $user->id }}')">Ver mais</a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-4">
                                    <a href="javascript:void(0);" class="text-yellow-500 hover:text-yellow-600" onclick="openEditModal('edit-modal-{{ $user->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <form id="delete-user-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteUser({{ $user->id }})" class="text-red-500 hover:text-red-600">
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

            <!-- modal ver -->
            @foreach($users as $user)
            <div id="modal-{{ $user->id }}" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-50 opacity-0 pointer-events-none flex items-center justify-center transition-opacity duration-300 px-2">
                <div class="bg-white p-8 rounded-lg shadow-xl max-w-md w-full relative">
                    <button onclick="closeModal('modal-{{ $user->id }}')"
                        class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Detalhes do Utilizador</h2>

                    <div class="flex justify-center mb-4">
                        @if($user->profile_picture)
                        <img src="{{ asset('Profile_Photo/' . $user->profile_picture) }}"
                            alt="Foto de perfil de {{ $user->name }}"
                            class="w-24 h-24 rounded-full shadow-md">
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-24 h-24 text-gray-400 rounded-full p-2 shadow-md">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        @endif
                    </div>
                    <p class="mb-2"><strong>Nome:</strong> {{ $user->name }}</p>
                    <p class="mb-2"><strong>Sobrenome:</strong> {{ $user->surname ?? 'NULL' }}</p>
                    <p class="mb-2"><strong>Nome de Utilizador:</strong> {{ $user->user_name ?? 'NULL' }}</p>
                    <p class="mb-2"><strong>Data de Nascimento:</strong> {{ $user->date_birth ?? 'NULL' }}</p>
                    <p class="mb-2"><strong>Genero:</strong> {{ $user->gender ?? 'NULL' }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="mb-2"><strong>Telefone:</strong> {{ $user->phone ?? 'NULL' }}</p>
                    <p class="mb-2"><strong>Endereço:</strong> {{ $user->address ?? 'NULL' }}</p>
                    <p><strong>Tipo de Utilizador:</strong> {{ $user->usertype }}</p>
                </div>
            </div>

            <!-- modal editar -->
            <div id="edit-modal-{{ $user->id }}"
                class="fixed inset-0 z-50 bg-gray-800 bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0 pointer-events-none px-3 mt-3">
                <div class="bg-white p-8 rounded-lg shadow-xl max-w-4xl w-full relative overflow-auto max-h-screen sm:px-6">
                    <button onclick="closeModal('edit-modal-{{ $user->id }}')"
                        class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Editar Utilizador</h2>
                    <div class="flex flex-col items-center mb-8">
                        <div class="w-32 h-32 mb-4 flex items-center justify-center bg-gray-200 rounded-full overflow-hidden">
                            @if($user->profile_picture)
                            <img id="profile-preview-{{ $user->id }}" src="{{ asset('Profile_Photo/' . $user->profile_picture) }}" alt="Foto de perfil de {{ $user->name }}" class="w-full h-full object-cover">
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            @endif
                        </div>

                        @if($user->profile_picture)
                        <form id="delete-profile-picture-form-{{ $user->id }}" action="{{ route('users.ProfilePictureDelete', $user->id) }}" method="POST" data-user-name="{{ $user->name }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-800">Remover Imagem</button>
                        </form>
                        @endif
                    </div>


                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" autocomplete="on">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col space-y-6">
                                <div>
                                    <label for="adminEdit-{{ $user->id }}-name" class="block text-sm font-medium text-gray-700">Nome</label>
                                    <input type="text" id="adminEdit-{{ $user->id }}-name" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="name" required>
                                </div>

                                <div>
                                    <label for="adminEdit-{{ $user->id }}-surname" class="block text-sm font-medium text-gray-700">Sobrenome</label>
                                    <input type="text" id="adminEdit-{{ $user->id }}-surname" name="surname" value="{{ $user->surname }}" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="family-name">
                                </div>

                                <div>
                                    <label for="adminEdit-{{ $user->id }}-user_name" class="block text-sm font-medium text-gray-700">Nome de Utilizador</label>
                                    <input type="text" id="adminEdit-{{ $user->id }}-user_name" name="user_name" value="{{ $user->user_name }}" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="username">
                                </div>

                                <div>
                                    <label for="adminEdit-{{ $user->id }}-date_birth" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                                    <input type="date" id="adminEdit-{{ $user->id }}-date_birth" name="date_birth" value="{{ $user->date_birth }}" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="bday">
                                </div>

                                <div>
                                    <label for="adminEdit-{{ $user->id }}-gender" class="block text-sm font-medium text-gray-700">Gênero</label>
                                    <select name="gender" id="adminEdit-{{ $user->id }}-gender" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                                        <option value="Masculino" {{ $user->gender == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Feminino" {{ $user->gender == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                                        <option value="Outro" {{ $user->gender == 'Outro' ? 'selected' : '' }}>Outro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-6">
                                <div>
                                    <label for="adminEdit-{{ $user->id }}-email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="adminEdit-{{ $user->id }}-email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="email" required>
                                </div>

                                <div>
                                    <label for="adminEdit-{{ $user->id }}-phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                                    <input type="tel" id="adminEdit-{{ $user->id }}-phone" name="phone" value="{{ $user->phone }}" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="tel">
                                </div>

                                <div>
                                    <label for="adminEdit-{{ $user->id }}-address" class="block text-sm font-medium text-gray-700">Endereço</label>
                                    <input type="text" id="adminEdit-{{ $user->id }}-address" name="address" value="{{ $user->address }}" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="address-line1">
                                </div>

                                <div>
                                    <label for="adminEdit-{{ $user->id }}-usertype" class="block text-sm font-medium text-gray-700">Tipo de Utilizador</label>
                                    <select name="usertype" id="adminEdit-{{ $user->id }}-usertype" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                                        <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>Utilizador</option>
                                        <option value="user_field" {{ $user->usertype == 'user_field' ? 'selected' : '' }}>Utilizador Campo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</body>

@include('admin.footer')
<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.opacity = '1';
        modal.style.pointerEvents = 'auto';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
    }

    function openEditModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.opacity = '1';
            modal.style.pointerEvents = 'auto';
        } else {
            console.error(`Modal com ID '${modalId}' não encontrado.`);
        }
    }

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profile-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function confirmDeleteUser(userId) {
        const form = document.getElementById(`delete-user-form-${userId}`);

        Swal.fire({
            title: 'Tem a certeza que deseja apagar este utilizador?',
            text: "Esta ação não pode ser desfeita.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, apagar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    document.getElementById('dropdownButton').addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('hidden');
    });

    document.querySelectorAll('.dropdown-option button').forEach(option => {
        option.addEventListener('click', function(e) {
            const label = e.currentTarget.getAttribute('data-label');
            const dropdownLabel = document.getElementById('dropdownLabel');
            dropdownLabel.textContent = label;

            document.getElementById('dropdownMenu').classList.add('hidden');
        });
    });

    document.addEventListener('click', function(e) {
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });

    document.querySelectorAll('form[id^="delete-profile-picture-form-"]').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const userName = this.dataset.userName;
            Swal.fire({
                title: `Tem certeza que quer remover a foto de perfil de ${userName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, quero!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>