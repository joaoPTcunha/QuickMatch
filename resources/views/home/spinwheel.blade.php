@include('home.css')
@include('home.header')

<style>
    .wheel {
        display: flex;
        justify-content: center;
        position: relative;
    }

    .center-circle {
        width: 100px;
        height: 100px;
        border-radius: 60px;
        background-color: #fff; 
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.3); 
    }

    .triangle {
        width: 0;
        height: 0;
        border-top: 20px solid transparent;
        border-bottom: 15px solid transparent;
        border-right: 40px solid #000;
        position: absolute;
        top: 50%;
        right: -220%;
        transform: translateY(-50%);
    }

    textarea {
        background-color: rgba(20, 20, 20, 0.5); 
        caret-color: #fff;
        resize: none;
        color: #fff;
    }

    .inputArea {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .controls {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #fff;
        color: #333;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #ddd;
    }
</style>

<div class="wheel">
    <canvas id="canvas" width="500" height="500"></canvas>
    <div class="center-circle" onclick="spin()">Girar
        <div class="triangle"></div>
    </div>
</div>

<div class="inputArea">
    <textarea id="player-list" rows="10" cols="30">jogador 1
jogador2
jogador3
jogador4</textarea>
</div>

<div class="controls">
    <label for="speed-control">Velocidade:</label>
    <input type="range" id="speed-control" min="1" max="10" value="5">
    <button class="btn" onclick="spin()">Rodar</button>
</div>

<div id="winner" class="text-center text-white mt-4"></div>

<script>
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
    const radius = width / 2;

    let items = document.getElementById("player-list").value.split("\n");
    let currentDeg = 0;
    let step = 360 / items.length;
    let colors = [];
    let itemDegs = {};

    function createWheel() {
        items = document.getElementById("player-list").value.split("\n").filter(item => item.trim() !== "");
        step = 360 / items.length;
        colors = [];
        for (let i = 0; i < items.length; i++) {
            colors.push(randomColor());
        }
        draw();
    }

    function draw() {
        ctx.clearRect(0, 0, width, height);
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, toRad(0), toRad(360));
        ctx.fillStyle = `rgb(${33},${33},${33})`;
        ctx.lineTo(centerX, centerY);
        ctx.fill();

        let startDeg = currentDeg;
        for (let i = 0; i < items.length; i++, startDeg += step) {
            let endDeg = startDeg + step;
            const color = colors[i];
            const colorStyle = `rgb(${color.r},${color.g},${color.b})`;
            const colorStyle2 = `rgb(${Math.max(0, color.r - 30)},${Math.max(0, color.g - 30)},${Math.max(0, color.b - 30)})`;

            ctx.beginPath();
            ctx.arc(centerX, centerY, radius - 2, toRad(startDeg), toRad(endDeg));
            ctx.fillStyle = colorStyle2;
            ctx.lineTo(centerX, centerY);
            ctx.fill();

            ctx.beginPath();
            ctx.arc(centerX, centerY, radius - 30, toRad(startDeg), toRad(endDeg));
            ctx.fillStyle = colorStyle;
            ctx.lineTo(centerX, centerY);
            ctx.fill();

            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(toRad((startDeg + endDeg) / 2));
            ctx.textAlign = "center";
            ctx.fillStyle = (color.r > 150 || color.g > 150 || color.b > 150) ? "#000" : "#fff";
            ctx.font = 'bold 24px serif';
            ctx.fillText(items[i], 130, 10);
            ctx.restore();

            itemDegs[items[i]] = { startDeg, endDeg };
        }
    }

    let speed = 0;
    let maxRotation = 0;
    let pause = false;

    function animate() {
        if (pause) return;
        const speedControl = document.getElementById('speed-control').value;
        speed = easeOutSine(getPercent(currentDeg, maxRotation, 0)) * speedControl;
        if (speed < 0.01) {
            speed = 0;
            pause = true;
            const winningItem = Object.keys(itemDegs).find(
                item => itemDegs[item].startDeg <= (360 - currentDeg % 360) &&
                        itemDegs[item].endDeg > (360 - currentDeg % 360)
            );
            document.getElementById("winner").innerHTML = `Parabéns! Você ganhou: ${winningItem}`;
            removeItem(winningItem);
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
        createWheel();
        window.requestAnimationFrame(animate);
    }

    function removeItem(item) {
        items = items.filter(i => i !== item);
        document.getElementById("player-list").value = items.join("\n");
        createWheel();
    }

    createWheel();
</script>
