<section>
    <header>
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Informações do Perfil') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Atualize as informações do perfil e o endereço de e-mail da sua conta.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Nome e Sobrenome (em uma linha) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Nome')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="surname" :value="__('Sobrenome')" />
                <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('surname', $user->surname)" autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('surname')" />
            </div>
        </div>

        <div>
            <x-input-label for="user_name" :value="__('Nome de usuário')" />
            <x-text-input id="user_name" name="user_name" type="text" class="mt-1 block w-full" :value="old('user_name', $user->user_name)" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('user_name')" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="date_birth" :value="__('Data de Nascimento')" />
                <x-text-input id="date_birth" name="date_birth" type="date" class="mt-1 block w-full" :value="old('date_birth', $user->date_birth)" />
                <x-input-error class="mt-2" :messages="$errors->get('date_birth')" />
            </div>

            <div>
                <x-input-label for="gender" :value="__('Gênero')" />
                <select id="gender" name="gender" class="mt-1 block w-full">
                    <option value="Masculino" {{ old('gender', $user->gender) === 'Masculino' ? 'selected' : '' }}>
                        Masculino
                    </option>
                    <option value="Feminino" {{ old('gender', $user->gender) === 'Feminino' ? 'selected' : '' }}>
                        Feminino
                    </option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="phone" :value="__('Telefone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="address" :value="__('Endereço')" />
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
        </div>

        <div>
            <x-input-label for="profile_picture" :value="__('Foto de Perfil')" />
            <x-text-input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
