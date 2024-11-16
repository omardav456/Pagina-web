
<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randomizar Color de Tarjetas</title>
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
    
</head>
<style>
        /* Estilo base */
        body {
            background-color: #f5f5dc; /* Gris claro */
        }

        h2 {
            color:black;
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .containercard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            padding: 20px;
            box-sizing: border-box;
            width: 90%; /* Ancho responsivo */
            max-width: 190px; /* Máximo ancho */
            height: 254px;
            background: rgba(255, 0, 0, 0.58);
            border: 1px solid white;
            box-shadow: 12px 17px 51px rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(6px);
            border-radius: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.5s;
            user-select: none;
            font-weight: bolder;
            font-size: 1.5em; /* Aumentar el tamaño de la letra */
            color: black; /* Color inicial */
            margin: 10px; /* Espacio entre tarjetas */
            text-decoration: none; /* Quitar subrayado del enlace */
        }

        .card:hover {
            border: 1px solid black;
            transform: scale(1.05);
        }

        .card:active {
            transform: scale(0.95) rotateZ(1.7deg);
        }
        /* Estilo para la línea separadora */
        hr {
            border: 0;
            height: 2px;
            background: #ccc; /* Color de la línea */
            margin: 30px 0; /* Espacio arriba y abajo de la línea */
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
<br><br>
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

// Consulta para obtener todos los valores únicos de Super_Categoria
$sql_super_categoria = "SELECT DISTINCT Super_Categoria FROM Categoria";
$result_super_categoria = $conn->query($sql_super_categoria);

// Verificar si hay resultados
if ($result_super_categoria->num_rows > 0) {
    while ($row_super = $result_super_categoria->fetch_assoc()) {
        echo "<hr>";
        $super_categoria = $row_super['Super_Categoria'];
        echo "<h2 style='text-align: center;'>$super_categoria</h2>";
        echo "<hr>";
        echo "<div class='containercard'>";
        
        

        // Consulta para obtener todas las categorías asociadas a la Super_Categoria
        $sql_categoria = "SELECT Categoria_Producto, Descripcion_Categoria FROM Categoria WHERE Super_Categoria = ?";
        $stmt = $conn->prepare($sql_categoria);
        $stmt->bind_param("s", $super_categoria);
        $stmt->execute();
        $result_categoria = $stmt->get_result();
        
        // Verificar y mostrar los resultados de las categorías
        if ($result_categoria->num_rows > 0) {
            while ($row_categoria = $result_categoria->fetch_assoc()) {
                // Crear tarjeta
                
                echo "<a href='categoria.php?categoria=".$row_categoria['Categoria_Producto']."' class='card'>";
                
                echo $row_categoria['Categoria_Producto'] ;
                
                echo "</a>";
                
            }
        } else {
            echo "<p>No se encontraron categorías para esta super categoría.</p>";
        }

        echo "</div>"; // Cierre de container
        
        // Cerrar el statement
        $stmt->close();
    }
    
    
    
}  
else {
    echo "No se encontraron super categorías.";
}

// Cerrar conexión
$conn->close();




  

?>
 
    <script>
        // Función para generar un color aleatorio
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Función para determinar si un color es oscuro o claro
        function isColorDark(color) {
            const r = parseInt(color.slice(1, 3), 16);
            const g = parseInt(color.slice(3, 5), 16);
            const b = parseInt(color.slice(5, 7), 16);
            const luminance = (0.299 * r + 0.587 * g + 0.114 * b);
            return luminance < 128; // Color oscuro si la luminancia es menor a 128
        }

        // Seleccionar todas las tarjetas y asignar un color aleatorio
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const randomColor = getRandomColor();
            card.style.backgroundColor = randomColor;
            card.style.color = isColorDark(randomColor) ? 'white' : 'black';
        });
    </script>
    <!--=============== MAIN JS ===============-->
<script src="assets/js/main.js"></script>

</body>
</html>
