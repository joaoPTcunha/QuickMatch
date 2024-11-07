@include('home.css')  <!-- Incluindo o CSS do Tailwind -->
@include('home.header')  <!-- Incluindo o cabeçalho -->

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow flex">
        <!-- Sidebar de usuários -->
        <div class="w-1/4 bg-gray-100 p-4 border-r overflow-y-auto">
            <h2 class="text-xl font-semibold mb-4">Usuários</h2>
            <ul>
                @foreach($users as $user)  <!-- Loop através dos usuários -->
                    <li class="py-2 px-4 rounded hover:bg-gray-200 cursor-pointer" onclick="loadMessages({{ $user->id }})">
                        <span class="text-gray-700">{{ $user->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Área de chat principal -->
        <div class="flex-1 flex flex-col" id="chat-box">
            <div class="flex-1 p-4 overflow-y-auto" id="message-container">
                <h2 class="text-2xl font-semibold mb-4">Chat</h2>
                <!-- Aqui as mensagens serão carregadas dinamicamente -->
            </div>

            <!-- Campo de entrada para enviar mensagem -->
            <form class="p-4 border-t flex items-center space-x-3" id="message-form" onsubmit="sendMessage(event)">
                <input type="text" name="content" id="message-content"
                       class="flex-1 px-4 py-2 rounded-lg border focus:outline-none focus:ring focus:border-blue-300"
                       placeholder="Escreva uma mensagem..." onkeydown="checkEnter(event)">
                <input type="hidden" name="receiver_id" id="receiver-id">
                <button type="submit" id="send-button" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" disabled>
                    Enviar
                </button>
            </form>
        </div>
    </div>

    @include('home.footer')  <!-- Incluindo o rodapé -->

    <!-- Scripts e Toastr para feedback de mensagens -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        let lastSenderId = null; // Variável para armazenar o ID do último remetente

        function loadMessages(receiverId) {
            document.getElementById('receiver-id').value = receiverId;
            const sendButton = document.getElementById('send-button');
            sendButton.disabled = true;

            fetch(`/get-messages/${receiverId}`, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(messages => {
                const container = document.getElementById('message-container');
                container.innerHTML = ''; // Limpar mensagens anteriores
                lastSenderId = null; // Redefine o último remetente ao carregar novas mensagens

                // Exibindo cada mensagem
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('mb-1', 'rounded-lg'); // Menos espaçamento

                    // Exibe o nome apenas se o remetente for diferente do último
                    if (message.sender_id !== lastSenderId) {
                        const userNameElement = document.createElement('div');
                        userNameElement.classList.add('text-sm', 'font-medium', 'mb-1', 'p-2');

                        if (message.sender_id === {{ auth()->id() }}) {
                            userNameElement.classList.add('text-gray-500', 'text-right', 'ml-auto');
                        } else {
                            userNameElement.classList.add('text-gray-700', 'text-left');
                        }

                        userNameElement.textContent = message.sender.name;
                        messageElement.appendChild(userNameElement);
                    }

                    const messageContent = document.createElement('div');
                    messageContent.classList.add('p-2', 'rounded-lg', 'max-w-xs');

                    // Estilo do balão de mensagem
                    if (message.sender_id === {{ auth()->id() }}) {
                        messageContent.classList.add('bg-blue-500', 'text-white', 'text-right', 'ml-auto');
                    } else {
                        messageContent.classList.add('bg-gray-300', 'text-gray-800', 'text-left', 'mr-auto');
                    }

                    messageContent.textContent = message.content;
                    messageElement.appendChild(messageContent);

                    // Adiciona o balão de mensagem no container
                    container.appendChild(messageElement);

                    // Atualiza o último remetente
                    lastSenderId = message.sender_id;
                });

                scrollToBottom();  // Função que rola até o fim
                sendButton.disabled = false;  // Habilita o botão de envio
            })
            .catch(error => {
                // Tratamento de erro movido para o controller
            });
        }

        // Enviar mensagem
       function sendMessage(event) {
    event.preventDefault();

    const content = document.getElementById('message-content').value.trim();
    if (!content) {
        toastr.clear();  // Limpar qualquer notificação anterior
        toastr.error('Você não pode enviar uma mensagem vazia.', 'Erro');
        return;
    }

    const receiverId = document.getElementById('receiver-id').value;
    const sendButton = document.getElementById('send-button');
    sendButton.disabled = true;

    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            receiver_id: receiverId,
            content: content
        })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('message-content').value = ''; // Limpar campo de entrada
        loadMessages(receiverId); // Carregar mensagens novamente
        toastr.clear();  // Limpar qualquer notificação de erro
        toastr.success('Mensagem enviada com sucesso!', 'Sucesso');
    })
    .catch(error => {
        toastr.clear();  // Limpar qualquer notificação de sucesso anterior
        toastr.error('Ocorreu um erro ao enviar a mensagem. Tente novamente.', 'Erro');
    })
    .finally(() => {
        sendButton.disabled = false;  // Habilitar o botão após a resposta
    });
}


        // Verifica se pressionou "Enter" para enviar mensagem
        function checkEnter(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                const content = document.getElementById('message-content').value.trim();
                if (content) {
                    sendMessage(event);
                } else {
                    toastr.error('Você não pode enviar uma mensagem vazia.', 'Erro');
                }
            }
        }

        // Função para rolar até a última mensagem
        function scrollToBottom() {
            const container = document.getElementById('message-container');
            container.scrollTop = container.scrollHeight;
        }

        // Verifica se há texto no campo para habilitar ou desabilitar o botão de envio
        document.getElementById('message-content').addEventListener('input', function() {
            const sendButton = document.getElementById('send-button');
            const receiverId = document.getElementById('receiver-id').value;
            sendButton.disabled = this.value.trim() === '';  // Desabilita botão se não houver texto
        });
    </script>
</body>