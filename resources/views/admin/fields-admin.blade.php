@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-6 py-2">
            <h1 class="text-4xl text-center py-6 text-gray-800 font-semibold">Gestão de Campos</h1>

            <div class="mb-6 flex flex-col sm:flex-row justify-start items-start space-y-4 sm:space-y-0">
                <form action="{{ route('admin.fields.search') }}" method="GET" class="w-full sm:w-auto flex items-center space-x-2">
                    <input type="text" name="query" placeholder="Pesquisar..." class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-80 text-sm" value="{{ request('query') }}">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-600 transition">Pesquisar</button>
                </form>

                <form action="{{ route('admin.fields.search') }}" method="GET" class="flex items-center space-x-2 w-full sm:w-auto">
                    <input type="hidden" name="query" value="{{ request('query') }}">
                    <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full sm:w-auto" onchange="this.form.submit()">
                        <option value="" disabled {{ !request('sort') ? 'selected' : '' }}>Ordenar por</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Preço</option>
                        <option value="created_at" {{ request('sort') == 'created_at' && request('direction', 'desc') == 'desc' ? 'selected' : '' }}>Data mais recente</option>
                        <option value="created_at" {{ request('sort') == 'created_at' && request('direction') == 'asc' ? 'selected' : '' }}>Data mais antigo</option>
                    </select>
                    <input type="hidden" name="direction" value="{{ request('sort') == 'created_at' && request('direction', 'desc') == 'desc' ? 'asc' : 'desc' }}">
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-0 sm:p-0 lg:p-0 justify-start">
                @foreach($fields as $field)
                <div class="event-card flex flex-col bg-white p-6 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300 w-full">
                    <!-- Imagem -->
                    <div class="flex justify-start mb-4">
                        <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-40 object-cover rounded-md shadow-md">
                    </div>
            
                    <!-- Detalhes -->
                    <h2 class="text-xl text-center font-bold text-gray-800 mb-2">{{ $field->name }}</h2>
                    <div class="text-gray-700 text-sm mb-4 space-y-1">
                        <p><span class="font-semibold">Localização:</span> {{ $field->location }}</p>
                        <p><span class="font-semibold">Preço:</span> {{ $field->price }} €</p>
                        <p><span class="font-semibold">Modalidade(s):</span> {{ $field->modality }}</p>
                        <p><span class="font-semibold">Descrição:</span> {{ $field->description }}</p>
                        <p><span class="font-semibold">Nome do Dono:</span> {{ $field->user->name }}</p>
                        <p><span class="font-semibold">Email do Dono:</span> {{ $field->user->email }}</p>
                        <p><span class="font-semibold">Contacto:</span> {{ $field->contact }}</p>
                    </div>
            
                    <!-- Botões -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.fields-edit', $field->id) }}" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition-all duration-300">Editar</a>
                        <a type="button" data-field-id="{{ $field->id }}" onclick="confirmDelete(this)" class="inline-block bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600 transition-all duration-300">Apagar</a>
                    </div>
                </div>
                @endforeach
            </div>
            
            
            

            <div class="mt-6">
                {{ $fields->links() }}
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
    </script>
</body>
