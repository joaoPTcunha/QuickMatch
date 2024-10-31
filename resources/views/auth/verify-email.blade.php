@include('home.css')

@include('home.header')

<div class="flex items-center justify-center min-h-screen bg-white overflow-hidden">
    <div class="bg-gray-200 p-10 rounded-lg shadow-lg w-full max-w-sm transition-transform transform hover:scale-105">
        <div class="flex items-center mb-6">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-14 mr-3">
            <h1 class="text-3xl font-bold text-gray-700">QuickMatch</h1>
        </div>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Obrigado por se registar! Antes de começar, verifique o seu endereço de e-mail clicando no link que enviamos para você. Caso não tenha recebido o e-mail, podemos enviar outro.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Um novo link de verificação foi enviado para o e-mail que forneceu durante o registo.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    {{ __('Reenviar e-mail de verificação') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Sair') }}
                </button>
            </form>
        </div>
    </div>
</div>

@include('home.footer')
