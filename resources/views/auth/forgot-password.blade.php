@include('home.css')

@include('home.header')

<div class="flex items-center justify-center min-h-screen  overflow-hidden">
    <div class="bg-white p-10 rounded-lg w-full max-w-sm transition-transform transform hover:scale-105">
        <div class="flex items-center mb-6">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-14 mr-3">
            <h1 class="text-4xl  text-gray-700">QuickMatch</h1>
        </div>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Esqueceu sua palavra-passe? Sem problemas. Após inserir o seu email, irá ser enviado um link para repor a sua palavra-passe.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 h-12 pl-3" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('Email') }}" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button style="background-color: #3B82F6; color: white;" class="hover:bg-blue-600 focus:ring focus:ring-blue-300 transition duration-300 w-full h-12">
                    {{ __('Recuperar a tua palavra-passe') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

@include('home.footer')
