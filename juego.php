<?php
    session_start();
    include 'funcionalidadCupones.php';
    
    $_SESSION['descuento']=5000;
      
          
          if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['premio'])) {
            if(intval( $_SESSION['id'])===0){
              $_SESSION['fake']=true;
            }else{
              $premio = intval($_POST['premio']);
              agregarCupon(intval($_SESSION['id']), intval($premio));
              
              echo"<script>
              alert('Felicidades ganaste:".$_POST['premio']."');
              window.location.href = 'evento.php'; // Redirigir a evento.php
              </script>";
              //$_SESSION['agregado']=true;
            }
        }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Snake Game</title>
    <link rel="stylesheet" href="stylejuegofinal.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <div class="wrapper">
        <div class="game-details">
            <div class="vidas">Vidas: 3</div>
            <div class="puntaje">Puntaje: </div>
            <div class="premio">Premio: </div>
        </div>
        <div class="tablero"></div>
    </div>

    <!-- Modal de instrucciones -->
    <div id="instruccionesModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Instrucciones del Juego</h2>
            <p><strong>Cómo jugar:</strong></p>
            <ul>
                <li>El juego es el clásico Snake. Consiste en comer la mayor cantidad de frutas. Al comerlas la serpiente crece. Ten cuidado con chocar con el límite del mapa y tu propio cuerpo.</li>
                <li>Para ganar debes comer la cantidad de frutas necesarias para cada premio. Para esto tienes 3 vidas, además, si tienes vidas y ganaste un premio menor o mediano, puedes arriesgarlo para ganar un premio mayor.</li>
            </ul>
            <p><strong>Premios:</strong></p>
               <li>Alcanza 5 puntos para el primer premio. </li> 
               <li>Alcanza 30 puntos para el segundo premio. </li>
               <li>Alcanza 40 puntos para el tercer premio. </li>
               <li>Alcanza 60 puntos para el premio mayor. </li>
            <button id="startButton">¡Jugar!</button>
        </div>
    </div>
    
    <!-- Elemento que contiene el premio máximo -->
    <div id="maxPremio" style="display: none;"><?php echo $_SESSION['descuento']; ?></div>

    <script src="scriptjuego.js"></script>
</body>
</html>

