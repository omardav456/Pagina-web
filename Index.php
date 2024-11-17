<?php
  session_start();
  include 'funcionalidadCarrito.php';

    
    if(!isset($_SESSION['id'])|| $_SESSION['id']===0){
      
    }else{
      
        
    }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['AñadirCarrito'])) {
          if(intval( $_SESSION['id'])===0){
            $_SESSION['fake']=true;
          }else{
            $id_producto = intval($_POST['AñadirCarrito']);
            
            $_SESSION['agregado']=agregarProducto(intval( $_SESSION['id']), $id_producto,1);

          }
          
      }
  





?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alkostico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<style>
  body{
    background-color: #f5f5dc; /* Gris claro */
  }
  .title{
    color:black;
    text-align: center;
    font-size: 2em;
    

  }
  .card-max {
    max-width: 300px; /* Ajusta el tamaño máximo según necesites */
    max-height: 500px; /* También puedes establecer un alto máximo */
    overflow: hidden; /* Para ocultar el contenido que exceda el tamaño */
}
.card-img-container {
    width: 100%; /* Asegura que el contenedor ocupe todo el ancho de la tarjeta */
    height: 200px; /* Establece una altura fija para el contenedor de la imagen */
    overflow: hidden; /* Oculta cualquier parte de la imagen que sobresalga */
}
    /* From Uiverse.io by JaydipPrajapati1910 */ 
    .card-img-top {
    width: 100%; /* Asegura que la imagen ocupe todo el ancho de la tarjeta */
    height: 100%; /* Establece una altura fija para las imágenes */
    object-fit: contain; /* Mantiene la proporción de la imagen y recorta el exceso */
}

    .button {
    --width: 100px;
    --height: 35px;
    --tooltip-height: 35px;
    --tooltip-width: 90px;
    --gap-between-tooltip-to-button: 18px;
    --button-color: #222;
    --tooltip-color: #fff;
    width: var(--width);
    height: var(--height);
    background: var(--button-color);
    position: relative;
    text-align: center;
    border-radius: 0.45em;
    font-family: "Arial";
    transition: background 0.3s;
  }
  
  .button::before {
    position: absolute;
    content: attr(data-tooltip);
    width: var(--tooltip-width);
    height: var(--tooltip-height);
    background-color: #555;
    font-size: 0.9rem;
    color: #fff;
    border-radius: .25em;
    line-height: var(--tooltip-height);
    bottom: calc(var(--height) + var(--gap-between-tooltip-to-button) + 10px);
    left: calc(50% - var(--tooltip-width) / 2);
  }
  
  .button::after {
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border: 10px solid transparent;
    border-top-color: #555;
    left: calc(50% - 10px);
    bottom: calc(100% + var(--gap-between-tooltip-to-button) - 10px);
  }
  
  .button::after,.button::before {
    opacity: 0;
    visibility: hidden;
    transition: all 0.5s;
  }
  
  .text {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .button-wrapper,.text,.icon {
    overflow: hidden;
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    color: #fff;
  }
  
  .text {
    top: 0
  }
  
  .text,.icon {
    transition: top 0.5s;
  }
  
  .icon {
    color: #fff;
    top: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .icon svg {
    width: 24px;
    height: 24px;
  }
  
  .button:hover {
    background: #222;
  }
  
  .button:hover .text {
    top: -100%;
  }
  
  .button:hover .icon {
    top: 0;
  }
  
  .button:hover:before,.button:hover:after {
    opacity: 1;
    visibility: visible;
  }
  
  .button:hover:after {
    bottom: calc(var(--height) + var(--gap-between-tooltip-to-button) - 20px);
  }
  
  .button:hover:before {
    bottom: calc(var(--height) + var(--gap-between-tooltip-to-button));
  }
  
  
  
  

</style>


<body>
      <!--==================== HEADER ====================-->
  <header class="header" id="header">
         <nav class="nav container-nav">
            <a href="Index.php" class="nav__logo">
               Alkostico
            </a>

            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li class="nav__item">
                     <a href="Categorias.php" class="nav__link">Catalogo</a>
                  </li>

                  <li class="nav__item">
                     <a href="carrito.php" class="nav__link">Carrito</a>
                  </li>

                  <li class="nav__item">
                     <a href="evento.php" class="nav__link">Eventos</a>
                  </li>

                  <li class="nav__">
                     <!-- Login button -->
                     <a href="usuario.php" class="ri-user-line nav__login" id="login-btn"></a>
                  </li>
               </ul>
               
               <!-- Close button -->
               <div class="nav__close" id="nav-close">
                  <i class="ri-close-line"></i>
               </div>
            </div>

            <!-- Toggle button -->
            <div class="nav__toggle" id="nav-toggle">
               <i class="ri-apps-2-line"></i>
            </div>
            
         </nav>
</header>

<?php
        if(isset($_SESSION['agregado']) && ($_SESSION['agregado'])) {
            //print "xd";
        echo "<script>
            Swal.fire({
                title: 'Notificación',
                text: '".$_SESSION['agregado']."',
                icon: 'info',
                timer: 5000
            });
        </script>";
        
        // Eliminar el mensaje después de mostrarlo
        unset($_SESSION['agregado']);
    }
    if(isset($_SESSION['fake']) && ($_SESSION['fake'])) {
      //print "xd";
  echo "<script>
      Swal.fire({
          title: 'Notificación',
          text: 'Inicia sesion primero',
          icon: 'warning',
          timer: 5000
      });
  </script>";
  
  // Eliminar el mensaje después de mostrarlo
  unset($_SESSION['fake']);
}
    ?>




  <?php
  // Datos de conexión
  $servername = "sql10.freemysqlhosting.net";  // Cambia esto si usas otro servidor
  $username = "sql10736060";         // Tu usuario de MySQL
  $password = "v3naSQAq5W";             // Tu contraseña de MySQL
  $dbname = "sql10736060";      // Nombre de tu base de datos
  
  // Crear la conexión
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Verificar la conexión
  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }
  
  // Consulta para obtener los productos
  $sql = "SELECT Id_Producto, Nombre_Producto, Descripcion_Producto, Cantidad_Producto, Precio_Producto, URL_Producto FROM Producto";
  $result = $conn->query($sql);
  $conn->close();
  ?>



<br><br><br><br>

<div>
  <div class="title-container">
    <h1 class="title">Productos</h1>
  </div>
  </div>

<?php
// Verificar si hay resultados
echo "<div class='container'>";
if ($result->num_rows > 0) {
    // Inicializamos un contador para controlar las filas
    $contador = 0;
    // Comenzamos la fila principal
    echo "<div class='row'>";
    // Generar una tarjeta Bootstrap por cada producto
    while ($row = $result->fetch_assoc()) {
        // Verificar si la cantidad de producto es mayor que 0
        if ($row["Cantidad_Producto"] > 0) {
            // Cada tarjeta ocupará espacio en la fila
            echo "
            <div class='col-12 col-sm-6 col-md-3 col-lg-3'>
                <div class='card w-95 h-95 card-max' style='margin-top: 20px;'>
                    <div class='card-img-container'>
                        <img src='" . $row["URL_Producto"] . "' class='card-img-top' alt='Imagen de producto'>
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>" . $row["Nombre_Producto"] . "</h5>
                        <p class='card-text'>Cantidad disponible: " . $row["Cantidad_Producto"] . "</p>
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='AñadirCarrito' value='" . $row['Id_Producto'] . "'>
                            <button type='submit' style='border: none; background: none; padding: 0; cursor: pointer;'>
                                <div data-tooltip='$" . $row['Precio_Producto'] . "' class='button'>
                                    <div class='button-wrapper'>
                                        <div class='text'>Comprar</div>
                                        <span class='icon'>
                                            <svg viewBox='0 0 16 16' class='bi bi-cart2' fill='currentColor' height='16' width='16' xmlns='http://www.w3.org/2000/svg'>
                                                <path d='M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z'></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </button>
                        </form>
                        
                        <!-- Formulario para enviar datos a otra página -->
                        <form action='detallesProducto.php' method='POST'>
                            <input type='hidden' name='idproducto' value='" . htmlspecialchars($row["Id_Producto"], ENT_QUOTES) . "'>
                            <input type='hidden' name='nombre' value='" . htmlspecialchars($row["Nombre_Producto"], ENT_QUOTES) . "'>
                            <input type='hidden' name='descripcion' value='" . htmlspecialchars($row["Descripcion_Producto"], ENT_QUOTES) . "'>
                            <input type='hidden' name='cantidad' value='" . htmlspecialchars($row["Cantidad_Producto"], ENT_QUOTES) . "'>
                            <input type='hidden' name='precio' value='" . htmlspecialchars($row["Precio_Producto"], ENT_QUOTES) . "'>
                            <input type='hidden' name='url' value='" . htmlspecialchars($row["URL_Producto"], ENT_QUOTES) . "'>
                            <button type='submit' class='btn btn-secondary mt-2'>Ver detalles</button>
                        </form>
                    </div>
                </div>
            </div>";

            // Incrementamos el contador
            $contador++;

            // Cada vez que llegamos a 4 productos, cerramos la fila y comenzamos una nueva
            if ($contador % 20 == 0) {
                //echo "</div><div class='row'>"; // Si necesitas gestionar el formato de fila cada 20 productos
            }
        }
    }

    // Cerramos la última fila si hay productos que mostrar
    echo "</div>";

} else {
    echo "<p>No se encontraron productos.</p>";
}
echo "</div>";
?>
  

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
crossorigin="anonymous"></script>
<!--=============== MAIN JS ===============-->
<script src="assets/js/main.js"></script>


</body>
</html>
