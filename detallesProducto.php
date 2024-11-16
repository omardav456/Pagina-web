<?php 
session_start();
include 'funcionalidadCarrito.php';

if ($_SESSION['id'] === null || $_SESSION['id'] === 0) {
    
} else {
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Pagar'])) {
        $cantidad = intval($_POST['Cantidad']);
        if ($cantidad <= 0) {
            
        } else {
            // Lógica para pagar
            if (intval($_SESSION['id']) === 0) {
                $_SESSION['fake'] = true;
            } else {
                $id_producto = intval($_POST['Pagar']);
                agregarProducto(intval($_SESSION['id']), $id_producto, $cantidad);
                header('Location: carrito.php');
                exit();
            }
        }
    }

    if (isset($_POST['AñadirCarrito'])) {
        $cantidad = intval($_POST['Cantidad']);
        if ($cantidad <= 0) {
            echo "<script>alert('La cantidad debe ser mayor que 0');</script>";
        } else {
            if (intval($_SESSION['id']) === 0) {
                $_SESSION['fake'] = true;
            } else {
                $id_producto = intval($_POST['AñadirCarrito']);
                //agregarProducto(intval($_SESSION['id']), $id_producto, $cantidad);
                header('Location: carrito.php');
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            background-color: #f5f5dc; /* Gris claro */
        }
        .container {
            color: black;
        }
        .title{
    color:black;
    text-align: center;
    font-size: 2em;
    

  }
    </style>
</head>

<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="Index.php" class="nav__logo">Alkostico</a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item"><a href="Categorias.php" class="nav__link">Catalogo</a></li>
                    <li class="nav__item"><a href="carrito.php" class="nav__link">Carrito</a></li>
                    <li class="nav__item"><a href="evento.php" class="nav__link">Eventos</a></li>
                    <li class="nav__item"><a href="conocenos.php" class="nav__link">Conocenos</a></li>
                    <li class="nav__item"><a href="indexlogin.php" class="nav__link">Sign in</a></li>
                    <li class="nav__"><a href="usuario.php" class="ri-user-line nav__login" id="login-btn"></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container" style="padding-top: 90px; padding-bottom: 15px">
        <div class="row bg-black text-light">
            <?php
                $id_producto = $_POST['idproducto'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $cantidad_disponible = $_POST['cantidad'];
                $precio = $_POST['precio'];
                $url = $_POST['url'];
                echo "<div class='col-12 text-center'><h1 class='display-4 text-warning font-weight-bold'>" . htmlspecialchars($nombre) . "</h1></div>";
            ?>
        </div>

        <div class="row my-4">
            <div class="col-md-6 text-center">
                <img src="<?php echo htmlspecialchars($url); ?>" class="img-fluid rounded shadow" alt="Imagen de producto" style="max-height: 300px;">
            </div>
            <div class="col-md-6">
                <h5>Descripción:</h5>
                <p><?php echo htmlspecialchars($descripcion); ?></p>
                <p><strong>Cantidad disponible:</strong> <?php echo htmlspecialchars($cantidad_disponible); ?></p>
                <p><strong>Precio:</strong> $ <?php echo number_format($precio, 0, ',', '.'); ?></p>
                
                <div class="mb-3">
                    <label for="cantidadProducto" class="form-label">Cantidad:</label>
                    <input type="number" oninput="this.value = Math.min(this.value, <?php echo htmlspecialchars($cantidad_disponible); ?>); calcular(this.value, <?php echo $precio; ?>)" 
                           class="form-control" id="cantidadProducto" name="Cantidad" value="1" min="1" max="<?php echo htmlspecialchars($cantidad_disponible); ?>">
                </div>
                <div class="mb-3">
                    <strong>Total a pagar:</strong>
                    <label id="subtotal">$ <?php echo number_format($precio, 0, ',', '.'); ?></label>
                </div>
                <div class="d-flex justify-content-between">
                    <form action="" method="post">
                        <input type='hidden' name='Pagar' value='<?php echo $id_producto ?>'>
                        <button type="submit" class="btn btn-success animate-button" onclick="return validarCantidad()">Pagar Ahora</button>
                    </form>
                    <form action="" method="post">
                        <input type='hidden' name='AñadirCarrito' value="<?php echo $id_producto ?>">
                        <button type="submit" class="btn btn-primary animate-button" onclick="return validarCantidad()">Añadir al carrito</button>
                    </form>
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

        function validarCantidad() {
            const cantidad = document.getElementById("cantidadProducto").value;
            if (cantidad <= 0) {
                alert("La cantidad debe ser mayor que 0.");
                return false;
            }
            const maxCantidad = parseInt(document.getElementById("cantidadProducto").max);
            if (cantidad > maxCantidad) {
                alert("La cantidad no puede superar la cantidad disponible.");
                return false;
            }
            // Actualizar el valor de la cantidad en el formulario
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const cantidadInput = document.createElement('input');
                cantidadInput.type = 'hidden';
                cantidadInput.name = 'Cantidad';
                cantidadInput.value = cantidad;
                form.appendChild(cantidadInput);
            });
            return true;
        }
    </script>
    <!--=============== MAIN JS ===============-->
<script src="assets/js/main.js"></script>
</body>
</html>
