@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow container mx-auto p-6">
        <h1 class="text-3xl mb-6">Suporte ao cliente</h1>

        <div id="clientes-list" class="space-y-4">
            @foreach ($problems as $problem)
                <div class="problem-item bg-white shadow rounded-lg p-4 flex items-center justify-between">
                    <div class="flex-grow flex flex-col">
                        <p class="font-semibold text-gray-800">{{ $problem->subject }}</p>
                        <p class="text-gray-600">{{ $problem->description }}</p>
                    </div>
                    <div class="flex items-center ml-4">
                        <button onclick="openModal('{{ addslashes($problem->description) }}', '{{ addslashes($problem->subject) }}')" class="bg-red-400 text-white hover:bg-red-600 flex items-center px-4 py-1 rounded">
                            Ver Problema
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação (se necessário) -->
        <div id="pagination" class="flex justify-center items-center mt-8 space-x-2">
            <button onclick="changePage('prev')" class="text-gray-500 hover:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <div id="page-numbers" class="flex space-x-2"></div>
            <button onclick="changePage('next')" class="text-gray-500 hover:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    @include('admin.footer')

    <script>
        const itemsPerPage = 4;
        let currentPage = 1;

        function openModal(description, clientName) {
            Swal.fire({
                title: `Descrição do Problema - ${clientName}`,
                text: description,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Solucionado',
                cancelButtonText: 'Falar com Cliente',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Marcado como Solucionado!',
                        'O problema foi marcado como resolvido.',
                        'success'
                    );
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "URL_DO_CHAT"; // Coloque a URL do chat aqui
                }
            });
        }

        function displayPage(page) {
            const problems = document.querySelectorAll('.problem-item');
            const totalItems = problems.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);

            problems.forEach((item) => {
                item.style.display = 'none';
            });

            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            for (let i = start; i < end && i < totalItems; i++) {
                problems[i].style.display = 'flex';
            }

            updatePagination(page, totalPages);
        }

        function updatePagination(currentPage, totalPages) {
            const pageNumbers = document.getElementById('page-numbers');
            pageNumbers.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.className = `px-3 py-1 border rounded-md ${currentPage === i ? 'bg-gray-300' : 'hover:bg-gray-200'}`;
                pageButton.onclick = () => displayPage(i);
                pageNumbers.appendChild(pageButton);
            }
        }

        function changePage(direction) {
            const problems = document.querySelectorAll('.problem-item');
            const totalPages = Math.ceil(problems.length / itemsPerPage);

            if (direction === 'prev' && currentPage > 1) {
                currentPage--;
            } else if (direction === 'next' && currentPage < totalPages) {
                currentPage++;
            }

            displayPage(currentPage);
        }

        displayPage(currentPage);
    </script>
</body>
