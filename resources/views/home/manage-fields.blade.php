@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container sm:px-6 lg:px-8 py-6">
        <h3 class="text-4xl font-semibold text-center mb-8 text-gray-800">Meus Campos</h3>

        @if($fields->isEmpty())
        <div class="text-center py-4 px-6 bg-yellow-100 text-yellow-700 rounded-md shadow-md">
            <p>Ainda não tem campos registados</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($fields as $field)
            <div class="flex flex-col bg-white rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300">
                <!-- Imagem -->
                <div class="flex justify-center mb-4">
                    <label for="field_image_{{ $field->id }}" class="block w-full p-5">
                        <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-40 object-cover rounded-md shadow-md">
                    </label>
                </div>
                <!-- Informações do Campo -->
                <div class="p-6 flex flex-col flex-grow">
                    <h4 class="text-lg font-bold text-gray-800 text-center mb-2">{{ $field->name }}</h4>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Localização:</span> {{ $field->location }}</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Custo:</span> {{ $field->price }}€/hora</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Tipo de desporto:</span> {{ $field->modality }}</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Contacto:</span> {{ $field->contact }} ({{ $field->user->name }})</p>
                    <p class="text-sm text-gray-700 mb-1"><span class="font-semibold">Descrição:</span> {{ $field->description }}</p>

                    <!-- Disponibilidade -->
                    @if($field->availability)
                        <div class="text-sm text-gray-700 mb-4">
                            <span class="font-semibold">Disponibilidade:</span>
                            <ul class="list-inside list-disc space-y-1 mt-1">
                                @php
                                    // Decodificando a disponibilidade do campo
                                    $availabilitySlots = json_decode($field->availability, true);

                                    // Mapeamento dos dias para português
                                    $dayTranslations = [
                                        'monday' => 'Segundas-feiras',
                                        'tuesday' => 'Terças-feiras',
                                        'wednesday' => 'Quartas-feiras',
                                        'thursday' => 'Quintas-feiras',
                                        'friday' => 'Sextas-feiras',
                                        'saturday' => 'Sábados',
                                        'sunday' => 'Domingos',
                                    ];
                                @endphp
                                
                                @if(is_array($availabilitySlots) && count($availabilitySlots) > 0)
                                    @foreach($availabilitySlots as $day => $times)
                                        @if(is_array($times))
                                            <li>
                                                <span class="font-semibold">{{ ucfirst($dayTranslations[$day] ?? $day) }}:</span>
                                                
                                                @if(count($times) == 1)
                                                    <!-- Caso exista apenas um horário, mostramos diretamente -->
                                                    @php
                                                        $startTime = data_get($times[0], 'start', 'Indefinido');
                                                        $endTime = data_get($times[0], 'end', 'Indefinido');
                                                    @endphp
                                                    <span>{{ $startTime }} - {{ $endTime }}</span>
                                                @else
                                                    <!-- Caso exista mais de um horário, iteramos sobre eles -->
                                                    @foreach($times as $time)
                                                        @php
                                                            $startTime = data_get($time, 'start', 'Indefinido');
                                                            $endTime = data_get($time, 'end', 'Indefinido');
                                                        @endphp
                                                        <span>{{ $startTime }} - {{ $endTime }}</span>
                                                        @if(!$loop->last), @endif
                                                    @endforeach
                                                @endif
                                                
                                            </li>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-700 mb-3">Formato de disponibilidade inválido ou sem horários definidos.</p>
                                @endif
                            </ul>
                        </div>
                    @else
                        <p class="text-sm text-gray-700 mb-3">Disponibilidade não definida.</p>
                    @endif
                    
                    <!-- Botões -->
                    <div class="flex justify-center mt-auto space-x-4">
                        <a href="{{ route('edit-field', $field->id) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-blue-600 transition-all duration-300">
                            Editar
                        </a>

                        <form action="{{ route('delete-field', $field->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="confirmDelete(this)"
                                class="inline-block bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600 transition-all duration-300">
                                Apagar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('create-field') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Adicionar Novo Campo
            </a>
        </div>
    </div>

    @include('home.footer')
</body>

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

</html>
