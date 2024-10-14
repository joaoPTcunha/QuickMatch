@include('home.css')

@include('home.header')

<div class="flex items-center justify-center min-h-screen bg-white overflow-hidden">
    <div class="bg-gray-200 p-10 rounded-lg shadow-lg w-full max-w-sm transition-transform transform hover:scale-105">
        <div class="flex items-center mb-6">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-14 mr-3">
            <h1 class="text-3xl font-bold text-gray-700">QuickMatch</h1>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Address -->
            <div class="mb-6">
                <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 h-12 pl-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" aria-label="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 h-12 pl-3" type="password" name="password" required autocomplete="current-password" placeholder="Palavra-passe" aria-label="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4 justify-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                </label>
                <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar-me') }}</span>
            </div>

            <div class="mb-6 text-center">
                <x-primary-button style="background-color: #3B82F6; color: white;" class="hover:bg-blue-600 focus:ring focus:ring-blue-300 transition duration-300 w-full h-12 flex items-center justify-center">
                    {{ __('Iniciar Sessão') }}
                </x-primary-button>
                <p class="mt-4 text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        {{ __('Esqueceu a palavra-passe?') }}
                    </a>
                </p>
            </div>

            <hr class="my-4 border-t border-gray-400">
            <div class="mt-4 text-center">
                <button type="button" class="mt-2 w-full bg-white text-black py-2 rounded-md hover:bg-gray-200 transition duration-300 flex items-center justify-center">
                    <img src="{{ asset('icons/google.png') }}" alt="Google Icon" class="h-4 mr-2">
                    Entrar com o Google
                </button>
                
                <a href="{{ url('/register') }}" class="mt-2 w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-500 transition duration-300 text-center flex items-center justify-center">
                Criar nova conta</a>
            </div>                
            
            <!--Botao testes -->
            <a href="{{ route('profile.complete') }}" class="mt-2 w-full bg-red-600 text-white py-2 rounded-md hover:bg-green-500 transition duration-300 text-center flex items-center justify-center">
    Testes
</a>
            </div>
        </form>
    </div>
</div>

@include('home.footer')
