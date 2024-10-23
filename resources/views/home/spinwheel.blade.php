@include('home.css')
@include('home.header')

<style>
    /* Estilo da seção de boas-vindas */
.welcome-section {
    text-align: center;
    margin: 40px 0; /* Aumenta o espaçamento ao redor da seção */
    padding: 20px;
}

/* Título da seção de boas-vindas */
.welcome-section .title {
    font-family: 'Segoe UI', sans-serif;
    font-size: 36px; /* Aumenta o tamanho do título */
    font-weight: bold;
    color: #34C759;
}

/* Texto descritivo */
.welcome-section .description {
    font-family: 'Segoe UI', sans-serif;
    font-size: 18px; /* Tamanho ligeiramente maior para o texto */
    color: #333;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

    .wheel-container {
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Alinha a roleta e a seção de controle na parte superior */
        margin-top: 50px;
    }

    .wheel {
        display: flex;
        position: relative;
        margin-right: 50px; /* Espaçamento à direita da roleta */
    }

  .center-circle {
    width: 65px;
    height: 65px;
    border-radius: 100px;
    background-color: #fff;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 217px;
    box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.3);
    border: 3px solid #000;
    font-family: 'Segoe UI', sans-serif;
    font-weight: bold;
    font-size: 14px;
    transition: all 0.3s ease;
}

.center-circle:hover {
    background-color: #007BFF; /* Azul suave no hover */
    color: #fff;
    box-shadow: 0px 0px 15px rgba(0, 123, 255, 0.6);
    border: 3px solid #0056b3;
}


   .triangle {
    width: 0;
    height: 0;
    border-top: 20px solid transparent;
    border-bottom: 15px solid transparent;
    border-right: 40px solid #000;
    position: absolute;
    top: 50%;
    right: -390%; /* Mantém a seta fora da roleta */
    transform: translateY(-50%) rotate(0deg); /* Rotação inicial */
    transition: transform 0.05s ease-out; /* Suave transição ao rodar */
}


    textarea {
        background-color: rgba(20, 20, 20, 0.5); 
        caret-color: #fff;
        color: #fff;
        border: none; /* Remove a borda padrão */
        resize: none; /* Desabilita redimensionamento */
        border-radius: 5px; /* Bordas arredondadas */
        padding: 10px; /* Padding para textarea */
    }

    .controls {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s; /* Adiciona transição ao botão */
    }

    .btn:hover {
        background-color: #0056b3;
    }

    /* Estilo para a lista de jogadores */
    .team-table-container {
        margin: 20px auto;
        width: 400px; /* Ajuste a largura conforme necessário */
        background-color: rgba(50, 50, 50, 0.8); /* Fundo para a tabela de equipes */
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); /* Sombra mais escura */
        border: 2px solid #007BFF; /* Borda azul */
    }

    table {
        width: 100%; /* Largura total da tabela */
        border-collapse: collapse; /* Remove espaços entre as células */
    }

    th, td {
        padding: 8px; /* Padding nas células */
        border: 1px solid #007BFF; /* Borda das células */
        text-align: center; /* Centraliza o texto */
        color: #fff; /* Cor do texto */
    }

    th {
        background-color: rgba(0, 123, 255, 0.7); /* Fundo das cabeçalhos */
    }

    td {
        background-color: rgba(70, 70, 70, 0.8); /* Fundo das células */
    }

    /* Estilo para selecionar o número de equipes */
    .team-selector {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 20px;
        background-color: rgba(50, 50, 50, 0.8); /* Fundo para a seção de seleção */
        padding: 15px;
        border-radius: 10px; /* Bordas arredondadas */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); /* Sombra para a seção */
    }

    .team-selector input, .team-selector select {
        padding: 10px;
        border-radius: 5px;
        border: none;
        background-color: rgba(20, 20, 20, 0.5);
        color: #fff;
    }

    .team-selector input::placeholder,
    .team-selector select {
        color: #bbb; /* Cor do placeholder */
    }
</style>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Nova Seção de Título e Explicação -->
    <div class="welcome-section">
        <h1 class="title">Bem-vindo à Roleta</h1>
        <p class="description">
            Adicione os jogadores à lista, escolha o número de equipas e o tipo de desporto. Ao girar a roleta, os jogadores serão distribuídos automaticamente entre as equipas. Divirta-se e boa sorte!
        </p>
    </div>

    <!-- O restante do conteúdo do site -->
    <div class="wheel-container">
        <!-- Conteúdo da roleta e controles -->
    </div>

</body>


<body class="bg-gray-100 flex flex-col min-h-screen">
    <div class="wheel-container">
        <div class="wheel">
            <canvas id="canvas" width="500" height="500"></canvas>
            <div class="center-circle" onclick="spin()">Girar
                <div class="triangle"></div>
            </div>
        </div>

        <div>
            <div class="team-selector">
                <input type="number" id="team-count" placeholder="Número de equipes" min="2" value="2">
                <select id="sport-type" onchange="updateSportType()">
                    <option value="futebol">Futebol</option>
                    <option value="futebol 7">Futebol 7</option>
                    <option value="futsal">Futsal</option>
                    <option value="basquetebol">Basquetebol</option>
                    <option value="voleibol">Voleibol</option>
                    <option value="andebol">Andebol</option> 
                    <option value="ténis">Ténis</option>
                    <option value="raguebi">Raguebi</option> 
                    <option value="padel">Padel</option>
                    
                </select>
            </div>

            <div class="inputArea">
                <textarea id="player-list" rows="10" style="width: 500px;" placeholder="Adicione jogadores separados por linha..."></textarea>
            </div>            

            <div class="controls">
                <button class="btn" onclick="addPlayer()">Adicionar Jogador</button>
                <button class="btn" onclick="spin()">Rodar</button>
            </div>

            <!-- Tabela para exibir jogadores nas equipes -->
            <div class="team-table-container">
                <h2 class="text-center text-lg font-bold text-white">Distribuição de Jogadores</h2>
                <table id="team-table">
                    <thead>
                        <tr>
                            <th>Equipa</th>
                            <th>Jogadores</th>
                        </tr>
                    </thead>
                    <tbody id="team-body">
                        <!-- Os jogadores serão preenchidos aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@include('home.footer')

<script>
    // Funções para manipulação de cores e graus
    function randomColor() {
        r = Math.floor(Math.random() * 255);
        g = Math.floor(Math.random() * 255);
        b = Math.floor(Math.random() * 255);
        return { r, g, b };
    }

    function toRad(deg) {
        return deg * (Math.PI / 180.0);
    }

    function randomRange(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function easeOutSine(x) {
        return Math.sin((x * Math.PI) / 2);
    }

    function getPercent(input, min, max) {
        return (((input - min) * 100) / (max - min)) / 100;
    }

    const canvas = document.getElementById("canvas");
    const ctx = canvas.getContext("2d");
    const width = canvas.width;
    const height = canvas.height;

    const centerX = width / 2;
    const centerY = height / 2;
    const radius = width / 2.10;

    let items = []; // Lista de jogadores
    let teams = []; // Equipes criadas
    let colors = [];
    let currentDeg = 0;
    let step = 360 / items.length;
    let itemDegs = {};

    function createWheel() {
        colors = []; 
        step = 360 / items.length;
        for (let i = 0; i < items.length; i++) {
            colors.push(randomColor());
        }
        draw();
    }

    function draw() {
        ctx.clearRect(0, 0, width, height);
        
        // Borda ao redor da roleta, sempre presente, mesmo quando vazia
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, toRad(0), toRad(360));
        ctx.fillStyle = `rgb(${33},${33},${33})`; // Cor de fundo quando não há jogadores
        ctx.lineWidth = 3;  // Largura da borda ao redor da roleta
        ctx.stroke();  // Aplica a borda ao redor da roleta
    
        // Caso não tenha jogadores, manter apenas a borda
        if (items.length === 0) {
            return;
        }
    
        let startDeg = currentDeg;
        for (let i = 0; i < items.length; i++, startDeg += step) {
            let endDeg = startDeg + step;
    
            // Desenhar o slice com cor
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, toRad(startDeg), toRad(endDeg));
            ctx.fillStyle = `rgb(${colors[i].r}, ${colors[i].g}, ${colors[i].b})`;
            ctx.fill();
            
            // Adicionar borda fina ao redor de cada slice
            ctx.lineWidth = 1;  // Define a borda fina ao redor dos slices
            ctx.strokeStyle = '#fff'; // Cor da borda fina
            ctx.stroke();  // Aplica a borda ao slice
            
            ctx.restore();
    
            // Desenhar o nome dentro do slice
            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(toRad(startDeg + step / 2));
            ctx.fillStyle = (colors[i].r + colors[i].g + colors[i].b) < 128 ? "#fff" : "#000";
            ctx.font = 'bold 24px "Segoe UI"';  // Fonte moderna para os nomes
            ctx.fillText(items[i], 130, 10);
            
            // Adicionar bordas finas ao redor do texto
            ctx.lineWidth = 0.5;
            ctx.strokeStyle = '#000';  // Borda preta ao redor do texto
            ctx.strokeText(items[i], 130, 10);
            
            ctx.restore();
    
            itemDegs[items[i]] = { startDeg, endDeg };
        }
    }
    
    
    

    let speed = 0;
    let maxRotation = 0;
    let pause = false;

    function animateTriangleBounce() {
        const triangle = document.querySelector('.triangle');
        
        // Simula o "salto" da seta para cima e depois para baixo
        triangle.style.transform = 'translateY(-40%) rotate(-40deg)'; // Gira levemente para simular a batida
        setTimeout(() => {
            triangle.style.transform = 'translateY(-50%) rotate(0deg)'; // Volta à posição original
        }, 100); // Tempo rápido para o efeito de "batida"
    }
    
    let lastAngle = 0;

    function animate() {
        if (pause) {
            clearInterval(triangleAnimation); // Para a animação da seta
            return;
        }
    
        const speedControl = 35; 
        speed = easeOutSine(getPercent(currentDeg, maxRotation, 0)) * speedControl;
        
        // Verificar se passou por uma nova seção (segmento da roleta)
        const stepAngle = 360 / items.length; // O ângulo de cada item da roleta
        if (Math.floor(currentDeg / stepAngle) !== Math.floor(lastAngle / stepAngle)) {
            animateTriangleBounce(); // Animação da seta
        }
        lastAngle = currentDeg;
    
        if (speed < 0.01) {
            speed = 0;
            pause = true;
    
            const adjustedDeg = (360 - (currentDeg % 360) + step / 2) % 360;
            const winningItem = items.find((item, index) => {
                const startDeg = (index * step) % 360;
                const endDeg = ((index + 1) * step) % 360;
                if (startDeg < endDeg) {
                    return adjustedDeg >= startDeg && adjustedDeg < endDeg;
                } else {
                    return adjustedDeg >= startDeg || adjustedDeg < endDeg;
                }
            });
    
            if (winningItem) {
                allocateToRandomTeam(winningItem);
                removeItem(winningItem);
            }
        }
    
        currentDeg += speed;
        draw();
        window.requestAnimationFrame(animate);
    }
    

    function spin() {
        if (speed !== 0) return;

        maxRotation = (360 * 6) + randomRange(0, 360);
        currentDeg = 0;
        pause = false;
        window.requestAnimationFrame(animate);
    }

    let currentTeamIndex = 0; // Para controlar a alocação cíclica

    function allocateToRandomTeam(winningItem) {
        // Aloca o jogador para a equipe atual de forma cíclica
        if (teams.length === 0) return;
    
        // Adiciona o jogador à equipe atual
        teams[currentTeamIndex].push(winningItem);
    
        // Atualiza o índice da equipe para a próxima
        currentTeamIndex = (currentTeamIndex + 1) % teams.length;
    
        // Atualiza a exibição das equipes
        updateTeamDisplay();
    }
    

    function addPlayer() {
        const playerNames = document.getElementById("player-list").value.trim().split('\n');
        const uniqueNames = [...new Set(playerNames)]; // Remove nomes duplicados
    
        // Filtra apenas os nomes que não estão na lista atual
        const newNames = uniqueNames.filter(name => !items.includes(name) && name.trim() !== '');
    
        // Verificação do número total de jogadores
        const sportType = document.getElementById("sport-type").value;
        let minPlayersPerTeam;
    
        // Define o número mínimo de jogadores por equipe com base no tipo de esporte
        switch (sportType) {
            case 'futebol':
                minPlayersPerTeam = 11; // 11 jogadores por equipe
                break;
            case 'futebol 7':
                minPlayersPerTeam = 7; // 7 jogadores por equipe
                break;
            case 'futsal':
                minPlayersPerTeam = 5; // 5 jogadores por equipe
                break;
            case 'basquetebol':
                minPlayersPerTeam = 5; // 5 jogadores por equipe
                break;
            case 'voleibol':
                minPlayersPerTeam = 6; // 6 jogadores por equipe
                break;
            case 'andebol':
                minPlayersPerTeam = 7; // 7 jogadores por equipe
                break;
            case 'ténis':
                minPlayersPerTeam = 2; // 2 jogadores por equipe
                break;
            case 'raguebi':
                minPlayersPerTeam = 15; // 15 jogadores por equipe
                break;
            case 'padel':
                minPlayersPerTeam = 2; // 2 jogadores por equipe
                break;
            default:
                minPlayersPerTeam = 1; // Valor padrão
        }
    
        const totalTeams = parseInt(document.getElementById("team-count").value);
        const totalPlayers = items.length + newNames.length; // Conta novos jogadores que estão prestes a ser adicionados
    
        // Verifique se o número total de jogadores é suficiente para as equipes
        if (totalPlayers < minPlayersPerTeam * totalTeams) {
            alert(`Você precisa de pelo menos ${minPlayersPerTeam * totalTeams} jogadores para ${totalTeams} equipa(s) de ${sportType}.`);
            return;
        }
    
        if (newNames.length === 0) {
            alert('Todos os jogadores já estão na roleta ou não foram adicionados novos.');
            return;
        }
    
        // Se a quantidade for suficiente, adiciona os novos jogadores
        items.push(...newNames);
        teams = Array.from({ length: totalTeams }, () => []); // Reinicia as equipes
        createWheel();
        updateTeamDisplay();
    }

    function removeItem(item) {
        items = items.filter(i => i !== item);
        document.getElementById("player-list").value = items.join("\n");
        createWheel();
    }

    function updateTeamDisplay() {
        const teamBody = document.getElementById("team-body");
        teamBody.innerHTML = ""; // Limpa a lista atual das equipes

        teams.forEach((team, index) => {
            const row = document.createElement("tr");
            const teamCell = document.createElement("td");
            const playerCell = document.createElement("td");
            teamCell.textContent = `Equipe ${index + 1}`;
            playerCell.textContent = team.join(", ") || "Nenhum jogador"; // Exibe "Nenhum jogador" se não houver jogadores

            row.appendChild(teamCell);
            row.appendChild(playerCell);
            teamBody.appendChild(row);
        });
    }

    function updateSportType() {
        const totalTeams = parseInt(document.getElementById("team-count").value);
        const sportType = document.getElementById("sport-type").value;
        let minPlayersPerTeam;
    
        // Define o número mínimo de jogadores por equipe com base no tipo de esporte
        switch (sportType) {
            case 'futebol':
                minPlayersPerTeam = 11; // 11 jogadores por equipe
                break;
            case 'futebol 7':
                minPlayersPerTeam = 7; // 7 jogadores por equipe
                break;
            case 'futsal':
                minPlayersPerTeam = 5; // 5 jogadores por equipe
                break;
            case 'basquetebol':
                minPlayersPerTeam = 5; // 5 jogadores por equipe
                break;
            case 'voleibol':
                minPlayersPerTeam = 6; // 6 jogadores por equipe
                break;
            case 'andebol':
                minPlayersPerTeam = 7; // 7 jogadores por equipe
                break;
            case 'ténis':
                minPlayersPerTeam = 2; // 2 jogadores por equipe
                break;
            case 'raguebi':
                minPlayersPerTeam = 15; // 15 jogadores por equipe
                break;
            case 'padel':
                minPlayersPerTeam = 2; // 2 jogadores por equipe
                break;
            default:
                minPlayersPerTeam = 1; // Valor padrão
        }
    
        const totalPlayers = items.length;
    
        // Verifique se o número total de jogadores é suficiente para as equipes
        if (totalPlayers < minPlayersPerTeam * totalTeams) {
            alert(`Você precisa de pelo menos ${minPlayersPerTeam * totalTeams} jogadores para ${totalTeams} equipa(s) de ${sportType}.`);
        }
    }
    
function rotateTriangle() {
    const triangle = document.querySelector('.triangle');
    // Aplica rotação à seta sem alterar sua posição original
    triangle.style.transform = `translateY(-50%) rotate(${currentDeg}deg)`;
}

    createWheel();
</script>
