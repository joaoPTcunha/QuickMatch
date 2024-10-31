@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">

    <div class="flex-grow flex items-center justify-center">
        <div class="w-full bg-white shadow-lg rounded-lg p-8 h-full">
            <h1 class="text-3xl mb-8 text-gray-800 border-b pb-4">Manutenção e Outros</h1>

            <!-- Agendar uma Manutenção -->
            <div class="mb-6 border rounded-lg p-6 hover:bg-blue-4000">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Agendar uma manutenção</h2>
                <p class="text-gray-600 mb-4">
                    Será enviada uma notificação a todos os utilizadores sobre o dia e hora da manutenção.
                </p>
                <button onclick="agendarManutencao()" class="bg-gray-200 text-black px-6 py-2 rounded hover:bg-green-400 border border-black">
                    Agendar
                </button>
            </div>

            <!-- Agendar uma Interrupção da Plataforma -->
            <div class="mb-6 border rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Agendar uma interrupção da plataforma</h2>
                <p class="text-gray-600 mb-4">
                    Será enviada uma notificação a todos os utilizadores e o site deixará de funcionar online, para resolução de problemas.
                </p>
                <button onclick="agendarInterrupcao()" class="bg-gray-200 text-black px-6 py-2 rounded hover:bg-green-400 border border-black">
                    Agendar
                </button>
            </div>

            <!-- Criar um Comunicado Global -->
            <div class="border rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Criar um comunicado global</h2>
                <p class="text-gray-600 mb-4">
                    Será enviado a todos os utilizadores um comunicado global.
                </p>
                <button onclick="criarComunicado()" class="bg-gray-200 text-black px-6 py-2 rounded hover:bg-green-400 border border-black">
                    Escrever →
                </button>
            </div>
        </div>
    </div>

    @include('admin.footer')

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function agendarManutencao() {
            Swal.fire({
                title: 'Agendar Manutenção',
                html: `
                    <div class="flex flex-col">
                        <label for="data">Data:</label>
                        <input type="date" id="data" class="swal2-input" style="width: 80%">
                        
                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" class="swal2-input" style="width: 80%;">
                        
                        <label for="motivo">Motivo:</label>
                        <textarea id="motivo" class="swal2-textarea" placeholder="Descreva o motivo da manutenção"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Agendar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const data = document.getElementById('data').value;
                    const hora = document.getElementById('hora').value;
                    const motivo = document.getElementById('motivo').value;

                    if (!data || !hora || !motivo) {
                        Swal.showValidationMessage('Por favor, preencha todos os campos');
                        return false;
                    }

                    return { data, hora, motivo };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Agendado!',
                        `Manutenção agendada para ${result.value.data} às ${result.value.hora}. Motivo: ${result.value.motivo}`,
                        'success'
                    );
                }
            });
        }

        function agendarInterrupcao() {
            Swal.fire({
                title: 'Agendar Interrupção',
                html: `
                    <div class="flex flex-col gap-4">
                        <label for="data-interrupcao">Data:</label>
                        <input type="date" id="data-interrupcao" class="swal2-input" style="width: 80%;">
                        
                        <label for="hora-interrupcao">Hora:</label>
                        <input type="time" id="hora-interrupcao" class="swal2-input" style="width: 80%;">
                        
                        <label for="motivo-interrupcao">Motivo:</label>
                        <textarea id="motivo-interrupcao" class="swal2-textarea" placeholder="Descreva o motivo da interrupção"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Agendar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const data = document.getElementById('data-interrupcao').value;
                    const hora = document.getElementById('hora-interrupcao').value;
                    const motivo = document.getElementById('motivo-interrupcao').value;

                    if (!data || !hora || !motivo) {
                        Swal.showValidationMessage('Por favor, preencha todos os campos');
                        return false;
                    }

                    return { data, hora, motivo };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Agendado!',
                        `Interrupção agendada para ${result.value.data} às ${result.value.hora}. Motivo: ${result.value.motivo}`,
                        'success'
                    );
                }
            });
        }

        function criarComunicado() {
            Swal.fire({
                title: 'Criar Comunicado',
                text: 'Deseja escrever um comunicado global?',
                input: 'textarea',
                inputPlaceholder: 'Digite o comunicado aqui...',
                showCancelButton: true,
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    Swal.fire(
                        'Enviado!',
                        'O comunicado foi enviado para todos os utilizadores.',
                        'success'
                    );
                }
            });
        }
    </script>
</body>