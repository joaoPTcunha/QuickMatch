<header class="py-4 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-4xl flex items-center space-x-2">
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-10" />
                <h1 class="text-4xl text-gray-800 drop-shadow-md">QuickMatch</h1>
            </a>
    </div>
        <input type="checkbox" id="menu-toggle" class="hidden" />
        
        <label for="menu-toggle" class="md:hidden flex items-center cursor-pointer">
            <div class="flex flex-col space-y-1">
                <div class="w-6 h-0.5 bg-gray-700"></div>
                <div class="w-6 h-0.5 bg-gray-700"></div>
                <div class="w-6 h-0.5 bg-gray-700"></div>
            </div>
        </label>

        <nav class="hidden md:flex md:flex-row md:space-x-3 md:items-center w-full md:w-auto">
            <a href="{{ url('admin/index') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Estatisticas</a>
            <a href="{{ url('') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Campos</a>
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
    <!-- telemovel -->
    <div class="md:hidden">
        <div id="menu-items" class="hidden flex-col space-y-2 p-4 bg-gray-200">
            <a href="{{ url('admin/index') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2 w-full">Estatisticas</a>
            <a href="{{ url('/index') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2 w-full">Campos</a>
            <a href="{{ url('/user-management') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2 w-full">Gestão de Utilizadores</a>
            <a href="{{ url('/support') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2 w-full">Suporte ao Cliente</a>
            <a href="{{ url('/maintenance') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2 w-full">Manutenção</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg> 
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block px-2 py-2 text-red-700 hover:bg-red-500 hover:text-white w-full text-left rounded-md transition-all hover:rounded-bg">
                    Terminar Sessão
                </button>
            </form>
        </div>
    </div>
</header>
