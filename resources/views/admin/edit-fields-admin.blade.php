@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight mb-4 text-center">
            Editar Campo
        </h2>
        <div class="p-6 bg-white shadow-md rounded-lg max-w-2xl mx-auto">

            <div class="flex justify-center mb-4">
                <label for="image">
                    <img id="avatar" src="{{ $field->image ? asset('Fields/' . $field->image) : 'https://via.placeholder.com/150' }}"
                        alt="Avatar" class="w-full h-36 object-cover rounded-md mb-3">
                </label>
            </div>

            <form action="{{ route('fields.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Campo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $field->name) }}" required class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nome do campo" />
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
                    <input type="text" name="contact" id="contact" value="{{ old('contact', $field->contact) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contato" />
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço por Hora</label>
                    <input type="text" name="price" id="price" value="{{ old('price', $field->price) }}" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Preço" />
                </div>

                <div class="mb-4">
                    <label for="modality" class="block text-sm font-medium text-gray-700">Modalidades</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-2">
                        <!-- recupera modalidades e remove os espacos -->
                        @php
                        $selectedModalities = array_map('trim', explode(',', $field->modality));
                        @endphp
                        @foreach(['futebol', 'futebol 7', 'futsal', 'basquetebol', 'voleibol', 'andebol', 'ténis', 'raguebi', 'padel', 'outro'] as $modality)
                        <label class="flex items-center">
                            <input type="checkbox" name="modality[]" value="{{ $modality }}" class="mr-2"
                                {{ in_array($modality, old('modality', $selectedModalities)) ? 'checked' : '' }}>
                            {{ ucfirst($modality) }}
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
    <script>
        document.getElementById('remove-image-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Essa ação não pode ser desfeita!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, remover!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('remove-image-form').submit();
                }
            });
        });
    </script>
</body>

</html>