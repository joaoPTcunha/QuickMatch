<div class="container mx-auto p-4">
    <h3 class="text-3xl font-semibold text-center mb-6">Editar Campo</h3>
    
    <form action="{{ route('fields.update', $field->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Nome do Campo</label>
            <input type="text" name="name" id="name" value="{{ $field->name }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold">Descrição</label>
            <textarea name="description" id="description" rows="3" class="w-full p-2 border border-gray-300 rounded mt-1">{{ $field->description }}</textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-semibold">Imagem</label>
            <input type="file" name="image" id="image" class="w-full mt-1" accept="image/*">
            @if ($field->image)
                <img src="{{ asset('storage/' . $field->image) }}" alt="Imagem do campo" class="w-24 h-24 mt-2 object-cover rounded-lg">
            @endif
        </div>

        <div class="mb-4">
            <label for="location" class="block text-gray-700 font-semibold">Localização (Google Maps)</label>
            <input type="text" name="location" id="location" value="{{ $field->location }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label for="availability" class="block text-gray-700 font-semibold">Disponibilidade</label>
            <input type="text" name="availability" id="availability" value="{{ $field->availability }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label for="contact" class="block text-gray-700 font-semibold">Contato</label>
            <input type="text" name="contact" id="contact" value="{{ $field->contact }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-semibold">Preço (€ por hora)</label>
            <input type="number" name="price" id="price" value="{{ $field->price }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Atualizar Campo
            </button>
        </div>
    </form>
</div>