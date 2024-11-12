@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">

    <div class="flex-grow">
        <div class="container mx-auto p-4">
            <h3 class="text-3xl font-semibold text-center mb-6">Editar Campo</h3>

            <!-- Card contendo todos os campos -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                
                <!-- Imagem do campo -->
                <div id="imagePreview" class="flex justify-center mb-6">
                    @if ($field->image)
                        <div class="border border-gray-200 rounded-lg overflow-hidden shadow-md w-36 h-36">
                            <img src="{{ asset('Fields/' . $field->image) }}" alt="Imagem do campo" class="w-full h-full object-cover" id="previewImg">
                        </div>
                    @endif
                </div>

                <!-- Botão para alterar a imagem -->
                <div class="text-center mb-6">
                    <span class="text-blue-600 font-semibold cursor-pointer" onclick="document.getElementById('image').click()">
                        Alterar Imagem
                    </span>
                </div>

                <!-- Formulário -->
                <form action="{{ route('update-fields', $field->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold">Nome do Campo</label>
                        <input type="text" name="name" id="name" value="{{ $field->name }}" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold">Descrição</label>
                        <textarea name="description" id="description" rows="3" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $field->description }}</textarea>
                    </div>

                    <!-- Campo oculto para o upload de imagem -->
                    <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(event)">

                    <div class="mb-4">
                        <label for="location" class="block text-gray-700 font-semibold">Localização (Google Maps)</label>
                        <input type="text" name="location" id="location" value="{{ $field->location }}" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="contact" class="block text-gray-700 font-semibold">Contato</label>
                        <input type="text" name="contact" id="contact" value="{{ $field->contact }}" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="modality" class="block text-gray-700 font-semibold">Tipo de desporto:</label>
                        <input type="text" name="modality" id="modality" value="{{ $field->modality }}" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>                

                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-semibold">Preço (€ por hora)</label>
                        <input type="number" name="price" id="price" value="{{ $field->price }}" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                            Atualizar Campo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('home.footer')

    <script>
        // Função para mostrar a pré-visualização da imagem
        function previewImage(event) {
            var reader = new FileReader();
            var preview = document.getElementById('imagePreview');
            var file = event.target.files[0];
            
            reader.onload = function() {
                var img = new Image();
                img.src = reader.result;
                img.classList.add('w-36', 'h-36', 'object-cover', 'border', 'border-gray-200', 'rounded-lg', 'overflow-hidden', 'shadow-md');
                preview.innerHTML = ''; 
                preview.appendChild(img); 
            };
            reader.readAsDataURL(file);  
        }
    </script>  


