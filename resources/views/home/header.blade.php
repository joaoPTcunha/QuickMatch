<header class="bg-gray-200 py-4 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-2xl flex items-center space-x-2">
        <a href="{{ route('index') }}">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-10"></a>
            <h1 class="text-4xl text-gray-800 drop-shadow-md">QuickMatch</h1>
        </div>
        <input type="checkbox" id="menu-toggle" class="hidden">
        <label for="menu-toggle" class="md:hidden flex items-center cursor-pointer">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </label>

        <nav class="hidden md:flex flex-col md:flex-row space-x-2"> <!-- Alterado de space-x-4 para space-x-2 -->
            <div class="relative group">
                @auth
                <div class="absolute hidden group-hover:block bg-white shadow-md mt-1 rounded">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Criar um evento</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ver eventos criados</a>
                </div>
                @endauth
            </div>
            <a href="{{url('/match')}}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Jogar</a>
            <a href="#" class="text-gray-700 hover:text-gray-900 px-2 py-2">Campos</a>
            <a href="{{url('/spinwheel')}}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Roleta</a>
            <a href="{{url('/contact')}}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Contactos</a>

            @guest
                <a href="{{ url('/login') }}" class="text-gray-700 hover:text-gray-900 px-4 py-2">Iniciar Sessão</a>
                <a href="{{ url('/register') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Começar</a>
            @endguest

            @auth
                <form action="{{ url('/logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Sair</button>
                </form>
            @endauth
        </nav>
    </div>
    <div class="md:hidden">
        <nav class="bg-gray-200" id="dropdown-menu">
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Jogar</label>
            @auth
            <div class="bg-white shadow-md mt-1 rounded">
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Opção 1</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Opção 2</a>
            </div>
            @endauth
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Campos</label>
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Roleta</label>
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Contactos</label>
            @guest
                <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Iniciar Sessão</label>
                <a href="{{ url('/register') }}" class="bg-blue-500 text-white block text-center px-4 py-2 rounded hover:bg-blue-600 mb-4">Começar</a>
            @endguest
            @auth
                <form action="{{ url('/logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white block w-full text-center px-4 py-2 rounded hover:bg-red-600">Sair</button>
                </form>
            @endauth
        </nav>
    </div>
</header>
