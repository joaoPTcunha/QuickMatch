@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-auto p-4">
        <h3 class="text-3xl font-semibold text-center mb-6">Meus Campos</h3>

        @if($fields->isEmpty())
            <div class="text-center py-4 px-6 bg-yellow-100 text-yellow-700 rounded-md shadow-md">
                <p>Ainda nao tem campos registados</p>
            </div>
        @else

            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-base font-medium text-gray-500">Imagem</th>
                            <th class="px-6 py-3 text-left text-base font-medium text-gray-500">Nome Campo</th>
                            <th class="px-6 py-3 text-left text-base font-medium text-gray-500">Localizacao</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fields as $field)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-base text-gray-900">
                                    <img src="{{ asset('Campos/' . $field->image) }}" alt="Imagem do campo" class="w-24 h-24 object-cover rounded-lg">
                                </td>
                                <td class="px-6 py-4 text-base text-gray-900">
                                    {{ $field->name }}
                                </td>
                                <td class="px-6 py-4 text-base text-gray-700">
                                    {{ $field->location }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="mt-6 text-center">
            <a href="{{ route('fields.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Adicionar Novo Campo
            </a>
        </div>
    </div>

    @include('home.footer')
</body>
</html>
