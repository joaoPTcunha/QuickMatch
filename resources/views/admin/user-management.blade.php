@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">

    <div class="flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Gestão de Utilizadores</h1>
            
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                        <th class="border px-4 py-2 bg-blue-600 text-white">ID</th>
                        <th class="border px-4 py-2 bg-blue-600 text-white">NOME</th>
                        <th class="border px-4 py-2 bg-blue-600 text-white">DETALHES</th>
                        <th class="border px-4 py-2 bg-blue-600 text-white">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->id }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:underline">Ver -></a>
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:underline">✏️</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @include('admin.footer')
</body>
</html>