<head>
    @include('home.css')
    <title>Central de Ajuda</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .faq-answer {
            display: none; /* Respostas inicialmente ocultas */
        }
        .toggle-icon {
            transition: transform 0.3s;
            font-size: 20px; /* Ajuste o tamanho da seta */
            margin-left: 10px; /* Espaço entre o texto e a seta */
        }
        .rotated {
            transform: rotate(180deg); /* Rotaciona a seta */
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    @include('home.header')

    <div class="container mx-auto flex-grow py-8 px-4 rounded-lg">
        <h1 class="text-center text-4xl font-bold my-8">Central de Ajuda</h1>

        <!-- FAQ Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Perguntas Frequentes (FAQ)</h2>
            <div class="rounded-lg shadow-md p-6 bg-white">
                @foreach($faqs as $faq)
                    <div class="mb-4">
                        <div class="faq-question cursor-pointer flex justify-between items-center bg-blue-200 rounded-lg p-4" onclick="toggleAnswer('faq{{ $loop->index }}', this)">
                            <h3>{{ $loop->iteration }}. {{ $faq['question'] }}</h3>
                            <span class="toggle-icon">^</span>
                        </div>
                        <div id="faq{{ $loop->index }}" class="faq-answer mx-2 p-3">
                            <p>{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- Complaint Form Section -->
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
        </section>
    </div>

    <script>
        function toggleAnswer(faqId, element) {
            const answer = document.getElementById(faqId);
            const toggleIcon = element.querySelector('.toggle-icon');
            if (answer.style.display === "none" || answer.style.display === "") {
                answer.style.display = "block"; // Mostra a resposta
                toggleIcon.innerHTML = '˅'; // Muda a seta para baixo
                toggleIcon.classList.add('rotated'); // Adiciona a classe para rotacionar
            } else {
                answer.style.display = "none"; // Oculta a resposta
                toggleIcon.innerHTML = '^'; // Muda a seta para cima
                toggleIcon.classList.remove('rotated'); // Remove a classe de rotação
            }
        }
    </script>

    @include('home.footer')
</body>
