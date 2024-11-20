@include('home.css')
@include('home.header')

<body class="min-h-screen bg-gray-100 font-sans">
    <main class="flex items-center justify-center flex-grow px-5">
        <div class="bg-white shadow-md p-10 rounded-lg w-full max-w-2xl transform hover:scale-105 transition-transform">
            <div class="text-center mb-6">
                <h2 class="text-4xl font-semibold text-gray-800">Criar Conta</h2>
            </div>
            <x-auth-session-status class="mb-4 text-sm text-gray-600" :status="session('status')" />
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-text-input id="name" class="w-full border border-gray-300 rounded-md focus:ring-blue-500 h-10 px-3 text-sm"
                            type="text" name="name" :value="old('name')" required autofocus placeholder="Nome" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-500" />
                    </div>
                    <div>
                        <x-text-input id="surname" class="w-full border border-gray-300 rounded-md focus:ring-blue-500 h-10 px-3 text-sm"
                            type="text" name="surname" :value="old('surname')" required placeholder="Sobrenome" />
                        <x-input-error :messages="$errors->get('surname')" class="mt-1 text-xs text-red-500" />
                    </div>
                </div>
                <div class="mb-4">
                    <x-text-input id="user_name" class="w-full border border-gray-300 rounded-md focus:ring-blue-500 h-10 px-3 text-sm"
                        type="text" name="user_name" :value="old('user_name')" required placeholder="Nome de Utilizador" />
                    <x-input-error :messages="$errors->get('user_name')" class="mt-1 text-xs text-red-500" />
                </div>
                <div class="mb-4">
                    <x-text-input id="email" class="w-full border border-gray-300 rounded-md focus:ring-blue-500 h-10 px-3 text-sm"
                        type="email" name="email" :value="old('email')" required placeholder="Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
                </div>
                <div class="mb-4">
                    <x-text-input id="password" class="w-full border border-gray-300 rounded-md focus:ring-blue-500 h-10 px-3 text-sm"
                        type="password" name="password" required placeholder="Palavra-passe" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
                </div>
                <div class="mb-4">
                    <x-text-input id="password_confirmation" class="w-full border border-gray-300 rounded-md focus:ring-blue-500 h-10 px-3 text-sm"
                        type="password" name="password_confirmation" required placeholder="Confirmar Palavra-passe" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
                </div>
                <div class="mb-6">
                    <x-primary-button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md transition">
                        {{ __('Criar Conta') }}
                    </x-primary-button>
                </div>
                <p class="text-center text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                        {{ __('Já tem uma conta? Iniciar Sessão') }}
                    </a>
                </p>
                <hr class="my-6 border-gray-300">
                <div class="w-full bg-gray-100 text-gray-800 py-2 text-sm rounded-md hover:bg-gray-200 flex items-center justify-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48" class="mr-2">
                        <path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        <path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                        <path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                        <path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                    </svg>
                    Entrar com o Google
                </div>
            </form>
        </div>
    </main>
    @include('home.footer')
</body>
