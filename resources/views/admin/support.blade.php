@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl">Suporte ao Cliente</h1>
            <a href="{{ url('/problems_history') }}" class="text-blue-500 hover:underline">
                Ver Histórico de Problemas
            </a>
        </div>

        <div id="clientes-list" class="space-y-4">
            @foreach ($problems as $problem)
                <div class="problem-item bg-white shadow rounded-lg p-4 flex items-center justify-between" data-id="{{ $problem->id }}">
                    <div>
                        <h2 class="font-bold">{{ $problem->subject }}</h2>
                        <p>{{ $problem->description }}</p>
                        <p class="text-gray-500">{{ $problem->email }}</p>
                        <p class="text-gray-400">{{ $problem->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        @if (!$problem->is_solved)
                            <button onclick="openModal('{{ addslashes($problem->subject) }}', '{{ addslashes($problem->description) }}', '{{ $problem->id }}')" class="bg-purple-500 text-white px-4 py-2 rounded">Ver Detalhes</button>
                        @else
                            <span class="text-green-500">Resolvido</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div id="page-numbers" class="mt-6 flex justify-center space-x-2"></div>
    </div>

    @include('admin.footer')

    <script>
        function openModal(subject, description, problemId) {
            Swal.fire({
                title: `Descrição do Problema - ${subject}`,
                text: description,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Solucionado',
                cancelButtonText: 'Falar com Cliente',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    markAsSolved(problemId);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "{{ url('/chat') }}"; 
                }
            });
        }

        function markAsSolved(problemId) {
            fetch(`/problems/${problemId}/mark-as-solved`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Remover o problema da lista
                    document.querySelector(`.problem-item[data-id="${problemId}"]`).remove();
                    Swal.fire(
                        'Marcado como Solucionado!',
                        'O problema foi marcado como resolvido e removido da lista.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Erro!',
                        'Houve um problema ao marcar o problema como resolvido.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Erro!',
                    'Houve um problema ao marcar o problema como resolvido.',
                    'error'
                );
            });
        }
    </script>
</body>
