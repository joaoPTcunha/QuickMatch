<section class="space-y-1">
    <header>
        <h2 class="text-lg font-medium text-gray-900 mt-5">
            {{ __('Eliminar Conta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Uma vez que a sua conta seja eliminada, todos os recursos, dados e informações associados serão permanentemente apagados e não poderão ser recuperados. Certifique-se de que faz o download de quaisquer dados importantes que deseje guardar antes de prosseguir com esta ação irreversível.') }}
        </p>
    </header>

    <div class="w-full flex justify-end gap-4">
        <x-danger-button
            x-data="{}"
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md ml-0 mt-3">
            {{ __('Eliminar Conta') }}
        </x-danger-button>
    </div>


    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Tem a certeza de que deseja eliminar a sua conta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Uma vez que a sua conta for eliminada, todos os recursos e dados serão permanentemente apagados. Por favor, insira a sua palavra-passe para confirmar que deseja eliminar a conta de forma permanente.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Palavra-passe') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Palavra-passe') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Eliminar Conta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>