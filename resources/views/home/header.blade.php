<header class="bg-gray-200 py-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-2xl font-bold flex items-center space-x-2">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-20">
        </div>
        <nav class="flex space-x-6">
            <a href="#" class="text-gray-700 hover:text-gray-900 transition duration-300">Jogar</a>
            <a href="#" class="text-gray-700 hover:text-gray-900 transition duration-300">Campos</a>
            <a href="#" class="text-gray-700 hover:text-gray-900 transition duration-300">Roleta</a>
            <a href="#" class="text-gray-700 hover:text-gray-900 transition duration-300">Contactos</a>
            <a href="{{url('/login')}}" class="text-gray-700 hover:text-gray-900 transition duration-300">Iniciar Sessão</a>
            <a href="{{url('/register')}}" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition duration-300 shadow-lg">Começar</a>
        </nav>
    </div>
</header>
