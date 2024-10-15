<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alkostico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link href="css/Estilo.css" rel="stylesheet">
    <script src="js/index.js"></script>
    </head>
</head>
<body>
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
  $sql = "SELECT Nombre_Producto, Descripcion_Producto, Cantidad_Producto, Precio_Producto, URL_Producto FROM Producto";
  $result = $conn->query($sql);
  $conn->close();
  ?>

<div>
  <nav class="navbar navbar-expand-lg navbar-expand-sm fixed-top navbar-dark bg-black">
    <div class="container-fluid d-flex align-items-center">
      
        <a class="navbar-brand " href="#">Alkostico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Catalogo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="carrito.php">
                  <img src="Images/216477_shopping_cart_icon.png" alt="" class="navbar-icon">
              </a>
            </li>
            
          </ul>
          <form class="d-flex " role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-dark" type="submit">Search</button>
          </form>
        </div>
      </div>
    
  </nav>
</div>



<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://img.freepik.com/vector-premium/ilustracion-vectorial-vistas-bosques-montanas_969863-195608.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="https://media.es.wired.com/photos/64095686f51954624464a78b/master/pass/agujero%20negro%20Sagitario%20A%20via%20lactea%20x7.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKWt1io2PLo5bUSWNAb1BYD3ejoBSLMfqVbg&s" class="d-block w-100" alt="...">
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div>
  <div class="title-container">
    <h1 class="title">Productos</h1>
  </div>
  </div>
</div>


<div>
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
          // Cada tarjeta ocupará espacio en la fila
          echo "
          <div class='col-12 col-sm-6 col-md-3 col-lg-3'>
              <div class='card w-95 h-95' style='margin-top: 20px;'>
                  <img src='" . $row["URL_Producto"] . "' class='card-img-top' alt='Imagen de producto'>
                  <div class='card-body'>
                  <h5 class='card-title'>" . $row["Nombre_Producto"] . "</h5>
                  <p class='card-text'>Cantidad disponible: " . $row["Cantidad_Producto"] . "</p>
                  <p class='card-text'><strong>Precio: $" . $row["Precio_Producto"] . "</strong></p>
                  <a href='#' class='btn btn-primary' onclick='agregarcarrito(\"" . htmlspecialchars($row["Nombre_Producto"], ENT_QUOTES) . "\", \"" . htmlspecialchars($row["Cantidad_Producto"], ENT_QUOTES) . "\", \"" . htmlspecialchars($row["Precio_Producto"], ENT_QUOTES) . "\", \"" . htmlspecialchars($row["URL_Producto"], ENT_QUOTES) . "\");'>Añadir al carrito</a>
  
                  <!-- Formulario para enviar datos a otra página -->
                  <form action='detallesProducto.php' method='POST'>
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
              //echo "</div><div class='row'>";
          }
      }
  
      // Cerramos la última fila si hay productos que mostrar
      echo "</div>";
  
  } else {
      echo "<p>No se encontraron productos.</p>";
  }
  echo "</div>";
  ?>
</div>


  

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
crossorigin="anonymous"></script>

<script>
  function enviarDatos() {
    fetch('carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(carrito) // Convertir los datos a JSON
            })
            .then(response => response.text()) // Manejar la respuesta del servidor
            .then(data => {
                console.log(data); // Mostrar la respuesta en la consola
            })
            .catch(error => console.error('Error:', error)); // Manejar errores
    
  }
</script>

</body>
</html>
