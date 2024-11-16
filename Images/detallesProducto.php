<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/Estilo.css" rel="stylesheet">
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .animate-button {
            transition: transform 0.2s;
        }
        .animate-button:active {
            transform: scale(0.95);
        }
        h1 {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>

<body>
    <!--==================== HEADER ====================-->
  <header class="header" id="header">
         <nav class="nav container">
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

                  <li class="nav__item">
                     <a href="conocenos.php" class="nav__link">Conocenos</a>
                  </li>

                  <li class="nav__item">
                     <a href="indexlogin.php" class="nav__link">Sing in</a>
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


    <div class="container" style="padding-top: 90px; padding-bottom: 15px">
        <div class="row bg-black text-light">
            <?php
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $cantidad = $_POST['cantidad'];
                $precio = $_POST['precio'];
                $url = $_POST['url'];
                echo "<div class='col-12 text-center'>
                        <h1 class='display-4 text-warning font-weight-bold'>" . htmlspecialchars($nombre) . "</h1>
                      </div>";
            ?>
        </div>

        <div class="row my-4">
            <div class="col-md-6 text-center">
                <img src="<?php echo htmlspecialchars($url); ?>" class="img-fluid rounded shadow" alt="Imagen de producto" style="max-height: 300px;">
            </div>
            <div class="col-md-6">
                <h5>Descripción:</h5>
                <p><?php echo htmlspecialchars($descripcion); ?></p>
                <p><strong>Cantidad disponible:</strong> <?php echo htmlspecialchars($cantidad); ?></p>
                <p><strong>Precio:</strong> $ <?php echo number_format($precio, 0, ',', '.'); ?></p>
                
                <div class="mb-3">
                    <label for="cantidadProducto" class="form-label">Cantidad:</label>
                    <input type="number" oninput="this.value = Math.min(this.value, <?php echo htmlspecialchars($cantidad); ?>)" onchange="calcular(this.value, <?php echo $precio; ?>)" class="form-control" id="cantidadProducto" name="cantidadProducto" value="1" min="1" max="<?php echo htmlspecialchars($cantidad); ?>">
                </div>
                <div class="mb-3">
                    <strong>Total a pagar:</strong>
                    <label id="subtotal">$ <?php echo number_format($precio, 0, ',', '.'); ?></label>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-success animate-button" onclick="pagarAhora()">Pagar Ahora</button>
                    <button class="btn btn-primary animate-button" onclick="anadirAlCarrito()">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function calcular(cantidad, multiplicador) {
            const resultado = document.getElementById("subtotal");
            const total = multiplicador * cantidad;
            resultado.textContent = '$ ' + total.toLocaleString('es-CO');
        }

        function pagarAhora() {
            const cantidad = document.getElementById("cantidadProducto").value;
            const precio = <?php echo $precio; ?>;
            const total = precio * cantidad;
            alert(`Pagar Ahora: Cantidad ${cantidad}, Total: ${total}`);
        }

        function anadirAlCarrito() {
            const cantidad = document.getElementById("cantidadProducto").value;
            const nombreProducto = "<?php echo htmlspecialchars($nombre); ?>";
            const precio = <?php echo $precio; ?>;
            const total = precio * cantidad;
            alert(`Añadir al carrito: ${nombreProducto}, Cantidad: ${cantidad}, Total: ${total}`);
        }
    </script>
</body>
</html>
