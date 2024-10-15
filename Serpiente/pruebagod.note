const tablero = document.querySelector(".tablero");
const scoreElement = document.querySelector(".puntaje");
const puntajeElement = document.querySelector(".premio");

let GameOver = false;
let comidax, comiday;
let serpx = 5, serpy = 10;
let serpBody = [];
let velocidadx = 0, velocidady = 0;
let setIntervalId;
let score = 0;

let premio = localStorage.getItem("premio") || 0;

const posicionComida = () => {
    comidax = Math.floor(Math.random() * 30) + 1;
    comiday = Math.floor(Math.random() * 30) + 1;
}

const handlegameover = () => {
 clearInterval(setIntervalId);
        if (score >= 40) {
             alert("¡Buen trabajo! Has alcanzado el premio mediano");
           } else if (score >=30 ) {
              alert("¡Felicidades! Has alcanzado el premio menor ");
            } else {
               alert("Perdiste. ¡Sigue intentándolo!");
        }
    
 location.reload(); 
       
}

const direccion = (e) => {
    if (e.key === "ArrowUp" && velocidady != 1) {
        velocidadx = 0;
        velocidady = -1;
    } else if (e.key === "ArrowDown" && velocidady != -1) {
        velocidadx = 0;
        velocidady = 1;
    } else if (e.key === "ArrowLeft" && velocidadx != 1) {
        velocidadx = -1;
        velocidady = 0;
    } else if (e.key === "ArrowRight" && velocidadx != -1) {
        velocidadx = 1;
        velocidady = 0;
    }
}

const initGame = () => {
    if(GameOver)return handlegameover();
    let htmlMarkup = `<div class="comida" style="grid-area: ${comiday} / ${comidax}"></div>`;

    if (serpx === comidax && serpy === comiday) {
        posicionComida(); 
        serpBody.push([comidax, comiday]); 
        score++;
        
        premio = score >= premio ? score : premio
        scoreElement.innerHTML = `Puntaje: ${score}`;

        if (score <= 29) {
            puntajeElement.innerHTML = `Premio: 30`;
        } else if (score >= 30 && score <= 39) {
            puntajeElement.innerHTML = `Siguiente premio: 40`;
        } else if (score >= 40 && score <= 49) {
            puntajeElement.innerHTML = `Premio Máximo: 50`;
        } else if (score === 50) {
            alert("¡Buen trabajo! Has alcanzado el premio Maximo.");          
            clearInterval(setIntervalId); 
        }

    }

    for(let i = serpBody.length - 1; i > 0; i-- ){
        serpBody[i] = serpBody[i-1];
    }
    serpBody[0] = [serpx,serpy];

    serpx += velocidadx;
    serpy += velocidady;

    if(serpx <= 0 || serpx > 30 || serpy <= 0 || serpy > 30){
      GameOver=true
    }

    for(let i=0; i<serpBody.length; i++){
        htmlMarkup += `<div class="serpiente" style="grid-area: ${serpBody[i][1]} / ${serpBody[i][0]}"></div>`;
        if(i !==0 && serpBody[0][1] === serpBody[i][1] && serpBody[0][0] === serpBody[i][0]){
          GameOver=true;
        }
    }
    tablero.innerHTML = htmlMarkup;
}

posicionComida();
setIntervalId = setInterval(initGame, 125);
document.addEventListener("keydown", direccion);