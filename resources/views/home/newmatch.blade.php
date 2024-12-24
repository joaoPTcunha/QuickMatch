@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow px-3">
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-3xl text-center py-6 text-gray-800 font-semibold">Criar um Evento</h1>
            <form action="{{ route('store.event') }}" method="POST">
                @csrf
                <input type="hidden" name="field_id" value="{{ $field->id ?? '' }}">
                <div class="mb-4">
                    <label for="campo" class="block text-gray-700">Nome do Campo</label>
                    <div class="flex items-center">
                        <input
                            type="text"
                            id="campo"
                            name="field_name"
                            class="w-full mt-2 p-2 border rounded"
                            placeholder="Adicione um campo ->"
                            value="{{ old('field_name', $field->name ?? '') }}"
                            required
                            readonly>
                        <a href="{{ route('field', ['from' => 'newmatch', 'redirect' => url()->current()]) }}"
                            class="ml-2 px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700">Título do Evento</label>
                    <textarea id="descricao" name="descricao" rows="3" class="w-full mt-2 p-2 border rounded" placeholder="Insira um título curto e direto" required>{{ old('descricao') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="horarios-disponiveis" class="block text-gray-700">Horários Disponíveis</label>
                    <select id="horarios-disponiveis" name="schedule" class="w-full mt-2 p-2 border rounded" required>
                        <option value="" disabled selected>Selecione um Horário</option>
                        @if($field && $field->availability)
                            @php
                                $availabilitySlots = json_decode($field->availability, true);
                                $dayTranslations = [
                                    'monday' => 'Segunda-feira',
                                    'tuesday' => 'Terça-feira',
                                    'wednesday' => 'Quarta-feira',
                                    'thursday' => 'Quinta-feira',
                                    'friday' => 'Sexta-feira',
                                    'saturday' => 'Sábado',
                                    'sunday' => 'Domingo',
                                ];
                            @endphp
                            @foreach($availabilitySlots as $day => $times)
                                <optgroup label="{{ $dayTranslations[$day] ?? ucfirst($day) }}">
                                    @foreach ($times as $time)
                                        <option value="{{ $day }}|{{ $time['start'] }}|{{ $time['end'] }}">
                                            {{ $time['start'] }} até {{ $time['end'] }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-4">
                    <label for="specific-date" class="block text-gray-700">Data</label>
                    <input id="specific-date" type="date" name="specific-date" class="w-full mt-2 p-2 border rounded" required readonly>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Preço Total (€)</label>
                    <input type="number" id="price" name="price" class="w-full mt-2 p-2 border rounded" placeholder="Preço do Evento" value="{{ old('price', $field->price ?? '') }}" required readonly>
                </div>

                <div class="mb-4">
                    <label for="modality" class="block text-gray-700">Modalidade</label>
                    <select id="modality" name="modality" class="w-full mt-2 p-2 border rounded" required>
                        @foreach ($modalities as $modality)
                            <option value="{{ $modality }}" {{ (old('modality', $field->modality ?? '') == $modality) ? 'selected' : '' }}>
                                {{ $modality }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="participar" class="inline-flex items-center">
                        <input type="hidden" name="participar" value="0">
                        <input type="checkbox" id="participar" name="participar" class="form-checkbox h-5 w-5 text-blue-600" value="1" {{ old('participar') ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Participar neste evento</span>
                    </label>
                </div>

                <div class="mb-4 flex items-center">
                    <label for="num-participants" class="block text-gray-700 mr-4">Número de Participantes</label>
                    <input type="number" id="num-participants" name="num_participants" class="w-20 p-2 border rounded" value="{{ old('num-participants', 1) }}" min="1" required>
                </div>

                <div class="text-center mt-6">
                    <button type="submit" class="w-full bg-blue-900 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        Publicar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('home.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scheduleSelect = document.getElementById('horarios-disponiveis');
            const dateInput = document.getElementById('specific-date');
            let selectedDay = null; // Variable to store selected day from schedule

            scheduleSelect.addEventListener('change', function() {
                const selectedValues = Array.from(this.selectedOptions).map(option => option.value);
                if (selectedValues.length > 0) {
                    const [day] = selectedValues[0].split('|');
                    selectedDay = day; // Store the first selected day's name
                    setupDateRestrictions(dateInput, day);
                    
                    const nextValidDate = getNextDayOfWeek(day);
                    dateInput.value = nextValidDate.toISOString().split('T')[0];
                    dateInput.readOnly = false;
                } else {
                    dateInput.value = '';
                    dateInput.readOnly = true;
                }
            });

            dateInput.addEventListener('input', function() {
                if (selectedDay) {
                    const selectedDate = new Date(this.value);
                    const dayOfWeek = getDayName(selectedDate.getDay());
                    
                    // If selected date doesn't match the required day, adjust it to the next valid date
                    if (dayOfWeek !== selectedDay) {
                        const nextValidDate = getNextDayOfWeek(selectedDay, selectedDate);
                        this.value = nextValidDate.toISOString().split('T')[0];
                    }
                }
            });

            function setupDateRestrictions(dateInput, selectedDay) {
                const today = new Date();
                dateInput.min = today.toISOString().split('T')[0];
                const maxDate = new Date();
                maxDate.setMonth(maxDate.getMonth() + 3);
                dateInput.max = maxDate.toISOString().split('T')[0];
            }

            function getNextDayOfWeek(dayName, startDate = new Date()) {
                const days = {
                    'monday': 1,
                    'tuesday': 2,
                    'wednesday': 3,
                    'thursday': 4,
                    'friday': 5,
                    'saturday': 6,
                    'sunday': 0
                };

                const targetDay = days[dayName.toLowerCase()];
                const current = startDate.getDay();

                let daysToAdd = targetDay - current;
                if (daysToAdd <= 0) daysToAdd += 7;

                const nextDate = new Date(startDate);
                nextDate.setDate(startDate.getDate() + daysToAdd);
                return nextDate;
            }

            function getDayName(dayNumber) {
                const days = {
                    0: 'sunday',
                    1: 'monday',
                    2: 'tuesday',
                    3: 'wednesday',
                    4: 'thursday',
                    5: 'friday',
                    6: 'saturday'
                };
                return days[dayNumber];
            }
        });
    </script>
</body>
</html>
