@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen">
    <main class="flex items-center justify-center flex-grow overflow-hidden ">
        <div class="bg-white p-10 rounded-lg shadow-lg w-full max-w-sm px-6 transition-transform transform hover:scale-105 mx-4 sm:mx-auto">
            <div class="flex justify-center mb-6">
                <h2 class="text-4xl font-semibold text-gray-800">Login</h2>
            </div>
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                    <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 h-12 pl-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" aria-label="Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-6 relative">
                    <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 h-12 pl-3 pr-10" type="password" name="password" required autocomplete="current-password" placeholder="Palavra-passe" aria-label="Password" />
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="flex items-center mb-4 justify-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    </label>
                    <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar-me') }}</span>
                </div>
                <div class="mb-6 text-center">
                    <x-primary-button
                        style="background-color: #3B82F6; color: white;"
                        class="hover:bg-blue-600 focus:ring focus:ring-blue-300 transition duration-300 w-full h-12 flex items-center justify-center">
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
                    <a href="{{ route('google-auth') }}" class="mt-2 w-full bg-gray-100 text-black py-2 rounded-md hover:bg-gray-200 transition duration-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="26" viewBox="0 0 48 48">
                            <path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                            <path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                            <path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                            <path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        </svg>
                        Entrar com o Google
                    </a>
                    <a href="{{ url('/register') }}" class="mt-2 w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-500 transition duration-300 text-center flex items-center justify-center">
                        Criar nova conta
                    </a>
                </div>
            </form>
        </div>
    </main>
    @include('home.footer')
    <script src="{{ url('js/login.js') }}"></script>
</body>