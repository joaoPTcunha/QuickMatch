@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow p-4 sm:p-6">
        <h1 class="text-3xl md:text-3xl lg:text-4xl font-semibold mb-4 md:mb-8 text-center text-gray-800">Histórico de Problemas</h1>
 
        @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif
 
        <div id="clientes-list" class="space-y-4">
            @foreach ($problems as $problem)
            <div class="problem-item bg-white shadow rounded-lg p-4 flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0" data-id="{{ $problem->id }}">
                <div class="space-y-2">
                    <h2 class="font-bold text-lg sm:text-xl text-gray-800">{{ $problem->subject }}</h2>
                    <p class="text-sm sm:text-base text-gray-600">{{ $problem->description }}</p>
                    <p class="text-sm sm:text-base text-gray-500">{{ $problem->email }}</p>
                    <p class="text-xs sm:text-sm text-gray-400">{{ $problem->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex justify-end">
                    @if (!$problem->is_solved)
                    <button onclick="openModal('{{ addslashes($problem->subject) }}', '{{ addslashes($problem->description) }}', '{{ $problem->id }}', '{{ $problem->email }}')" 
                            class="bg-purple-500 text-white text-sm sm:text-base px-4 py-2 rounded hover:bg-purple-600 transition">
                        Ver Detalhes
                    </button>
                    @else
                    <span class="text-green-500 text-sm sm:text-base font-medium">Resolvido</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @include('admin.footer')
</body>