@include('home.css')

@include('home.header')

<body class="bg-gray-100 flex flex-col min-h-screen">
    <main class="container mx-auto text-center py-12 flex-grow">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight mb-8">
            {{ __('Perfil') }}
        </h2>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Formulário de atualização de perfil -->
            <div class="p-6 bg-white shadow-md rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Formulário de atualização de senha -->
            <div class="p-6 bg-white shadow-md rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Formulário de exclusão de usuário -->
            <div class="p-6 bg-white shadow-md rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>

    @include('home.footer')
