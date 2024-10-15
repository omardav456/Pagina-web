<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/Estilo.css" rel="stylesheet">
    <script src="js/index.js"></script>
</head>


<body>

    
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-expand-sm fixed-top navbar-primary bg-primary">
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
              <a class="nav-link active" aria-current="page" href="carritoCompra.php">
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

    <div class="container" style="padding-top: 90px; padding-bottom:15px">
    <div class="row bg-black text-light">
    <?php
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $url = $_POST['url'];
        echo"<div class='col'>
                <h1>".htmlspecialchars($nombre)."</h1>            
            </div>
            </div>
        <div class='row'>
            <div class='col col-12 col-sm-6 col-md-6 col-lg-6 '>
                <img src='" . htmlspecialchars($url) . "' class='img-fluid' alt='Imagen de producto'>
            </div>
            <div class='col col-12 col-sm-6 col-md-6 col-lg-6'>
                <br>
                <p><b>Descripción:</b> " . htmlspecialchars($descripcion) . "</p>
                <p><b>Cantidad disponible:</b> " . htmlspecialchars($cantidad) . "</p>
                <p><b>Precio:</b> $" . htmlspecialchars($precio) . "</p>
                <div class='container'>
                    <div class='row'>
                        <label for='cantidadProducto' class='form-label'>Cantidad:</label>
                        <div class='col-12 col-md-6 col-lg-6 '>
                            
                            <input type='number' onchange='calcular(this.value,".$precio.")' class='form-control' id='cantidadProducto' name='cantidadProducto' value='1' min='1' max='" . $cantidad . "'>
                        
                        </div>
                        <div class='col-12 col-md-6 col-lg-6'>
                            <b>Total a pagar: </b>
                            <label id='subtotal' >".$precio."</label>
                        </div>  
                    </div>
                    <div class='row mt-2'>
                        <div class='col-6 col-md-6 col-lg-6 '>
                            <button class='btn btn-success me-2'>Pagar Ahora</button>
                        </div>
                        <div class='col-6 col-md-6 col-lg-6'>
                            <!-- Botón de añadir al carrito -->
                            <button class='btn btn-primary' >Añadir al carrito</button>
                        </div>  
                    </div>
                    
                </div>
            </div>
        </div>
        ";
    ?>
    </div>
    

    <div class="container">
        <div class="row bg-black text-light">
            <div class="col">
                <h1>Nombre</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                foto producto
            </div>
            <div class="col mb-3">
                
                info y form
                
                

        
            </div>
        </div>
    </div>
    







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
  window.onscroll = function() {
    const navbar = document.querySelector('.navbar');
    
    if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
      navbar.classList.add('bg-light'); // Agregar clase al hacer scroll
      //navbar.classList.add('bg-body-tertiary'); // Agregar clase al hacer scroll
    } else {
      navbar.classList.remove('navbar-dark'); // Remover clase cuando vuelve al top
      navbar.classList.remove('bg-black'); // Remover clase cuando vuelve al top
    }
  };
</script>
<script>
    function calcular(cantidad, multiplicador) {
        
        const resultado = document.getElementById("subtotal");
        resultado.textContent = "$"+ (multiplicador*cantidad);
    }
</script>

</body>
</html>