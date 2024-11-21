<header class="py-4 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-4xl flex items-center space-x-2">
            <a href="{{ url('admin/index') }}" class="flex items-center space-x-2">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-10 px-3" />
                <h1 class="text-4xl text-gray-800 drop-shadow-md">QuickMatch</h1>
            </a>
        </div>
        <input type="checkbox" id="menu-toggle" class="hidden" />

        <label for="menu-toggle" class="md:hidden flex items-center cursor-pointer px-3">
            <div class="flex flex-col space-y-1">
                <div class="w-6 h-0.5 bg-gray-700"></div>
                <div class="w-6 h-0.5 bg-gray-700"></div>
                <div class="w-6 h-0.5 bg-gray-700"></div>
            </div>
        </label>

        <nav class="hidden md:flex md:flex-row md:space-x-3 md:items-center w-full md:w-auto">
            <a href="{{ url('admin/index') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Estatisticas</a>
            <a href="{{ url('/fields-admin') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Campos</a>
            <a href="{{ url('/user-management') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Gestão de Utilizadores</a>
            <a href="{{ url('/support') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Suporte ao Cliente</a>
            <a href="{{ url('/maintenance') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Manutenção</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="block px-4 py-2 text-red-700 hover:bg-red-500 hover:text-white w-full text-left rounded-md transition-all hover:rounded-xl">
                    Terminar Sessão
                </button>
            </form>
        </nav>
    </div>

    <!-- Telemóvel -->
    <div class="md:hidden">
        <div id="menu-items" class="flex-col space-y-2 p-2 hidden">
            <div class="relative ">
                <a href="{{ url('admin/index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Estatísticas</a>
                <a href="{{ url('/fields-admin') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Campos</a>
                <a href="{{ url('/user-management') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Gestão de Utilizadores</a>
                <a href="{{ url('/support') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Suporte ao Cliente</a>
                <a href="{{ url('/maintenance') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Manutenção</a>
            </div>
            <div class="relative">
                <button id="mobile-profile-dropdown-toggle" class="w-full text-left flex items-center justify-between text-gray-700 hover:text-gray-900 px-2 py-2">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Perfil
                    </span>
                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div id="mobile-profile-dropdown-content" class="hidden bg-white rounded-lg shadow-lg mt-2">
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="block px-4 py-2 text-red-700 hover:bg-red-500 hover:text-white w-full text-left">
                            Terminar Sessão
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</header>