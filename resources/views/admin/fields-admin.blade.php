@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl sm:text-4xl text-center py-6 text-gray-800 font-semibold">Gestão de Campos</h1>

            <div class="mb-6">
                <form action="{{ route('admin.fields.search') }}" method="GET" class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <div class="flex w-full sm:w-auto">
                        <input type="text" name="query" placeholder="Pesquisar..." class="border border-gray-300 rounded-l-lg px-4 py-2 flex-grow text-sm" value="{{ request('query') }}">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg text-sm hover:bg-blue-600 transition whitespace-nowrap">Pesquisar</button>
                    </div>
                    <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full sm:w-auto mt-2 sm:mt-0" onchange="this.form.submit()">
                        <option value="" disabled {{ !request('sort') ? 'selected' : '' }}>Ordenar por</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Preço</option>
                        <option value="created_at" {{ request('sort') == 'created_at' && request('direction', 'desc') == 'desc' ? 'selected' : '' }}>Data mais recente</option>
                        <option value="created_at" {{ request('sort') == 'created_at' && request('direction') == 'asc' ? 'selected' : '' }}>Data mais antigo</option>
                    </select>
                    <input type="hidden" name="direction" value="{{ request('sort') == 'created_at' && request('direction', 'desc') == 'desc' ? 'asc' : 'desc' }}">
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fields as $field)
                <div class="event-card bg-white p-4 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-40 object-cover rounded-md shadow-md">
                    </div>

                    <h2 class="text-xl text-center font-bold text-gray-800 mb-2">{{ $field->name }}</h2>
                    <div class="text-gray-700 text-sm mb-4 space-y-1">
                        <p><span class="font-semibold">Localização:</span> {{ $field->location }}</p>
                        <p><span class="font-semibold">Preço:</span> {{ $field->price }} €</p>
                        <p><span class="font-semibold">Modalidade(s):</span> {{ $field->modality }}</p>
                        <p><span class="font-semibold">Descrição:</span> {{ Str::limit($field->description, 100) }}</p>
                        <p><span class="font-semibold">Nome do Dono:</span> {{ $field->user->name }}</p>
                        <p><span class="font-semibold">Email do Dono:</span> {{ $field->user->email }}</p>
                        <p><span class="font-semibold">Contacto:</span> {{ $field->contact }}</p>
                    </div>

                    <div class="mt-4 flex justify-center space-x-2">
                        <a href="{{ route('admin.fields-edit', $field->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-yellow-600 transition-all duration-300 text-sm">Editar</a>
                        <button type="button" data-field-id="{{ $field->id }}" onclick="confirmDelete(this)" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600 transition-all duration-300 text-sm">Apagar</button>
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