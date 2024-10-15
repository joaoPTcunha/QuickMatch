document.getElementById("menu-toggle").addEventListener("change", function () {
    const dropdownMenu = document.getElementById("dropdown-menu");
    dropdownMenu.classList.toggle("hidden");
});
const sectors = [
    { color: "#FFBC03", text: "#333333", label: "Doces" },
    { color: "#FF5A10", text: "#333333", label: "Sorteio" },
    { color: "#FFBC03", text: "#333333", label: "Doces" },
    { color: "#FF5A10", text: "#333333", label: "Sorteio" },
    { color: "#FFBC03", text: "#333333", label: "Doces + Sorteio" },
    { color: "#FF5A10", text: "#333333", label: "Perdeu" },
    { color: "#FFBC03", text: "#333333", label: "Sorteio" },
    { color: "#FF5A10", text: "#333333", label: "Doces" },
];

const spinButton = document.querySelector("#spin-btn");
const resultDisplay = document.querySelector("#result");
const canvas = document.querySelector("#wheel");
const ctx = canvas.getContext("2d");
const dia = canvas.width;
const rad = dia / 2;
const arc = (2 * Math.PI) / sectors.length;

let angle = 0;
let angularVelocity = 0;
const friction = 0.99;

function drawWheel() {
    sectors.forEach((sector, index) => {
        const startAngle = index * arc;
        const endAngle = startAngle + arc;

        // Draw sector
        ctx.beginPath();
        ctx.fillStyle = sector.color;
        ctx.moveTo(rad, rad);
        ctx.arc(rad, rad, rad, startAngle, endAngle);
        ctx.fill();

        // Draw text
        ctx.save();
        ctx.translate(rad, rad);
        ctx.rotate(startAngle + arc / 2);
        ctx.textAlign = "right";
        ctx.fillStyle = sector.text;
        ctx.font = "bold 16px 'Poppins', sans-serif";
        ctx.fillText(sector.label, rad - 10, 10);
        ctx.restore();
    });
}

function rotateWheel() {
    canvas.style.transform = `rotate(${angle}rad)`;
    angle += angularVelocity;
    angularVelocity *= friction;

    if (angularVelocity < 0.001) {
        angularVelocity = 0;
        const winningIndex =
            Math.floor((2 * Math.PI - (angle % (2 * Math.PI))) / arc) %
            sectors.length;
        resultDisplay.textContent = `Parabéns! Você ganhou: ${sectors[winningIndex].label}`;
    } else {
        requestAnimationFrame(rotateWheel);
    }
}

spinButton.addEventListener("click", () => {
    if (angularVelocity === 0) {
        angularVelocity = Math.random() * 0.4 + 0.2;
        resultDisplay.textContent = "";
        rotateWheel();
    }
});

drawWheel();
