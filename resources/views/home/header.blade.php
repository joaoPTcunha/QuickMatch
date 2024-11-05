<header class="bg-gray-200 py-4 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-4xl flex items-center space-x-2">
            <a href="{{ url('/') }}">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-10" />
            </a>
        <h1 class="text-4xl text-gray-800 drop-shadow-md">QuickMatch</h1>
    </div>
        <input type="checkbox" id="menu-toggle" class="hidden" />
        <label for="menu-toggle" class="md:hidden flex items-center cursor-pointer">
            <div class="flex flex-col space-y-1">
                <div class="w-6 h-0.5 bg-gray-700"></div>
                <div class="w-6 h-0.5 bg-gray-700"></div>   
                <div class="w-6 h-0.5 bg-gray-700"></div>
            </div> 
        </label>
        <nav class="hidden md:flex md:flex-row md:space-x-2 md:items-center w-full md:w-auto">
            <div class="relative group">
                <a id="desktop-play-dropdown-toggle" class="text-gray-700 hover:text-gray-900 px-2 py-2 flex items-center cursor-pointer">
                    Jogar
                    <svg class="w-4 h-4 ml-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                    </svg>
                </a>
                <div class="absolute hidden group-hover:block bg-white shadow-md rounded" id="play-dropdown-content">
                    <a href="{{ url('/newmatch') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Criar um evento</a>
                    <a href="{{ url('/seematch') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ver eventos criados</a>
                </div>
            </div>
            <a href="{{ url('/field') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Campos</a>
            <a href="{{ url('/spinwheel') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Roleta</a>
            <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">Contactos</a>
            @guest
                <a href="{{ url('/login') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Iniciar Sessão</a>
            @else

            <a href="{{ url('/chat') }}" class="text-gray-700 hover:text-gray-900 px-2 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                </svg>
            </a>

                <div class="relative group">
                    <button id="desktop-profile-dropdown-toggle" class="text-gray-700 hover:text-gray-900 px-2 py-2 flex items-center">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="ml-2">Perfil</span>
                        <svg class="w-4 h-4 ml-1 text-gray-500 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div class="absolute right-0 hidden group-hover:block bg-white shadow-md rounded" id="profile-dropdown-content">
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ver Perfil</a>
                        <a href="{{ url('/help') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Central de Ajuda</a>

                        @if (auth()->check() && auth()->user()->usertype === 'user_field')
                        <a href="{{ url('/manage-fields') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Gerir campos</a>
                        @endif     
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-red-700 hover:bg-red-500 hover:text-white w-full text-left">
                                Terminar Sessão
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </nav>
    </div>






    <!-- Menu Mobile -->
    <div class="md:hidden">
        <div id="menu-items" class="flex-col space-y-2 p-4 bg-gray-200 hidden">
            <div class="relative">
                <button 
                    id="mobile-play-dropdown-toggle"
                    class="w-full text-left flex items-center justify-between text-gray-700 hover:text-gray-900 px-2 py-2"
                >
                    <span>Jogar</span>
                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                    </svg>
                </button>
                <div id="mobile-play-dropdown-content" class="hidden bg-white rounded-lg shadow-lg mt-2">
                    @auth
                        <a href="{{ url('/newmatch') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Criar um evento</a>
                        <a href="{{ url('/seematch') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ver eventos criados</a>
                    @endauth
                </div>
            </div>

            <a href="{{ url('/field') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2">Campos</a>
            <a href="{{ url('/spinwheel') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2">Roleta</a>
            <a href="{{ url('/contact') }}" class="block text-gray-700 hover:text-gray-900 px-2 py-2">Contactos</a>

            @guest
                <a href="{{ url('/login') }}" class="block bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-blue-green">Iniciar Sessão</a>
            @else

            <a href="{{ url('/chat') }}" class="flex items-center text-gray-700 hover:text-gray-900 px-2 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                </svg>
                <span>Chat</span>
            </a>

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
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ver Perfil</a>
                        <a href="{{ url('/help') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Central de Ajuda</a>

                        @if(auth()->check() && auth()->user()->user_type === 'user_field')
                            <a href="{{ url('/manage-fields') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Gerir campos</a>
                        @endif                  

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-red-700 hover:bg-red-500 hover:text-white w-full text-left">
                                Terminar Sessão
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>
