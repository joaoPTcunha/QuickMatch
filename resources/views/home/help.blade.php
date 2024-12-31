@include('home.css')
@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="container mx-auto flex-grow py-8 px-4 rounded-lg">
        <h1 class="text-4xl text-center py-6 text-gray-800 font-semibold">Central de Ajuda</h1>

        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Perguntas Frequentes (FAQ)</h2>
            <div class="rounded-lg shadow-md p-6 bg-white">
                <div class="mb-4">
                    <div class="faq-card p-4 bg-gray-300 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">1. Como faço uma reserva?</h3>
                        <p class="mt-2 text-gray-700">Para fazer uma reserva, basta selecionar o campo desejado, escolher a modalidade e a data disponível, e então confirmar a sua reserva.</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="faq-card p-4 bg-gray-300 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">2. Posso cancelar minha reserva?</h3>
                        <p class="mt-2 text-gray-700">Sim, é possível cancelar a sua reserva dentro de um período determinado. Consulte as nossas políticas de cancelamento para mais informações.</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="faq-card p-4 bg-gray-300 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">3. Como posso encontrar o campo ideal para a minha prática?</h3>
                        <p class="mt-2 text-gray-700">Você pode usar a nossa ferramenta de busca para filtrar os campos por modalidade, localização e disponibilidade, facilitando a escolha do campo ideal.</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="faq-card p-4 bg-gray-300 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">4. O que fazer se eu tiver problemas com o site?</h3>
                        <p class="mt-2 text-gray-700">Caso enfrente dificuldades, entre em contato conosco através da nossa seção de "Contato" ou envie um e-mail para suporte@quickmatch.com</p>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <h2 class="text-2xl font-semibold mb-4">Envie uma Reclamação</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('send.problem') }}" method="POST">
                    @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                    @endif
                    @csrf
                    <div class="mb-4">
                        <label for="subject" class="block text-sm font-medium text-gray-700">Assunto:</label>
                        <input type="text" id="subject" name="subject" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição da Reclamação:</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required></textarea>
                    </div>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                        Enviar Reclamação
                    </button>
                </form>
            </div>
        </section>
    </div>

    @include('home.footer')
</body>