@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Gestão de Campos</h1>

            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <form action="{{ route('admin.fields.search') }}" method="GET" class="w-full sm:w-auto flex items-center space-x-4">
                    <input type="text" name="query" placeholder="Pesquisar..." class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-80" value="{{ request('query') }}">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pesquisar</button>
                </form>

                <form action="{{ route('admin.fields.search') }}" method="GET" class="flex items-center space-x-4">
                    <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2" onchange="this.form.submit()">
                        <option value="" disabled selected>Ordenar por</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Preço</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Data</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 px-10 sm:px-20">
                @foreach($fields as $field)
                <div class="flex flex-col bg-white p-4 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-center mb-4">
                        <label for="field_image_{{ $field->id }}">
                            <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-36 object-cover rounded-md shadow-md">
                        </label>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800 mb-2 text-center" id="field_name_{{ $field->id }}">{{ $field->name }}</h2>
                    <div class="text-gray-700 text-sm space-y-1 mb-4">
                        <p><strong>Localização:</strong> <span id="field_location_{{ $field->id }}">{{ $field->location }}</span></p>
                        <p><strong>Preço:</strong> <span id="field_price_{{ $field->id }}">{{ $field->price }}</span>€</p>
                        <p><strong>Modalidade(s):</strong> <span id="field_modality_{{ $field->id }}">{{ $field->modality }}</span></p>
                        <p><strong>Descrição:</strong> <span id="field_description_{{ $field->id }}">{{ $field->description }}</span></p>
                        <p><strong>Nome do Dono:</strong> <span id="field_owner_name_{{ $field->id }}">{{ $field->user->name }}</span></p>
                        <p><strong>Email do Dono:</strong> <span id="field_owner_email_{{ $field->id }}">{{ $field->user->email }}</span></p>
                        <p><strong>Contacto:</strong> <span id="field_contact_{{ $field->id }}">{{ $field->contact }}</span></p>

                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('fields.edit', $field->id) }}">
                            <button type="button" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                                Editar
                            </button>
                        </a>

                        <button type="button" data-field-id="{{ $field->id }}" onclick="confirmDelete(this)" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Apagar</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('admin.footer')

    <script>
        function confirmDelete(button) {
            const fieldId = button.getAttribute('data-field-id');
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Essa ação não pode ser desfeita!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, apagar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = `/fields/${fieldId}`;
                    form.method = 'POST';
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function removeImage(fieldId) {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você deseja remover apenas a imagem deste campo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, remover',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/fields/${fieldId}/remove-image`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        })
                        .then((response) => {
                            if (response.ok) {
                                document.getElementById('fieldImagePreview').src = '';
                                Swal.fire('Removido!', 'A imagem foi removida com sucesso.', 'success');
                            } else {
                                Swal.fire('Erro!', 'Ocorreu um erro ao remover a imagem.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Erro!', 'Ocorreu um erro ao remover a imagem.', 'error');
                        });
                }
            });
        }
    </script>
</body>