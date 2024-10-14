<main class="container mx-auto text-center py-4 flex-grow">
    <h1 class="text-4xl font-bold mb-4">Comunique. Colabore. Jogue.</h1>
    <p class="text-gray-700 mb-8">          
        Organize as suas partidas de vários desportos com facilidade e agilidade. Encontre os melhores campos perto de si!
    </p>
    <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300 shadow-lg">Começar agora</a>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16">
    <div class="bg-gray-200 p-6 rounded shadow text-center">
        <img src="{{ asset('icons/mapa.png') }}" alt="Mapa" class="h-16 mx-auto mb-4"> 
        <h2 class="text-xl font-semibold">Encontre Campos</h2>
        <p class="text-gray-600 mt-2">Navegue pela nossa lista de campos disponíveis e encontre o campo ideal perto de si.</p>
    </div>
    <div class="bg-gray-200 p-6 rounded shadow text-center">
        <img src="{{ asset('icons/calendario.png') }}" alt="Calendário" class="h-16 mx-auto mb-4">
        <h2 class="text-xl font-semibold">Organize Jogos</h2>
        <p class="text-gray-600 mt-2">Crie e organize partidas com os seus amigos de maneira simples e eficiente.</p>
    </div>
    <div class="bg-gray-200 p-6 rounded shadow text-center">
        <img src="{{ asset('icons/team-leader.png') }}" alt="Líder de Equipe" class="h-16 mx-auto mb-4"> 
        <h2 class="text-xl font-semibold">Encontre Outros Jogadores</h2>
        <p class="text-gray-600 mt-2">Conecte-se com jogadores da sua área que partilham a sua paixão pelo desporto.</p>
    </div>
    <div class="bg-gray-200 p-6 rounded shadow text-center">
        <img src="{{ asset('icons/user-plus.png') }}" alt="Adicionar Usuário" class="h-16 mx-auto mb-4">
        <h2 class="text-xl font-semibold">Registe-se Agora</h2>
        <p class="text-gray-600 mt-2">Crie a sua conta gratuitamente e tenha acesso a todos os recursos para gerir as suas partidas.</p>
    </div>
</div>

    <div class="mt-16">
        <h2 class="text-2xl font-bold mb-4">Pronto para jogar?</h2>
        <p class="text-gray-700 mb-6">Junte-se agora e reserve o seu campo preferido!</p>
        <a href="{{url('/register')}}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition duration-300 shadow-lg" >Registe-se!</a>
        </div>
</main>