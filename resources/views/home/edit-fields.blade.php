@include('home.css')
@include('home.header')

<body class="bg-gray-200 flex flex-col min-h-screen">
    <main class="container mx-auto px-4 py-6 flex-grow">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight mb-4 text-center">
            {{ __('Editar Campo: ' . $field->name) }}
        </h2>

        <div class="p-6 bg-white shadow-md rounded-lg max-w-2xl mx-auto">
            <form action="{{ route('update-field', $field->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex justify-center mb-4">
                    <label for="image" class="cursor-pointer">
                        <img id="avatar" src="{{ asset('Fields/' . $field->image) }}" alt="Avatar" class="w-32 h-32 object-cover border-4 border-gray-300 rounded-md">
                    </label>
                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                </div>
                <div class="text-center mb-4">
                    <label for="image" class="text-sm text-blue-600 hover:underline cursor-pointer">
                        Alterar foto do campo
                    </label>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Campo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $field->name) }}" required class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o nome do campo" />
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Descrição">{{ old('description', $field->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Localização</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $field->location) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Localização" />
                </div>

                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contato</label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact', $field->contact) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o contacto" />
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço por Hora</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $field->price) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o valor" />
                </div>

                <div class="mb-4">
                    <label for="modality" class="block text-sm font-medium text-gray-700">Modalidades</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="futebol" class="mr-2"
                                {{ in_array('futebol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Futebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="futebol 7" class="mr-2"
                                {{ in_array('futebol 7', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Futebol 7
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="futsal" class="mr-2"
                                {{ in_array('futsal', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Futsal
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="basquetebol" class="mr-2"
                                {{ in_array('basquetebol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Basquetebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="voleibol" class="mr-2"
                                {{ in_array('voleibol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Voleibol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="andebol" class="mr-2"
                                {{ in_array('andebol', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Andebol
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="ténis" class="mr-2"
                                {{ in_array('ténis', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Ténis
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="raguebi" class="mr-2"
                                {{ in_array('raguebi', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Raguebi
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="padel" class="mr-2"
                                {{ in_array('padel', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Padel
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="outro" class="mr-2"
                                {{ in_array('outro', old('modality', explode(',', $field->modality))) ? 'checked' : '' }}> Outro
                        </label>
                    </div>

                    <!-- Campo Modalidade Personalizada (aparece quando 'Outro' é selecionado) -->
                    <div class="mb-4 {{ in_array('outro', old('modality', explode(',', $field->modality))) ? '' : 'hidden' }}">
                        <label for="customModality" class="block text-sm font-medium text-gray-700">Qual a modalidade?</label>
                        <input type="text" name="customModality" id="customModality" value="{{ old('customModality') }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <div id="otherModality" class="mb-4 hidden">
                    <label for="customModality" class="block text-sm font-medium text-gray-700">Qual a modalidade?</label>
                    <input type="text" name="customModality" id="customModality" value="{{ old('customModality') }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    Atualizar Campo
                </button>
            </form>
        </div>
    </main>

    @include('home.footer')

    <script>
        document.getElementById('modality').addEventListener('change', function() {
            const otherModalityField = document.getElementById('otherModality');
            if (this.value === 'outro') {
                otherModalityField.classList.remove('hidden');
            } else {
                otherModalityField.classList.add('hidden');
            }
        });

        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>