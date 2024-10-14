<header class="bg-gray-200 py-4 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-2xl flex items-center space-x-2">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-10">
            <h1 class="text-4xl text-gray-800 drop-shadow-md">QuickMatch</h1>
        </div>
        <input type="checkbox" id="menu-toggle" class="hidden">
        <label for="menu-toggle" class="md:hidden flex items-center cursor-pointer">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </label>

        <nav class="hidden md:flex flex-col md:flex-row space-x-4">
            <a href="#" class="text-gray-700 hover:text-gray-900">Jogar</a>
            <a href="#" class="text-gray-700 hover:text-gray-900">Campos</a>
            <a href="#" class="text-gray-700 hover:text-gray-900">Roleta</a>
            <a href="#" class="text-gray-700 hover:text-gray-900">Contactos</a>
            <a href="{{url('/login')}}" class="text-gray-700 hover:text-gray-900">Iniciar Sessão</a>
            <a href="{{url('/register')}}" class="bg-blue-500 text-white px-4 py-1 rounded-lg hover:bg-blue-600">Começar</a>
        </nav>
    </div>
    <div class="md:hidden">
        <nav class="bg-gray-200" id="dropdown-menu">
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Jogar</label>
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Campos</label>
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Roleta</label>
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Contactos</label>
            <label for="menu-toggle" class="block text-gray-700 hover:text-gray-900 px-4 py-2 cursor-pointer">Iniciar Sessão</label>
            <a href="{{url('/register')}}" class="bg-blue-500 text-white block text-center px-4 py-2 rounded hover:bg-blue-600">Começar</a>
        </nav>
    </div>
</header>

