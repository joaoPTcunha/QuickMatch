@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight mb-4 text-center">
            {{ __('Editar Campo') }}
        </h2>
        <div class="p-6 bg-white shadow-md rounded-lg max-w-2xl mx-auto">
            <!-- Formulário de Edição -->
            <form action="{{ route('fields.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Indicando que é uma atualização -->

                <!-- Foto do Campo -->
                <div class="flex justify-center mb-4">
                    <label for="image" class="cursor-pointer">
                        <img id="avatar" src="{{ $field->image_url ?? 'https://via.placeholder.com/150' }}" alt="Avatar" class="w-full h-36 object-cover rounded-md mb-3">
                    </label>
                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                </div>
                <div class="text-center mb-4">
                    <label for="image" class="text-sm text-blue-600 hover:underline cursor-pointer">
                        Alterar foto do campo
                    </label>
                </div>

                <!-- Nome do Campo -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Campo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $field->name) }}" required class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nome do campo" />
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Descrição">{{ old('description', $field->description) }}</textarea>
                </div>

                <!-- Localização -->
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Localização</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $field->location) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Localização" />
                </div>

                <!-- Contato -->
                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contato</label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact', $field->contact) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contato" />
                </div>

                <!-- Preço -->
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço por Hora</label>
                    <input type="text" name="price" id="price" value="{{ old('price', $field->price) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Preço" />
                </div>

                <!-- Modalidades -->
                <div class="mb-4">
                    <label for="modality" class="block text-sm font-medium text-gray-700">Modalidades</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-2">
                        @foreach(['futebol', 'futebol 7', 'futsal', 'basquetebol', 'voleibol', 'andebol', 'ténis', 'raguebi', 'padel', 'outro'] as $modality)
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="{{ $modality }}"
                                {{ in_array($modality, explode(', ', $field->modality)) ? 'checked' : '' }}
                                class="mr-2"> {{ ucfirst($modality) }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Botão de Enviar -->
                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    Atualizar Campo
                </button>
            </form>
        </div>
    </div>

    @include('admin.footer')
</body>

</html>