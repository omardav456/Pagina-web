document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("instruccionesModal");
    const startButton = document.getElementById("startButton");
    const closeButton = document.querySelector(".close");

    // Mostrar el modal
    modal.style.display = "block";

    // Cuando el usuario hace clic en el botón de empezar
    startButton.onclick = () => {
        modal.style.display = "none"; // Cerrar el modal
        initGame(); // Iniciar el juego
    }

    // Cuando el usuario hace clic en el botón de cerrar
    closeButton.onclick = () => {
        modal.style.display = "none"; // Cerrar el modal
    }

    // Cuando el usuario hace clic fuera del modal
    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = "none"; // Cerrar el modal
        }
    }
});

const tablero = document.querySelector(".tablero");
const scoreElement = document.querySelector(".puntaje");
const puntajeElement = document.querySelector(".premio");
const vidasElement = document.querySelector(".vidas");
const maxPremioElement = document.getElementById("maxPremio");

let GameOver = false;
let comidax, comiday;
let serpx = 5, serpy = 10;
let serpBody = [];
let velocidadx = 0, velocidady = 0;
let setIntervalId;
let score = 0;
let vidas = 3;

vidasElement.innerHTML = `Vidas: ${vidas}`;
scoreElement.innerHTML = `Puntaje: ${score}`;

const totalPremio = parseFloat(maxPremioElement.innerText.replace(/[^0-9.-]+/g, ""));
const niveles = [
    { puntaje: 5, premio: totalPremio * 0.1 },
    { puntaje: 30, premio: totalPremio * 0.4 },
    { puntaje: 40, premio: totalPremio * 0.8 },
    { puntaje: 60, premio: totalPremio * 1 }
];

const posicionComida = () => {
    comidax = Math.floor(Math.random() * 30) + 1;
    comiday = Math.floor(Math.random() * 30) + 1;
}

const getPremioPorPuntaje = (score) => {
    for (let i = niveles.length - 1; i >= 0; i--) {
        if (score >= niveles[i].puntaje) {
            return niveles[i].premio;
        }
    }
    return 0;
};

const formatCurrency = (amount) => {
    return amount.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
};

const enviarFormulario = (premio) => {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; // Cambia esto si necesitas una acción específica

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'premio';
    input.value = premio;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
};

const preguntarReclamarPremio = () => {
    const premioActual = getPremioPorPuntaje(score);
    const deseaReclamar = confirm(`¡Has alcanzado un premio! Tu puntaje es ${score}. ¿Deseas reclamar tu premio de ${formatCurrency(premioActual)} y terminar el juego?`);
    if (deseaReclamar) {
        GameOver = true;
        clearInterval(setIntervalId);
        enviarFormulario(premioActual);
        alert(`Juego finalizado. ¡Felicidades! Has reclamado tu premio de ${formatCurrency(premioActual)} con un puntaje de ${score}.`);
        window.location.href = 'evento.php'; // Redirigir a evento.php
    }
};

const initGame = () => {
    if (GameOver) return;
    let htmlMarkup = `<div class="comida" style="grid-area: ${comiday} / ${comidax}"></div>`;

    if (serpx === comidax && serpy === comiday) {
        posicionComida();
        serpBody.push([comidax, comiday]);
        score++;

        const premioActual = getPremioPorPuntaje(score);
        scoreElement.innerHTML = `Puntaje: ${score}`;
        puntajeElement.innerHTML = `Premio: ${formatCurrency(premioActual)}`;

        if (score >= 60) {
            alert("¡Buen trabajo! Has alcanzado el puntaje máximo.");
            clearInterval(setIntervalId);
        }
    }

    for (let i = serpBody.length - 1; i > 0; i--) {
        serpBody[i] = serpBody[i - 1];
    }
    serpBody[0] = [serpx, serpy];

    serpx += velocidadx;
    serpy += velocidady;

    if (serpx <= 0 || serpx > 30 || serpy <= 0 || serpy > 30) {
        restarVida();
    }

    for (let i = 0; i < serpBody.length; i++) {
        htmlMarkup += `<div class="serpiente" style="grid-area: ${serpBody[i][1]} / ${serpBody[i][0]}"></div>`;
        if (i !== 0 && serpBody[0][1] === serpBody[i][1] && serpBody[0][0] === serpBody[i][0]) {
            restarVida();
        }
    }

    tablero.innerHTML = htmlMarkup;
}

const restarVida = () => {
    vidas--;
    vidasElement.innerHTML = `Vidas: ${vidas}`;

    if (vidas === 0) {
        GameOver = true;
        alert("Has perdido todas las vidas. El juego ha terminado.");
    } else {
        const premioActual = getPremioPorPuntaje(score);
        
        if (premioActual > 0) {
            const deseaContinuar = confirm(`Has alcanzado un premio de ${formatCurrency(premioActual)}. ¿Deseas seguir jugando? Si decides seguir, el puntaje se reiniciará a 0.`);
            if (deseaContinuar) {
                // Reiniciar el juego
                serpx = 5;
                serpy = 10;
                velocidadx = 0;
                velocidady = 0;
                serpBody = [];
                score = 0; // Reiniciar puntaje
                scoreElement.innerHTML = `Puntaje: ${score}`;
                puntajeElement.innerHTML = `Premio: ${formatCurrency(0)}`; // Reiniciar premio mostrado
            } else {
                // El jugador decide retirarse con el premio
                GameOver = true;
                clearInterval(setIntervalId);
                enviarFormulario(premioActual);
                alert(`¡Felicidades! Has reclamado tu premio de ${formatCurrency(premioActual)}.`);
                
            }
        } else {
            // Si no hay premio, reiniciar el juego normalmente
            serpx = 5;
            serpy = 10;
            velocidadx = 0;
            velocidady = 0;
            serpBody = [];
            score = 0;
            scoreElement.innerHTML = `Puntaje: ${score}`;
        }
    }
}

const direccion = (e) => {
    if (GameOver) return;
    if (e.key === "ArrowUp" && velocidady !== 1) {
        velocidadx = 0;
        velocidady = -1;
    } else if (e.key === "ArrowDown" && velocidady !== -1) {
        velocidadx = 0;
        velocidady = 1;
    } else if (e.key === "ArrowLeft" && velocidadx !== 1) {
        velocidadx = -1;
        velocidady = 0;
    } else if (e.key === "ArrowRight" && velocidadx !== -1) {
        velocidadx = 1;
        velocidady = 0;
    }
}

posicionComida();
setIntervalId = setInterval(initGame, 125);
document.addEventListener("keydown", direccion);
