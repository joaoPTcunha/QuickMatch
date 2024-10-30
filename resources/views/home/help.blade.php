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
        transform: rotate(360deg); /* Rotaciona a seta */
    }
</style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    @include('home.header')

    <div class="container mx-auto flex-grow py-1 px-4 rounded-lg">
        <h1 class="text-center text-4xl font-bold my-2">Central de Ajuda</h1>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Perguntas Frequentes (FAQ)</h2>
            <div class="rounded-lg shadow-md p-6">
                <div class="mb-4">
                    <div class="faq-question cursor-pointer flex justify-between items-center bg-blue-200 rounded-lg p-4" onclick="toggleAnswer('faq1', this)">
                        <h3>1. Como posso redefinir minha senha?</h3>
                        <span class="toggle-icon">^</span>
                    </div>
                    <div id="faq1" class="faq-answer mx-2 p-3">
                        <p>Você pode redefinir sua senha clicando em "Esqueci a senha" na tela de login. Siga as instruções enviadas para o seu e-mail.</p>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="faq-question cursor-pointer flex justify-between items-center bg-blue-200 rounded-lg p-4" onclick="toggleAnswer('faq2', this)">
                        <h3>2. Como posso entrar em contato com o suporte?</h3>
                        <span class="toggle-icon">^</span>
                    </div>
                    <div id="faq2" class="faq-answer mx-2 p-3">
                        <p>Você pode entrar em contato com o suporte através do e-mail suporte@exemplo.com ou pelo telefone (11) 1234-5678.</p>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="faq-question cursor-pointer flex justify-between items-center bg-blue-200 rounded-lg p-4" onclick="toggleAnswer('faq3', this)">
                        <h3>3. Quais métodos de pagamento são aceitos?</h3>
                        <span class="toggle-icon">^</span>
                    </div>
                    <div id="faq3" class="faq-answer mx-2 p-3">
                        <p>Aceitamos cartões de crédito, débito e PayPal. Confira nossa página de pagamento para mais informações.</p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-semibold mb-4 my-">Envie uma Reclamação</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="/enviar-reclamacao" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome:</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail:</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição da Reclamação:</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required></textarea>
                    </div>
                    <button type="submit" class="p-4 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded">
                        Enviar Reclamação
                    </button>
                </form>
            </div>
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
