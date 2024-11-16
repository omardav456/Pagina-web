<?php
session_start();
include 'funcionalidadCupones.php';

if($_SESSION['id']===null || $_SESSION['id']===0){
    header('Location: indexlogin.php'); // Redirige a login si no está autenticado
    exit;
  }
// Manejar la acción de cerrar sesión
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: indexlogin.php"); // Redirigir a la página de inicio de sesión
    exit();
}

// Manejar la acción de cambiar contraseña
if (isset($_POST['change_password'])) {
    // Aquí puedes agregar la lógica para cambiar la contraseña
    // Por ejemplo, mostrar un formulario o procesar el cambio de contraseña
    echo "<script>alert('Funcionalidad para cambiar la contraseña aún no implementada.');</script>";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Usuario</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<style>
   /* Estilos generales */
body {
    
    background-color: #f5f5dc; /* Gris claro */
    margin-top: 20px;
    padding: 20px;
}

/* Contenedor principal */
.user-profile-container {
    max-width: 800px;
    color: black;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Títulos */
.profile-title {
    text-align: center;
    font-size: 2em;
    margin-bottom: 20px;
}

.details-title, .history-title, .cart-title, .coupons-title {
    margin-top: 20px;
    font-size: 1.4em;
    border-bottom: 2px solid #007BFF;
    padding-bottom: 5px;
}

/* Información del usuario */
.user-name, .user-email {
    font-size: 1.1em;
    margin: 5px 0;
}

/* Listas */
.purchase-list, .cart-items, .coupons-list {
    list-style-type: none;
    padding: 0;
}

.purchase-item, .cart-item, .coupon-item {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    margin: 5px 0;
}

/* Total del carrito */
.cart-total {
    font-weight: bold;
    margin-top: 10px;
}

/* 
.btn-change-password, .btn-logout, .checkout-btn {
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}*/

.btn-change-password:hover, .btn-logout:hover, .checkout-btn:hover {
    background-color: #0056b3;
}

/* Sección de acciones */
.user-action-buttons {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
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




<br><br><br><br>

<div class="user-profile-container">
    <h1 class="profile-title">Perfil del Usuario</h1>
    
    <div class="user-details">
        <h2 class="details-title">Información Personal</h2>
        <?php 

    // Datos de conexión
    $servername = "sql10.freemysqlhosting.net";  // Cambia esto si usas otro servidor
    $username = "sql10736060";         // Tu usuario de MySQL
    $password = "v3naSQAq5W";             // Tu contraseña de MySQL
    $dbname = "sql10736060";      // Nombre de tu base de datos

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Consulta para obtener el nombre y correo del cliente
    $id=$_SESSION['id'];
    $sql = "SELECT Nombre_Cliente, Correo_Cliente FROM Cliente WHERE Id_Cliente = $id";
    $result = mysqli_query($conn, $sql);

    // Verificar si se obtuvieron resultados
    if (mysqli_num_rows($result) > 0) {
        // Obtener el resultado
        $cliente = mysqli_fetch_assoc($result);
    
        // Mostrar los resultados
        echo "<h3>Información del Cliente</h3>";
        echo "<p class='user-name'><strong>Nombre:</strong> " . htmlspecialchars($cliente['Nombre_Cliente']) . "</p>";
        echo "<p class='user-email'><strong>Correo Electrónico:</strong> " . htmlspecialchars($cliente['Correo_Cliente']) . "</p>";
} else {
    echo "<p>No se encontró el cliente con el ID $id.</p>";
}

// Cerrar conexión
mysqli_close($conn);
?>
    
    </div>

    <div class="coupons-section">
        <h2 class="coupons-title">Mis Cupones</h2>
        <ul class="coupons-list">
            <?php
                $cupones=consultarCupones(intval( $_SESSION['id']));
                foreach ($cupones as $cupon) {
                    echo "<li class='coupon-item'>";
                    echo "<strong>CUPON:</strong> " . htmlspecialchars($cupon['Nombre_Cupon']) . "";
                    echo "<strong>-</strong> $" . htmlspecialchars($cupon['Descuento_Cupon']) . "<br>";
                    echo "<strong>Fecha Final:</strong> " . htmlspecialchars($cupon['Fecha_Final']);
                    echo "</li>";
                }
            ?>
            
            
        </ul>
    </div>

    <div class="user-action-buttons">
        <form method="POST" class="change-password-form">
            <button type="submit" name="change_password" class="btn btn-secondary btn-change-password ">Cambiar Contraseña</button>
        </form>
        <form action="Pedidos.php" method="POST" class="change-password-form bg">
            <button type="submit" name="change_password" class=" btn btn-change-password btn-success">Ver Facturas</button>
        </form>
        <form method="POST" class="logout-form">
            <button type="submit" name="logout" class=" btn btn-logout btn-danger">Cerrar Sesión</button>
        </form>
    </div>
</div>

</body>
</html>

