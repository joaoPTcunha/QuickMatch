<section>
    <header>
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Informações do Perfil') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Atualize as informações do perfil e o endereço de e-mail da sua conta.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data" id="profile-form">
        @csrf
        @method('patch')
        <div class="flex flex-col items-center">
            <div id="profile-picture-preview">
                @if ($user->profile_picture)
                <img src="{{ asset('Profile_Photo/' . $user->profile_picture) }}" id="profile-picture" class="w-32 h-32 rounded-full object-cover shadow-md" alt="Profile image">
                @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32 text-gray-500" alt="Profile image">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                @endif
            </div>
            <label for="profile_picture" class="mt-4 inline-flex items-center px-6 py-2 text-blue-700 rounded-md cursor-pointer">
                Alterar Foto de Perfil
                <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(event)">
            </label>

            @if ($user->profile_picture)
            <label for="remove_profile_picture" class=" inline-flex items-center px-6 py-2 text-red-700 rounded-md cursor-pointer">
                Remover Foto de Perfil
                <input type="checkbox" id="remove_profile_picture" name="remove_profile_picture" class="hidden" value="1" onchange="toggleRemovePhoto()">
            </label>
            @endif
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Nome')" class="ml-2" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-sm pl-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="surname" :value="__('Sobrenome')" class="ml-2" />
                <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full rounded-sm pl-1" :value="old('surname', $user->surname)" autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('surname')" />
            </div>
        </div>

        <div>
            <x-input-label for="user_name" :value="__('Nome de utilizador')" class="ml-2" />
            <x-text-input id="user_name" name="user_name" type="text" class="mt-1 block w-full rounded-sm pl-1" :value="old('user_name', $user->user_name)" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('user_name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="ml-2" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full cursor-not-allowed rounded-sm pl-1" :value="$user->email" readonly autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="date_birth" :value="__('Data de Nascimento')" class="ml-2" />
                <x-text-input id="date_birth" name="date_birth" type="date" class="mt-1 block w-full rounded-sm pl-1" :value="old('date_birth', $user->date_birth)" autocomplete="bday" />
                <x-input-error class="mt-2" :messages="$errors->get('date_birth')" />
            </div>
            <div>
                <x-input-label for="gender" :value="__('Gênero')" class="ml-2" />
                <select id="gender" name="gender" class="mt-1 block w-full rounded-sm pl-1" autocomplete="gender">
                    <option value="Male" {{ old('gender', $user->gender) === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Female" {{ old('gender', $user->gender) === 'Feminino' ? 'selected' : '' }}>Feminino</option>
                    <option value="Other" {{ old('gender', $user->gender) === 'Outro' ? 'selected' : '' }}>Outro</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="phone" :value="__('Telefone')" class="ml-2" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-sm pl-1" :value="old('phone', $user->phone)" autocomplete="tel" maxlength="9" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="address" :value="__('Endereço')" class="ml-2" />
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full rounded-sm pl-1" :value="old('address', $user->address)" autocomplete="address-line1" />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <x-primary-button>
                {{ __('Guardar') }}
            </x-primary-button>
        </div>
    </form>
</section>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        const profilePicturePreview = document.getElementById('profile-picture-preview');

        reader.onload = function() {
            profilePicturePreview.innerHTML = `
            <img src="${reader.result}" id="profile-picture" class="w-32 h-32 rounded-full object-cover shadow-md" alt="Profile image">
        `;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            profilePicturePreview.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32 text-gray-500" alt="Profile image">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        `;
        }
    }

    function toggleRemovePhoto() {
        const removePhotoCheckbox = document.getElementById('remove_profile_picture');
        const profilePicturePreview = document.getElementById('profile-picture-preview');

        if (removePhotoCheckbox.checked) {
            profilePicturePreview.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32 text-gray-500" alt="Profile image">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        `;
        } else {
            const userImage = "{{ asset('Profile_Photo/' . $user->profile_picture) }}";
            profilePicturePreview.innerHTML = `
            <img src="${userImage}" id="profile-picture" class="w-32 h-32 rounded-full object-cover shadow-md" alt="Profile image">
        `;
        }
    }
</script>