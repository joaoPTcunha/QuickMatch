@include('home.css')  <!-- Incluindo o CSS do Tailwind -->
@include('home.header')  <!-- Incluindo o cabeçalho -->

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow flex">
        <div class="w-1/4 bg-gray-100 p-4 border-r overflow-y-auto">
            <h2 class="text-xl font-semibold mb-4">Usuários</h2>
            <ul>
                @foreach($users as $user) <!-- Loop através dos usuários -->
                    <li class="py-2 px-4 rounded hover:bg-gray-200 cursor-pointer" onclick="loadMessages({{ $user->id }})">
                        <span class="text-gray-700">{{ $user->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex-1 flex flex-col bg-white">
            <div class="p-4 border-b bg-gray-100">
                <h2 class="text-3xl">Conversas</h2>
            </div>

            <div class="flex-1 p-4 overflow-y-auto max-h-[calc(100vh-200px)]" id="text">
                Bem-vindo ao Chat! À sua esquerda encontram se todos os utilizadores com quem você já conversou, selecione um e será redirecionado para a conversa.
                <img src="https://media1.giphy.com/media/Jsu7wXi2uhtzfR94mQ/200w.gif?cid=6c09b9521rjed9bmocc9tkhoj5pueh2vslyancl9fvdlf6xb&ep=v1_gifs_search&rid=200w.gif&ct=g" alt="Brawl Stars GIF" class="w-32 h-32 rounded-lg">

            </div>

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

    @include('home.footer')  

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let lastSenderId = null; 

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
        const container = document.getElementById('text');
        container.innerHTML = ''; 
        lastSenderId = null; 

        messages.forEach(message => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('mb-1', 'rounded-lg'); 

            
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

            if (message.sender_id === {{ auth()->id() }}) {
                messageContent.classList.add('bg-blue-500', 'text-white', 'text-right', 'ml-auto');
            } else {
                messageContent.classList.add('bg-gray-300', 'text-gray-800', 'text-left', 'mr-auto');
            }

            messageContent.textContent = message.content;
            messageElement.appendChild(messageContent);

            container.appendChild(messageElement);

            lastSenderId = message.sender_id;
        });

        scrollToBottom();  
        sendButton.disabled = false; 
    })
    .catch(error => {
        showAlert('error', 'Erro ao carregar as mensagens');
    });
}

function showAlert(type, message) {
    Swal.fire({
        icon: type,
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
}

function scrollToBottom() {
    const container = document.getElementById('text');
    container.scrollTop = container.scrollHeight;
}

function sendMessage(event) {
    event.preventDefault();

    const content = document.getElementById('message-content').value.trim();
    if (!content) {
        showAlert('error', 'Você não pode enviar uma mensagem vazia.');
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
        if (data.status === 'success') {
            document.getElementById('message-content').value = '';
            loadMessages(receiverId); 
            showAlert('success', data.message);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', 'Ocorreu um erro ao enviar a mensagem. Tente novamente.');
    })
    .finally(() => {
        sendButton.disabled = false; 
    });
}

document.getElementById('message-content').addEventListener('input', function() {
    const sendButton = document.getElementById('send-button');
    sendButton.disabled = this.value.trim() === ''; 
});

    </script>
</body>
