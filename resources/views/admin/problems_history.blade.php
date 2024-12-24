@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-16 p-6">
        <h1 class="text-4xl font-semibold mb-8 text-center text-gray-800">Histórico de Problemas</h1>


        @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div id="clientes-list" class="space-y-4">
            @foreach ($problems as $problem)
            <div class="problem-item bg-white shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <h2 class="font-bold">{{ $problem->subject }}</h2>
                    <p>{{ $problem->description }}</p>
                    <p class="text-gray-500">{{ $problem->email }}</p>
                    <p class="text-gray-400">{{ $problem->created_at }}</p>
                </div>
                <div>
                    @if (!$problem->is_solved)
                    <form action="{{ route('markAsSolved', $problem->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white p-2 rounded">Marcar como Resolvido</button>
                    </form>
                    @else
                    <span class="text-green-500">Resolvido</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('admin.footer')
</body>