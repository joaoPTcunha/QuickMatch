@include('home.css')

<body class="bg-gray-100 flex flex-col min-h-screen">
    @include('home.header')

    <div class="flex-grow flex flex-col justify-start p-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-4">Finalizar Perfil</h1>
        
        <!-- Ícone do perfil -->
        <div class="flex justify-center mb-4">
            <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c3.866 0 7-3.134 7-7S15.866 0 12 0 5 3.134 5 7s3.134 7 7 7zm0 2c-4.418 0-8 1.79-8 4v1h16v-1c0-2.21-3.582-4-8-4z" />
                </svg>
            </div>
        </div>
        <p class="text-center text-gray-500 mb-8">Adicionar</p>

        <!-- Formulário -->
        <form action="{{ route('profile.complete') }}" method="POST" class="w-full max-w-md space-y-5 mx-auto">
            @csrf
            <div>
                <label for="nome" class="block text-sm font-semibold text-gray-700">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Insira o seu nome" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300" required>
            </div>
            <div>
                <label for="sobrenome" class="block text-sm font-semibold text-gray-700">Sobrenome</label>
                <input type="text" name="sobrenome" id="sobrenome" placeholder="Insira o seu sobrenome" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300" required>
            </div>
            <div>
                <label for="data_nascimento" class="block text-sm font-semibold text-gray-700">Data de Nascimento</label>
                <input type="date" name="data_nascimento" id="data_nascimento" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300" required>
            </div>
            <div>
                <label for="genero" class="block text-sm font-semibold text-gray-700">Género</label>
                <select name="genero" id="genero" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300" required>
                    <option value="" disabled selected>Selecione o seu género</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                </select>
            </div>
            <div>
                <label for="tipo_usuario" class="block text-sm font-semibold text-gray-700">Tipo de Utilizador</label>
                <select name="tipo_usuario" id="tipo_usuario" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300" required>
                    <option value="" disabled selected>Selecione o seu tipo de utilizador</option>
                    <option value="player">Jogador</option>
                    <option value="field_owner">Dono do Campo</option>
                </select>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="w-1/2 bg-green-500 text-white font-semibold p-3 rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-300">
                    Finalizar Perfil
                </button>
            </div>
        </form>
    </div>

    @include('home.footer')
</body>
