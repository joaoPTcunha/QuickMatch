@include('home.css')
@include('home.header')
<style>
    .triangle {
        width: 0;
        height: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-right: 20px solid #000;
        position: absolute;
        top: -16%;
        left: calc(20% + 0.5rem);
        transform: translateY(-50%) rotate(90deg);
        transition: transform 0.05s ease-out;
    }

    @media (max-width: 640px) {
        .triangle {
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-right: 15px solid #000;
            top: -15%;
            left: calc(25% + 0.3rem);
        }
    }
</style>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <div class="flex justify-center w-full max-w-6xl mx-auto p-4">
        <div class="text-center">
            <h1 class="font-semibold text-3xl sm:text-4xl text-black">Bem-vindo à Roleta</h1>
            <p class="text-lg text-gray-700 mt-2 mx-auto max-w-xl leading-relaxed">
                Adicione os jogadores à lista, escolha o número de equipas e o tipo de desporto. Ao girar a roleta, os jogadores serão distribuídos automaticamente entre as equipas. Divirta-se e boa sorte!
            </p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row items-start w-full max-w-6xl mx-auto p-4 space-y-8 lg:space-y-2 flex-grow">
        <div class="lg:w-1/2 w-full flex justify-center lg:justify-start">
            <div class="relative w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
                <canvas id="canvas" class="w-full h-auto" style="max-width: 200%" width="500" height="500"></canvas>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white w-12 h-12 sm:w-16 sm:h-16 rounded-full flex justify-center items-center shadow-lg border-2 border-black font-bold text-lg cursor-pointer hover:bg-blue-600 hover:text-white transition-all duration-300" onclick="spin()">
                    Girar
                    <div class="triangle absolute top-1/2 right-[-40px] transform -translate-y-1/2 rotate-0 transition-transform duration-150"></div>
                </div>
            </div>
        </div>

        <div class="lg:w-1/2 w-full">
            <div class="flex flex-wrap justify-center gap-5 mb-5 bg-white p-4 rounded-lg shadow-md border">
                <label for="team-count" class="text-gray-800 mt-2">Número de Equipas:</label>
                <input type="number" id="team-count" class="p-2 rounded bg-gray-100 text-gray-800 border border-gray-300 w-full sm:w-auto" placeholder="Número de equipas" min="2" value="2">
                <select id="sport-type" class="p-2 rounded bg-gray-100 text-gray-800 border border-gray-300 w-full sm:w-auto">
                    <option value="2x2">2x2</option>
                    <option value="3x3">3x3</option>
                    <option value="4x4">4x4</option>
                    <option value="5x5">5x5</option>
                    <option value="6x6">6x6</option>
                    <option value="7x7">7x7</option>
                    <option value="10x10">10x10</option>
                    <option value="12x12">12x12</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div class="w-full space-y-4">
                <textarea id="player-list" rows="5" class="w-full p-3 rounded bg-gray-100 text-gray-800 border border-gray-300 placeholder-gray-400" placeholder="Adiciona os jogadores aqui.."></textarea>

                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button class="btn p-3 bg-blue-800 text-white rounded shadow transition duration-300 hover:bg-blue-900 w-full sm:w-auto" onclick="addPlayer()">Adicionar Jogadores</button>
                </div>
            </div>

            <div class="team-table-container w-full p-4 mx-auto overflow-x-auto">
                <h2 class="text-center text-lg font-semibold text-black mb-3">Distribuição de Jogadores</h2>
                <table id="team-table" class="min-w-full table-auto bg-white text-sm border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border-gray-300 text-gray-800 p-2 bg-green-500">Equipa</th>
                            <th class="border-gray-300 text-gray-800 p-2 bg-blue-500">Jogadores</th>
                        </tr>
                    </thead>
                    <tbody id="team-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('home.footer')
</body>

<script>
    function randomColor() {
        r = Math.floor(Math.random() * 255);
        g = Math.floor(Math.random() * 255);
        b = Math.floor(Math.random() * 255);
        return {
            r,
            g,
            b
        };
    }

    const availableColors = [
        "#FF0000", // Vermelho
        "#00FF00", // Verde
        "#0000FF", // Azul
        "#FFFF00", // Amarelo
        "#FF8C00", // Laranja Escuro
        "#8B0000", // Vermelho Escuro
        "#4682B4", // Azul Aço
        "#708090", // Cinza Ardósia
        "#2F4F4F", // Verde Escuro
        "#B8860B", // Ouro Escuro
        "#5F9EA0", // Verde-azulado
        "#7B68EE", // Azul Médio
        "#6B8E23", // Verde Oliva
    ];

    let usedColors = new Map();
    let availableColorsList = [...availableColors];

    function getRandomUnusedColor() {
        if (availableColorsList.length === 0) {
            availableColorsList = [...availableColors];
        }
        const randomIndex = Math.floor(Math.random() * availableColorsList.length);
        const color = availableColorsList[randomIndex];
        availableColorsList.splice(randomIndex, 1);
        return color;
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

    let items = []; // JOGADORES
    let teams = []; // EQUIPAS
    let colors = ["#FF5733", "#33FF57", "#3357FF", "#FFC300", "#DAF7A6", "#581845", "#C70039"]; 
    let itemDegs = {};
    let currentPlayer = "";

    function createWheel() {
        step = 360 / items.length;
        draw();
    }

    function draw() {
        ctx.clearRect(0, 0, width, height);

        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, toRad(0), toRad(360));

        ctx.fillStyle = `rgb(${33},${33},${33})`; 
        ctx.lineWidth = 3;

        ctx.strokeStyle = items.length === 0 ? 'black' : 'rgb(255, 255, 255)'; 
        ctx.stroke();

        if (items.length === 0) {
            return; 
        }

        let startDeg = currentDeg;
        const step = 360 / items.length;

        for (let i = 0; i < items.length; i++) {
            let endDeg = startDeg + step;
            const player = items[i];

            if (!usedColors.has(player)) {
                usedColors.set(player, getRandomUnusedColor());
            }

            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, toRad(startDeg), toRad(endDeg));
            ctx.fillStyle = usedColors.get(player);
            ctx.fill();

            ctx.lineWidth = 1;
            ctx.strokeStyle = '#fff';
            ctx.stroke();

            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(toRad(startDeg + step / 2));
            ctx.fillStyle = "#fff";

            let fontSize = 24;
            ctx.font = `bold ${fontSize}px "Segoe UI"`;

            while (ctx.measureText(player).width > radius * 0.5 && fontSize > 10) {
                fontSize -= 1;
                ctx.font = `bold ${fontSize}px "Segoe UI"`; 
            }

            const textWidth = ctx.measureText(player).width;
            const textX = (radius * 0.5) - (textWidth / 2); 
            const textY = 10; 

            ctx.fillText(player, textX, textY); 

            ctx.restore();

            itemDegs[player] = {
                startDeg: (startDeg % 360 + 360) % 360,
                endDeg: (endDeg % 360 + 360) % 360
            };

            startDeg = endDeg;
        }
    }


    let speed = 0;
    let maxRotation = 0;
    let pause = false;
    let lastAngle = 0;

    function selectPlayer() {

        const pointerAngle = 270;

        let normalizedAngle = (currentDeg % 360 + 360) % 360;

        const stepAngle = 360 / items.length;

        let selectedIndex = Math.floor(((360 - normalizedAngle + pointerAngle) % 360) / stepAngle);
        selectedIndex = selectedIndex % items.length;

        if (selectedIndex >= 0 && selectedIndex < items.length) {
            currentPlayer = items[selectedIndex];
            allocateToRandomTeam(currentPlayer);

        }
    }


    function animate() {
        if (pause) {
            clearInterval(triangleAnimation);
            return;
        }

        const speedControl = 35;
        speed = easeOutSine(getPercent(currentDeg, maxRotation, 0)) * speedControl;

        const stepAngle = 360 / items.length; 
        lastAngle = currentDeg;

        if (speed < 0.01) {
            speed = 0;
            pause = true;

            selectPlayer();

            removeItem(currentPlayer);

            updateTeamDisplay();

            Swal.fire({
                title: `Jogador selecionado: ${currentPlayer}!`,
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                didOpen: () => {
                    const jsConfetti = new JSConfetti();
                    jsConfetti.addConfetti({
                        confettiColors: ['#f0f0f0', '#ff5733', '#00d1b2', '#6c63ff', '#ffd700'],
                        confettiRadius: 8,
                        confettiNumber: 400,
                        confettiGravity: 0.6,
                        confettiSpeed: 4,
                        confettiShape: 'circle',
                    });
                },
            });
        }

        currentDeg += speed;
        draw();
        window.requestAnimationFrame(animate);
    }


    function spin() {
        if (speed !== 0 || items.length === 0) return; 

        maxRotation = (360 * 6) + randomRange(0, 360); // Gira 6 voltas completas + um ângulo aleatório
        currentDeg = 90;
        pause = false; 
        window.requestAnimationFrame(animate);
    }


    function allocateToRandomTeam(player) {
        if (teams.length === 0) {
            const numTeams = 2;
            for (let i = 0; i < numTeams; i++) {
                teams.push([]);
            }
        }

        let minTeamIndex = 0;
        let minTeamSize = teams[0].length;

        for (let i = 1; i < teams.length; i++) {
            if (teams[i].length < minTeamSize) {
                minTeamSize = teams[i].length;
                minTeamIndex = i;
            }
        }

        teams[minTeamIndex].push(player);

        removeItem(player);

        updateTeamDisplay();
    }


    document.getElementById("player-list").addEventListener("input", updatePlayersFromTextarea);

    function updatePlayersFromTextarea() {
        const updatedPlayers = document.getElementById("player-list").value.trim().split('\n').map(name => name.trim()).filter(name => name !== '');

        items = items.filter(player => updatedPlayers.includes(player));

        createWheel();
        updateTeamDisplay();
    }


    function addPlayer() {
        const playerNames = document.getElementById("player-list").value.trim().split('\n');
        const uniqueNames = [...new Set(playerNames)];

        const newNames = uniqueNames.filter(name => !items.includes(name) && name.trim() !== '');

        const sportType = document.getElementById("sport-type").value;
        let minPlayersPerTeam;

        switch (sportType) {
            case '2x2':
                minPlayersPerTeam = 2;
                break;
            case '3x3':
                minPlayersPerTeam = 3;
                break;
            case '4x4':
                minPlayersPerTeam = 4;
                break;
            case '5x5':
                minPlayersPerTeam = 5;
                break;
            case '6x6':
                minPlayersPerTeam = 6;
                break;
            case '7x7':
                minPlayersPerTeam = 7;
                break;
            case '10x10':
                minPlayersPerTeam = 10;
                break;
            case '12x12':
                minPlayersPerTeam = 12;
                break;
            default:
                minPlayersPerTeam = 0;
        }

        const totalTeams = parseInt(document.getElementById("team-count").value);
        const totalPlayers = items.length + newNames.length;

        if (totalPlayers < minPlayersPerTeam * totalTeams) {
            Swal.fire({
                icon: 'error',
                title: 'Número insuficiente de jogadores',
                text: `Você precisa de pelo menos ${minPlayersPerTeam * totalTeams} jogadores para ${totalTeams} equipa(s) de ${sportType}.`,
            });
            return;
        }

        if (newNames.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Todos os jogadores já estão na roleta ou não foram adicionados novos.',
            });
            return;
        }

        newNames.forEach(player => {
            if (!usedColors.has(player)) {
                usedColors.set(player, getRandomUnusedColor());
            }
        });

        items.push(...newNames);
        teams = Array.from({
            length: totalTeams
        }, () => []);

        createWheel();
        updateTeamDisplay();

        document.getElementById("player-list").value = items.join("\n");
    }



    function removeItem(item) {
        const removedColor = usedColors.get(item);
        if (removedColor && !availableColorsList.includes(removedColor)) {
            availableColorsList.push(removedColor);
        }

        usedColors.delete(item);

        items = items.filter(i => i !== item);

        document.getElementById("player-list").value = items.join("\n");

        createWheel();
    }

    function updateTeamDisplay() {
        const teamBody = document.getElementById("team-body");
        teamBody.innerHTML = "";

        teams.forEach((team, index) => {
            const row = document.createElement("tr");
            const teamCell = document.createElement("td");
            const playerCell = document.createElement("td");
            teamCell.textContent = `Equipa ${index + 1}`;
            playerCell.textContent = team.join(", ") || "Nenhum jogador";

            teamCell.className = "text-center";
            playerCell.className = "text-center";

            row.appendChild(teamCell);
            row.appendChild(playerCell);
            teamBody.appendChild(row);
        });
    }

    function updateSportType() {
        const totalTeams = parseInt(document.getElementById("team-count").value);
        const sportType = document.getElementById("sport-type").value;
        let minPlayersPerTeam;

        switch (sportType) {
            case '2x2':
                minPlayersPerTeam = 2;
                break;
            case '3x3':
                minPlayersPerTeam = 3;
                break;
            case '4x4':
                minPlayersPerTeam = 4;
                break;
            case '5x5':
                minPlayersPerTeam = 5;
                break;
            case '6x6':
                minPlayersPerTeam = 6;
                break;
            case '7x7':
                minPlayersPerTeam = 7;
                break;
            case '10x10':
                minPlayersPerTeam = 10;
                break;
            case '12x12':
                minPlayersPerTeam = 12;
                break;
            default:
                minPlayersPerTeam = 0;
        }
    }
    createWheel();
</script>