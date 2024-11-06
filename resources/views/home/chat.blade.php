@include('home.css')  <!-- Incluindo o CSS do Tailwind -->

@include('home.header')  <!-- Incluindo o cabeçalho -->

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow flex">
        <!-- Sidebar de usuários -->
        <div class="w-1/4 bg-gray-100 p-4 border-r overflow-y-auto">
            <h2 class="text-xl font-semibold mb-4">Usuários</h2>
            <ul>
                @foreach($users as $user)
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
            </div>

            <!-- Campo de entrada para enviar mensagem -->
            <form class="p-4 border-t flex items-center space-x-3" id="message-form" onsubmit="sendMessage(event)">
                <input type="text" name="content" id="message-content" class="flex-1 px-4 py-2 rounded-lg border focus:outline-none focus:ring focus:border-blue-300" placeholder="Escreva uma mensagem..." onkeydown="checkEnter(event)">
                <input type="hidden" name="receiver_id" id="receiver-id">
                <button type="submit" id="send-button" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" disabled>Enviar</button>
            </form>
        </div>
    </div>

    @include('home.footer')  <!-- Incluindo o rodapé -->

    <script>
        // Função para carregar as mensagens
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
                container.innerHTML = '';
    
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('mb-4', 'p-3', 'rounded-lg');
    
                    // Adicionando o nome do usuário acima da mensagem
                    if (message.sender_id !== {{ auth()->id() }}) { // Exibe o nome só para mensagens de outros usuários
                        const userNameElement = document.createElement('div');
                        userNameElement.classList.add('text-sm', 'font-medium', 'text-gray-700', 'mb-1');
                        userNameElement.textContent = message.sender.name;  // Exibe o nome do usuário que enviou a mensagem
                        messageElement.appendChild(userNameElement);
                    }
    
                    // Estilo do balão de mensagem
                    const messageContent = document.createElement('div');
                    messageContent.classList.add('p-3', 'rounded-lg', 'max-w-xs');

                    // Alinhamento da mensagem à direita (para o usuário logado) ou à esquerda (para outros usuários)
                    if (message.sender_id === {{ auth()->id() }}) {
                        messageContent.classList.add('bg-blue-500', 'text-white', 'text-right', 'ml-auto');  // Mensagem do usuário logado
                    } else {
                        messageContent.classList.add('bg-gray-300', 'text-gray-800', 'text-left', 'mr-auto');  // Mensagem de outros usuários
                    }

                    // Adicionando o conteúdo da mensagem
                    messageContent.textContent = message.content;
                    messageElement.appendChild(messageContent);

                    // Adiciona o balão de mensagem no container
                    container.appendChild(messageElement);
                });
    
                scrollToBottom();
                sendButton.disabled = false;
            })
            .catch(error => {
                toastr.error('Erro ao carregar as mensagens', 'Erro');
                sendButton.disabled = false;
            });
        }
    
        // Função para enviar mensagem
        function sendMessage(event) {
            event.preventDefault();
    
            const content = document.getElementById('message-content').value;
            const receiverId = document.getElementById('receiver-id').value;
            const sendButton = document.getElementById('send-button');
    
            if (content.trim() === '') {
                toastr.warning('Digite uma mensagem antes de enviar', 'Atenção');
                return;
            }
    
            if (!receiverId) {
                toastr.warning('Selecione um usuário para enviar a mensagem', 'Atenção');
                return;
            }
    
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
                document.getElementById('message-content').value = '';
                loadMessages(receiverId);
    
                if (data.status === 'success') {
                    toastr.success(data.message, 'Mensagem Enviada', {
                        timeOut: 2000,
                        closeButton: false
                    });
                } else {
                    throw new Error('Erro ao enviar mensagem');
                }
            })
            .catch(error => {
                toastr.error('Não foi possível enviar sua mensagem', 'Erro', {
                    timeOut: 3000,
                    closeButton: true
                });
                sendButton.disabled = false;
            });
        }
    
        // Função para verificar o Enter
        function checkEnter(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                const content = document.getElementById('message-content').value;
    
                if (content.trim() === '') {
                    toastr.warning('Digite uma mensagem antes de enviar', 'Atenção');
                    return;
                }
    
                sendMessage(event);
            }
        }
    
        // Listener para quando o usuário começa a digitar
        document.getElementById('message-content').addEventListener('input', function() {
            const sendButton = document.getElementById('send-button');
            const receiverId = document.getElementById('receiver-id').value;
    
            if (!receiverId) {
                toastr.info('Selecione um usuário antes de começar a digitar', 'Dica');
                this.value = '';
                return;
            }
    
            sendButton.disabled = this.value.trim() === '';
        });
    
        // Verificar se há mensagens flash na sessão
        @if(session('success'))
            toastr.success("{{ session('success') }}", "Sucesso");
        @endif
    
        @if(session('error'))
            toastr.error("{{ session('error') }}", "Erro");
        @endif
    </script>
</body>
