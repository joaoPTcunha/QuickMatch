@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-auto p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
            <h1 class="text-2xl sm:text-3xl font-bold text-center sm:text-left">Suporte ao Cliente</h1>
            <a href="{{ url('/problems_history') }}" class="text-blue-500 hover:underline text-center">
                Histórico de Problemas
            </a>
        </div>

        <div id="clientes-list" class="space-y-4">
            @foreach ($problems as $problem)
            <div class="problem-item bg-white shadow rounded-lg p-4 flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0" data-id="{{ $problem->id }}">
                <div class="space-y-2">
                    <h2 class="font-bold text-lg sm:text-xl text-gray-800">{{ $problem->subject }}</h2>
                    <p class="text-sm sm:text-base text-gray-600">{{ $problem->description }}</p>
                    <p class="text-sm sm:text-base text-gray-500">{{ $problem->email }}</p> <!-- E-mail do cliente -->
                    <p class="text-xs sm:text-sm text-gray-400">{{ $problem->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex justify-end">
                    @if (!$problem->is_solved)
                    <button onclick="openModal('{{ addslashes($problem->subject) }}', '{{ addslashes($problem->description) }}', '{{ $problem->id }}', '{{ $problem->email }}')" class="bg-purple-500 text-white text-sm sm:text-base px-4 py-2 rounded hover:bg-purple-600 transition">
                        Ver Detalhes
                    </button>
                    @else
                    <span class="text-green-500 text-sm sm:text-base font-medium">Resolvido</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div id="page-numbers" class="mt-6 flex justify-center space-x-2 text-sm"></div>
    </div>

    @include('admin.footer')
</body>


<script>
    function openModal(subject, description, problemId, customerEmail) {
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
                let emailSubject = `Problema: ${subject}`;
                let mailtoLink = `https://mail.google.com/mail/?view=cm&fs=1&to=${customerEmail}&su=${encodeURIComponent(emailSubject)}`;
                window.open(mailtoLink, '_blank');
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