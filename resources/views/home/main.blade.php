<main class="container mx-auto text-center px-6 md:px-0 flex-grow mt-10">
    <h1 class="text-4xl font-bold mb-4">Queres fazer desporto mas não gostas de o fazer sozinho?</h1>
    <p class="text-gray-700 mb-8 text-m">
        A espera acabou! Através do QuickMatch, podes criar e participar nos eventos desportivos que mais te agradam, expandindo uma ampla comunidade de desporto e <br>
        facilitando a procura por pessoas que gostam de se exercitar assim como tu!
    </p>
    @auth
    <a href="{{ url('/events') }}" class="bg-blue-700 text-white text-m px-6 py-2 rounded-lg hover:bg-blue-500 transition duration-300 shadow-lg">Visitar os jogos ativos</a>
    @else
    <a href="{{ url('/login') }}" class="bg-blue-700 text-white text-m px-6 py-2 rounded-lg hover:bg-blue-500 transition duration-300 shadow-lg">Começar agora</a>
    @endauth
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16">
        <div class="bg-blue-300 p-6 rounded shadow text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-800" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
            </svg>
            <h2 class="text-xl font-semibold">Encontra Campos</h2>
            <p class="text-gray-600 mt-2">Procura pelo desporto que preferes e encontra o campo mais próximo de ti.</p>
        </div>
        <div class="bg-blue-200 p-6 rounded shadow text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-800" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            <h2 class="text-xl font-semibold">Organiza Jogos</h2>
            <p class="text-gray-600 mt-2">Cria e organiza jogos com os teus amigos de maneira simples e eficiente.</p>
        </div>
        <div class="bg-[#C1E1C1] p-6 rounded shadow text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-800" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>
            <h2 class="text-xl font-semibold">Encontra Outros Jogadores</h2>
            <p class="text-gray-600 mt-2">Conecta-te com jogadores da tua área que partilham a mesma paixão pelo desporto!</p>
        </div>
        <div class="bg-[#90EE90] p-6 rounded shadow text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 w-16 mx-auto mb-4 text-gray-800">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
            </svg>
            <h2 class="text-xl font-semibold">Exercita</h2>
            <p class="text-gray-600 mt-2">O nosso objetivo é atrair todos para o desporto e para exercitar com diversão!</p>
        </div>
    </div>

    <div class="mt-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-center">
            <div class="flex flex-col items-center text-gray-700">
                <h2 class="text-2xl font-bold text-center">Pronto para jogar?</h2>
                <p class="mb-4 text-center">A tua jornada desportiva começa aqui! Convida amigos e cria um evento agora mesmo!</p>
                @auth
                <a href="{{ url('/newmatch') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-400 transition duration-300 shadow-lg">Criar Evento</a>
                @else
                <a href="{{ url('/register') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-400 transition duration-300 shadow-lg">Registe-se!</a>
                @endauth
            </div>
            <div class="flex flex-col items-center text-gray-700">
                <h2 class="text-2xl font-bold text-center">Para donos de campos</h2>

                <p class="mb-4 text-center">Tem algum campo que dê para praticar modalidades? Registe o seu campo aqui!</p>
                @auth
                <a href="{{ url('/manage-fields') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-400 transition duration-300 shadow-lg">Registar Campo</a>
                @else
                <a href="{{ url('/register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-400 transition duration-300 shadow-lg">Registe-se!</a>
                @endauth
            </div>
        </div>
    </div>









</main>