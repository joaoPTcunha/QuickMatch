@include('home.css')
@include('home.header')

<body class="bg-gray-200 flex flex-col min-h-screen">
    <main class="container mx-auto px-4 py-6 flex-grow">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight mb-4 text-center">
            {{ __('Editar Campo: ' . $field->name) }}
        </h2>

        <!-- Formulário Compacto -->
        <div class="p-6 bg-white shadow-md rounded-lg max-w-2xl mx-auto">
            <form action="{{ route('update-fields', $field->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                <!-- Avatar de Imagem -->
                <div class="flex justify-center mb-4">
                    <label for="image" class="cursor-pointer">
                        <img id="avatar" src="{{ asset('Fields/' . $field->image) }}" alt="Avatar" class="w-32 h-32 object-cover border-4 border-gray-300 rounded-md">
                    </label>
                    <!-- Input hidden para escolher a foto -->
                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                </div>
                <!-- Texto de Instrução -->
                <div class="text-center mb-4">
                    <label for="image" class="text-sm text-blue-600 hover:underline cursor-pointer">
                        Alterar foto do campo
                    </label>
                </div>

                <!-- Campo Nome -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Campo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $field->name) }}" required class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o nome do campo" />
                </div>

                <!-- Campo Descrição -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Descrição">{{ old('description', $field->description) }}</textarea>
                </div>

                <!-- Campo Localização -->
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Localização</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $field->location) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Localização" />
                </div>

                <!-- Campo Contato -->
                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contato</label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact', $field->contact) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o contacto" />
                </div>

                <!-- Campo Preço -->
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço por Hora</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $field->price) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Insira o valor" />
                </div>

                <!-- Campo Modalidade -->
                <div class="mb-4">
                    <label for="modality" class="block text-sm font-medium text-gray-700">Modalidade</label>
                    <select name="modality" id="modality" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="futebol" {{ old('modality', $field->modality) == 'futebol' ? 'selected' : '' }}>Futebol</option>
                        <option value="futebol 7" {{ old('modality', $field->modality) == 'futebol 7' ? 'selected' : '' }}>Futebol 7</option>
                        <option value="futsal" {{ old('modality', $field->modality) == 'futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="basquetebol" {{ old('modality', $field->modality) == 'basquetebol' ? 'selected' : '' }}>Basquetebol</option>
                        <option value="voleibol" {{ old('modality', $field->modality) == 'voleibol' ? 'selected' : '' }}>Voleibol</option>
                        <option value="andebol" {{ old('modality', $field->modality) == 'andebol' ? 'selected' : '' }}>Andebol</option>
                        <option value="ténis" {{ old('modality', $field->modality) == 'ténis' ? 'selected' : '' }}>Ténis</option>
                        <option value="raguebi" {{ old('modality', $field->modality) == 'raguebi' ? 'selected' : '' }}>Raguebi</option>
                        <option value="padel" {{ old('modality', $field->modality) == 'padel' ? 'selected' : '' }}>Padel</option>
                        <option value="outro" {{ old('modality', $field->modality) == 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>

                <!-- Campo de Modalidade Personalizada (aparece quando 'Outro' é selecionado) -->
                <div id="otherModality" class="mb-4 hidden">
                    <label for="customModality" class="block text-sm font-medium text-gray-700">Qual a modalidade?</label>
                    <input type="text" name="customModality" id="customModality" value="{{ old('customModality') }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                </div>

                <!-- Botão de Enviar -->
                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    Atualizar Campo
                </button>
            </form>
        </div>
    </main>

    @include('home.footer')

    <script>
        // Exibe ou esconde o campo para digitar uma modalidade personalizada
        document.getElementById('modality').addEventListener('change', function() {
            const otherModalityField = document.getElementById('otherModality');
            if (this.value === 'outro') {
                otherModalityField.classList.remove('hidden');
            } else {
                otherModalityField.classList.add('hidden');
            }
        });

        // Funcionalidade de troca de foto de avatar
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
