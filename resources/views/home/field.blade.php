@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
        <h1 class="text-3xl text-center py-6 text-gray-800 font-bold">Lista de Campos</h1>
        <div class="px-10 sm:px-20 mb-6">
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 items-start">
                <div class="w-full sm:w-1/3">
                    <label for="modality" class="block text-gray-700 font-semibold mb-2">Filtrar por Modalidade:</label>
                    <div class="relative">
                        <select name="modality" id="modality" class="p-3 pl-10 pr-4 border border-gray-300 rounded-md shadow-md focus:ring-2 focus:ring-blue-500 transition-all duration-300" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            <option value="futebol" {{ request('modality') == 'futebol' ? 'selected' : '' }}>Futebol</option>
                            <option value="futebol 7" {{ request('modality') == 'futebol 7' ? 'selected' : '' }}>Futebol 7</option>
                            <option value="futsal" {{ request('modality') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                            <option value="basquetebol" {{ request('modality') == 'basquetebol' ? 'selected' : '' }}>Basquetebol</option>
                            <option value="voleibol" {{ request('modality') == 'voleibol' ? 'selected' : '' }}>Voleibol</option>
                            <option value="andebol" {{ request('modality') == 'andebol' ? 'selected' : '' }}>Andebol</option>
                            <option value="ténis" {{ request('modality') == 'ténis' ? 'selected' : '' }}>Ténis</option>
                            <option value="raguebi" {{ request('modality') == 'raguebi' ? 'selected' : '' }}>Raguebi</option>
                            <option value="padel" {{ request('modality') == 'padel' ? 'selected' : '' }}>Padel</option>
                        </select>
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 10l5 5 5-5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
                <div class="w-full sm:w-1/3">
                    <label for="search" class="block text-gray-700 font-semibold mb-2">Pesquisar:</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Pesquisar por nome, localização..." class="p-3 pl-10 pr-4 border border-gray-300 rounded-md shadow-md focus:ring-2 focus:ring-blue-500 transition-all duration-300" onkeyup="this.form.submit()">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 21l-4.35-4.35m1.49-2.83A9 9 0 1111 3a9 9 0 016.6 11.82z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 px-10 sm:px-20">
            @foreach($fields as $field)
            <div class="flex flex-col bg-white p-4 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-4">
                    <label for="field_image_{{ $field->id }}" class="cursor-pointer">
                        <img src="{{ asset('Fields/' . $field->image) }}" alt="{{ $field->name }}" class="w-full h-36 object-cover rounded-md shadow-md cursor-pointer" data-image-url="{{ asset('Fields/' . $field->image) }}" onclick="openModal(this)">
                    </label>
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-2 text-center">{{ $field->name }}</h2>
                <div class="text-gray-700 text-sm space-y-1">
                    <p><strong>Localização:</strong> {{ $field->location }}</p>
                    <p><strong>Preço:</strong> {{ $field->price }}€</p>
                    <p><strong>Modalidade(s):</strong> {{ $field->modality }}</p>
                    <p><strong>Descrição:</strong> {{ $field->description }}</p>
                    <p><strong>Nome do Dono:</strong> {{ $field->user->name }}</p>
                    <p><strong>Email do Dono:</strong> {{ $field->user->email }}</p>
                    <p><strong>Contacto:</strong> {{ $field->contact }}</p>
                </div>
                <div class="mt-4 text-center">
                    @if($from === 'newmatch')
                    <a href="{{ url('/newmatch/'.$field->id) }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-600 transition-all duration-300">
                        Usar este Campo
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
            
        </div>
        <div class="mt-6 px-10 sm:px-20">
            {{ $fields->links() }}
        </div>
    </div>
    @include('home.footer')
    <script>
        function openModal(element) {
            const imageUrl = element.getAttribute('data-image-url');
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modalImage.src = imageUrl;
            modal.style.display = 'flex';
        }

        function closeModal(event) {
            if (event.target === event.currentTarget) {
                const modal = document.getElementById('imageModal');
                modal.style.display = 'none';
            }
        }
    </script>
</body>

<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center z-50" style="display: none;" onclick="closeModal(event)">
    <div class="relative">
        <img id="modalImage" src="" alt="Imagem ampliada" class="max-w-screen-md max-h-screen-md rounded-md cursor-pointer" onclick="event.stopPropagation();">
    </div>
</div>
</html>