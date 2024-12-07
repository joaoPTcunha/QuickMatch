@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-auto p-4">
        <h3 class="text-3xl font-semibold text-center mb-6">Meus Campos</h3>

        @if($fields->isEmpty())
        <div class="text-center py-4 px-6 bg-yellow-100 text-yellow-700 rounded-md shadow-md">
            <p>Ainda não tem campos registados</p>
        </div>
        @else
        <div class="flex justify-center">
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full max-w-6xl">
                @foreach($fields as $field)
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                    <div class="flex justify-center mb-4 p-3 pl-10 pr-4">
                        <label for="field_image_{{ $field->id }}" class="cursor-pointer">
                            <img src="{{ asset('Fields/' . $field->image) }}"
                                alt="{{ $field->name }}"
                                class="w-full h-36 object-cover rounded-md shadow-md cursor-pointer"
                                data-image-url="{{ asset('Fields/' . $field->image) }}">
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h4 class="text-xl font-semibold text-gray-800 text-center">{{ $field->name }}</h4>
                        <p class="text-gray-600">
                            <span class="font-bold">Localização:</span> {{ $field->location }}
                        </p>
                        <p class="text-gray-600">
                            <span class="font-bold">Custo:</span> {{ $field->price }}€/hora
                        </p>
                        <p class="text-gray-600">
                            <span class="font-bold">Tipo de desporto:</span> {{ $field->modality }}
                        </p>
                        <p class="text-gray-600">
                            <span class="font-bold">Contacto:</span> {{ $field->contact }} ({{ $field->user->name }})
                        </p>
                        <p class="text-gray-600">
                            <span class="font-bold">Descrição:</span> {{ $field->description }}
                        </p>
                        <div class=" flex justify-between mt-auto">
                            <a href="{{ route('edit-field', $field->id) }}"
                                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                                Editar
                            </a>

                            <form action="{{ route('delete-field', $field->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="confirmDelete(this)"
                                    class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                                    Apagar
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('create-field') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Adicionar Novo Campo
            </a>
        </div>
    </div>

    @include('home.footer')
</body>

</html>
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Tem a certeza?',
            text: "Esta ação não pode ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, apagar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>