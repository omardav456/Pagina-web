<?php
session_start();
include 'funcionalidadCarrito.php';
include 'funcionalidadCupones.php';
if($_SESSION['id']===null || $_SESSION['id']===0){
  header('Location: indexlogin.php');
  exit(); // Asegúrate de usar exit() después de header 
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['AnadirCarrito'])) {
  $id_producto = intval($_POST['AnadirCarrito']);
  $cantidad = intval($_POST['cantidad']);

  if (agregarProducto(intval($_SESSION['id']), $id_producto, $cantidad)) {
      echo json_encode(['success' => true]);
  } else {
      echo json_encode(['success' => false]);
  }
  exit;
}
//agregarProducto(intval( $_SESSION['id']),2,1);
consultarCarrito(intval( $_SESSION['id']));
//ActualizarCantidadProducto(intval( $_SESSION['id']),2,1);
consultarCarrito(intval( $_SESSION['id']));

// Verificar si se ha enviado un formulario para eliminar un producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Id_Producto'])) {
    
    $id_producto = intval($_POST['Id_Producto']);
    echo $id_producto;
    eliminarDelCarrito(intval( $_SESSION['id']), $id_producto);
    $_SESSION['eliminado']=true;
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Angkor&family=Arima:wght@100..700&family=Diplomata&family=Erica+One&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik+80s+Fade&family=Tilt+Prism&family=Ysabeau+SC:wght@1..1000&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Angkor&family=Arima:wght@100..700&family=Diplomata&family=Erica+One&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Paprika&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik+80s+Fade&family=Rubik:ital,wght@0,300..900;1,300..900&family=Tilt+Prism&family=Ysabeau+SC:wght@1..1000&display=swap" rel="stylesheet"></style>
</head>    
    <style>


/* From Uiverse.io by andrew-demchenk0 */ 
.buttoneliminar {
  --main-focus: #2d8cf0;
  --font-color: #323232;
  --bg-color-sub: #dedede;
  --bg-color: #eee;
  --main-color: #323232;
  position: relative;
  width: 100px; /* Ancho ajustado */
  height: 40px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center; /* Centra contenido por defecto */
  padding: 0 10px; /* Espaciado interno */
  border: 2px solid var(--main-color);
  box-shadow: 4px 4px var(--main-color);
  background-color: var(--bg-color);
  border-radius: 10px;
  overflow: hidden;
}

.buttoneliminar, .buttoneliminar__icon, .buttoneliminar__text {
  transition: all 0.3s ease;
}

.buttoneliminar .buttoneliminar__text {
  color: var(--font-color);
  font-weight: 600;
  font-size: 14px; /* Tamaño ajustado del texto */
  white-space: nowrap; /* Evitar saltos de línea */
  opacity: 1; /* Texto visible por defecto */
}

.buttoneliminar .buttoneliminar__icon {
  position: absolute;
  height: 24px; /* Tamaño ajustado del ícono */
  width: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: translateY(100%); /* Ícono inicialmente fuera del botón */
  opacity: 0; /* Ocultar ícono inicialmente */
}

.buttoneliminar .svg {
  width: 20px; /* Ajuste del ícono */
  height: 20px;
  fill: var(--main-color);
}

.buttoneliminar:hover .buttoneliminar__text {
  opacity: 0; /* Ocultar texto al pasar el mouse */
}

.buttoneliminar:hover .buttoneliminar__icon {
  transform: translateY(0); /* Mover ícono al centro */
  opacity: 1; /* Mostrar ícono */
}

.buttoneliminar:active {
  transform: translate(3px, 3px);
  box-shadow: 0px 0px var(--main-color);
}

     /* Estilos de la barra de navegación */
     .navbar {
            font-family: "Lato", sans-serif;
            font-weight: 100;
            background: black;
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 0 20px;
        }

        .navbar {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar:hover {
            color: #ddd;
        }

        .navbar .title {
            font-size: 24px;
            text-align: center;
            flex-grow: 1;
        }

    table{
        font-family: "Rubik", sans-serif;
        font-optical-sizing: auto;
        position: relative;
        top: 30px; /* 150px desde la parte superior */
        width: auto; /* Ajusta el tamaño de la tabla según el contenido */
        border-collapse: collapse; /* Eliminar espacios entre las celdas */
        border-collapse: collapse;
        margin: 50px auto; 
        margin-left: 20px;
        margin-bottom: 20px;
        background-color:rgba(255, 255, 255, 0.5); /* Color blanco con 80% de opacidad */;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Añadir una sombra suave */
        border-radius: 0px; /* Bordes redondeados */
    }
    th, td {
        padding: 15px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        text-align:center;
        color: white;
        background: black;
    }
    img {
        max-width: 100px; /* Ajusta el tamaño de la imagen */
        height: auto;
    }

     /* Estilo para el contenedor principal del total */
     .total-container {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            width: 25%; /* Ajusta el ancho del total */
            margin-left: auto; /* Empuja el total hacia el lado derecho */
            position: relative;
            top: 0; /* Resetea la posición si no quieres margen desde arriba */
            align-self: flex-start; /* Alinea al inicio de la fila */
            padding: 20px;
            border: 2px solid #ddd; /* Borde alrededor del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Fondo claro */
            text-align: center; /* Centrar el texto */
            margin-bottom: 80px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }



        /* Estilo para el título */
        .total-container h3 {

            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            margin-left: 20px;
            margin-bottom: 20px;
            margin: 0px;
            padding-bottom: 10px;
            font-size: 18px;
            color: #333; /* Color del texto */
        }

        /* Estilo para el valor del total */
        .total-value {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            padding: 15px;
            border: 2px solid black; /* Borde rojo alrededor del valor */
            background-color: white; /* Fondo claro en el recuadro del valor */
            color: black; /* Texto rojo */
            font-size: 24px;
            font-weight: bold;
            border-radius: 5px;
        }

        /*mensaje no hay productos*/ 
        .NHP {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            position: fixed;  /* Fija el elemento en su posición */
            left: 20px;       /* Posición desde el lado derecho de la pantalla */
            bottom: 250px; /*posicion desde la parte inferior */
            width: 50%;
            margin: 50px; /* Centrar el mensaje */
            padding: 50px;
            border: 2px solid #ddd;
            border-radius: 60px;
            background-color: #f9f9f9;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        .NHP h2 {
         color: black; /* Color del texto */
        }

        /* Estilo del botón de pago */
.boton-pagar {
    margin-top: 5px;
    background-color: black;
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer; /* Cambia el cursor a una mano cuando se pasa el mouse */
    transition: transform 0.3s ease; /* Suave animación al hacer hover */
}

.boton-pagar:hover {
    transform: scale(1.05); /* Efecto de agrandado al pasar el mouse */
    background-color: green;
}

.boton-pagar:active {
    background-color: #00408d;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transform: translateY(2px);
}

        body {
            height: 100%; /* Asegura que el contenido ocupe toda la ventana si es necesario */
            margin: 0;
            padding: 0;
            background-color: #f5f5dc; /* Gris claro */
            background-size: cover; /* Asegura que la imagen cubra toda la pantalla */
            background-position: center; /* Centra la imagen en la pantalla */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            background-attachment: fixed; /* Mantiene la imagen fija cuando se desplaza */
            height: 100vh; /* Asegura que cubra toda la altura de la pantalla */
        }

       
.wrapper { 
    min-height: 100vh; /* Hace que el contenedor principal ocupe al menos el 100% de la altura de la pantalla */
    display: flex;
    flex-direction: column;
}

.content {
    flex: 1; /* Esto permite que el contenido principal ocupe el espacio disponible */
}

.footer {
    position: absolute;
    top: 600px;
    bottom: 0;
    left: 0;
    width: 100%;  /* Para que el footer ocupe todo el ancho de la pantalla */
    height: 100%;
    background: linear-gradient(to right, #87CEFA ,#6A5ACD, #191970); /* Color fondo del footer */ /* Cambia por el color que quieras usar */
    padding: 20px;
    text-align: center;
    z-index: 1000; /* Asegúrate de que el footer esté siempre visible encima de otros elementos */
}

.container {
    font-family: "Rubik", sans-serif;
    font-optical-sizing: auto;
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.footer-section {
  flex: 1 1 200px; /* Cada columna ocupa espacio proporcional */
  margin: 10px;
}

.footer-section h3 {
  color:black;
  font-size: 16px;
  margin-bottom: 15px;
  font-weight: bold;
}

.footer-section ul {
  color:black;
  list-style: none;
}

.footer-section ul li {
  margin-bottom: 10px;
}

.footer-section ul li a {
  color:black;
  text-decoration: none;
  font-size: 14px;
}

.footer-section ul li a:hover {
  text-decoration: underline;
}

.footer-section.logo {
  display: flex;
  align-items: center;
  flex-direction: column;
}

.footer-section.logo img {
  font-family: "Erica One", sans-serif;
  font-weight: 400;
  width: 50px;
  margin-bottom: 10px;
}

.footer-bottom {
  font-family: "Erica One", sans-serif;
  font-weight: 400;
  color:black;
  text-align: center;
  margin-top: 30px;
  font-size: 14px;
  border-top: 1px solid #ffffff33; /* Línea de separación ligera */
  padding-top: 20px;
}

.footer-bottom p {
    color:black;
}

        

        

</style>


<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>


<body>
<div class="wrapper">
    <div class="content">
        <!-- Aquí va el contenido principal de tu página -->
    
    <?php
        if(isset($_SESSION['eliminado']) && ($_SESSION['eliminado'])) {
            //print "xd";
        echo "<script>
            Swal.fire({
                title: 'Notificación',
                text: 'Producto eliminado del carrito',
                icon: 'success',
                timer: 5000
            });
        </script>";
        
        // Eliminar el mensaje después de mostrarlo
        unset($_SESSION['eliminado']);
    }
    ?>
    <div class="navbar">
        <a href="Index.php">Regresar</a>
        <div class="title">Carrito de Compras</div>
    </div>

    


    <div>
        <?php
            $array=consultarCarrito(intval( $_SESSION['id']));
            if (!empty($array)) {
                
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Imagen</th>";
            echo "<th>Nombre</th>";
            echo "<th>Descripcion</th>";
            echo "<th>Cantidad</th>";
            echo "<th>Precio</th>";
            echo "<th>Total</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
           $i=0;
            foreach ($array as $producto) {
                $i++;
                echo "<tr>";
                echo "<td>" . ($i) . "</td>";
                echo "<td><img src='" . htmlspecialchars($producto['URL_Producto']) . "' alt='Imagen de producto'></td>";
                echo "<td>" . htmlspecialchars($producto['Nombre_Producto']) . "</td>";
                echo "<td>" . htmlspecialchars($producto['Descripcion_Producto']) . "</td>";
                echo "<td>";
                echo '<div class="spinner" data-id="' . $producto['Id_Producto'] . '">';
                echo '<button onclick="changeQuantity(' . $producto['Id_Producto'] . ', -1)">-</button>';
                echo '<input type="number" id="spinner-' . $producto['Id_Producto'] . '" value="' . $producto['Cantidad_Carrito'] . '" min="1" max="' . $producto['Cantidad_Producto'] . '" oninput="validateSpinner(this)">';
                echo '<button onclick="changeQuantity(' . $producto['Id_Producto'] . ', 1)">+</button>';
                echo '</div>';
                echo"<br>";
                echo'<form method="post" style="display:inline;">
                        <input type="hidden" name="Id_Producto" value='.$producto['Id_Producto'].'">
                        <button type="submit" class="buttoneliminar">
                        <span class="buttoneliminar__text">Eliminar</span>
                        <span class="buttoneliminar__icon"><svg xmlns="http://www.w3.org/2000/svg" width="512" viewBox="0 0 512 512" height="512" class="svg"><title></title><path style="fill:none;stroke:#323232;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" d="M112,112l20,320c.95,18.49,14.4,32,32,32H348c17.67,0,30.87-13.51,32-32l20-320"></path><line y2="112" y1="112" x2="432" x1="80" style="stroke:#323232;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"></line><path style="fill:none;stroke:#323232;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" d="M192,112V72h0a23.93,23.93,0,0,1,24-24h80a23.93,23.93,0,0,1,24,24h0v40"></path><line y2="400" y1="176" x2="256" x1="256" style="fill:none;stroke:#323232;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line><line y2="400" y1="176" x2="192" x1="184" style="fill:none;stroke:#323232;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line><line y2="400" y1="176" x2="320" x1="328" style="fill:none;stroke:#323232;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line></svg></span>
                        </button>';
                echo"</form>";
                echo "</td>";
                echo "<td id='price-" . $producto['Id_Producto'] . "'>" . number_format($producto['Precio_Producto'], 2, ',', '.') . " COP</td>"; // Precio formateado
                echo "<td id='total-" . $producto['Id_Producto'] . "'>" . number_format($producto['Precio_Producto'] * $producto['Cantidad_Carrito'], 2, ',', '.') . " COP</td>"; // Total por producto
                echo "</tr>";
          }
            // Botones de agregar y quitar
            echo "</tbody>";
            echo "</table>";
            } else {
                echo "<div class='NHP'>";
                echo "<h2>Todavía no hay productos</h2>";
                 echo "</div>";
            }
            
          
        ?>
        
    </div>
    <div class="total-container">
    <h3>Total a Pagar</h3>
    <div class="total-value">
        $<span id="totalCarrito">0</span>
    </div>
    <form id="pagoForm" method="POST" action="prepago.php" style="display:none;">
        <input type="hidden" name="total" id="totalInput">
        <input type="hidden" name="detalles" id="detallesInput">
    </form>
    <a href="javascript:void(0);" onclick="pagar()">
        <button class="boton-pagar">Pagar</button>
    </a>
</div>




    
    <script>
      function pagar() {
    let totalCarrito = 0;
    let detalles = '';
    const idCliente = <?php echo intval($_SESSION['id']); ?>; // Obtener el ID del cliente
    let promises = [];

    // Recorrer los productos
    <?php foreach ($array as $producto): ?>
        (function() {
            const cantidad = parseInt(document.getElementById('spinner-<?php echo $producto['Id_Producto']; ?>').value);
            const precio = <?php echo $producto['Precio_Producto']; ?>;
            const id = <?php echo $producto['Id_Producto']; ?>;
            const nombre = <?php echo json_encode($producto['Nombre_Producto']); ?>;
            const totalProducto = cantidad * precio;
            totalCarrito += totalProducto;

            // Agregar detalles del producto
            if (cantidad > 0) {
                detalles += 'ID: ' + id + ', Producto: ' + nombre +', Cantidad: ' + cantidad + ', Precio: ' + totalProducto + '\n';
            }

            // Enviar la nueva cantidad al servidor
            promises.push(actualizarCantidadEnBaseDeDatos(id, cantidad, idCliente));
        })();
    <?php endforeach; ?>

    // Esperar a que todas las promesas se resuelvan antes de enviar el formulario
    Promise.all(promises).then(() => {
        document.getElementById('totalInput').value = totalCarrito;
        document.getElementById('detallesInput').value = detalles;
        document.getElementById('pagoForm').submit();
    }).catch(error => {
        console.error('Error al actualizar las cantidades:', error);
    });
}

function actualizarCantidadEnBaseDeDatos(productId, cantidad, idCliente) {
    return fetch('actualizar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_cliente: idCliente, id_producto: productId, nueva_cantidad: cantidad })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            throw new Error(data.message);
        }
    });
}

  
</script>

    <script>
function changeQuantity(productId, delta) {
    let spinner = document.getElementById('spinner-' + productId);
    let price = parseFloat(document.getElementById('price-' + productId).innerText.replace(/\./g, '').replace(',', '.').split(' ')[0]);
    let currentValue = parseInt(spinner.value);
    
    // Cambiar la cantidad
    if (delta === 1 && currentValue < parseInt(spinner.max)) {
        currentValue++;
    } else if (delta === -1 && currentValue > 1) {
        currentValue--;
    }
    spinner.value = currentValue;

    // Calcular nuevo total
    let newTotal = currentValue * price;
    document.getElementById('total-' + productId).innerText = number_format(newTotal, 2) + ' COP';
    
    // Actualizar total del carrito
    updateCartTotal();
}

function updateCartTotal() {
    let total = 0;
    let qty;
    let price;
    <?php foreach ($array as $producto): ?>
        qty = parseInt(document.getElementById('spinner-<?php echo $producto['Id_Producto']; ?>').value);
        price = parseFloat(document.getElementById('price-<?php echo $producto['Id_Producto']; ?>').innerText.replace(/\./g, '').replace(',', '.').split(' ')[0]);
        total += qty * price;
    <?php endforeach; ?>
    document.getElementById('totalCarrito').innerText = number_format(total, 2) + ' COP';
}

// Función para formatear números
function number_format(number, decimals) {
    return number.toLocaleString('es-CO', {minimumFractionDigits: decimals, maximumFractionDigits: decimals});
}

function validateSpinner(spinner) {
    const max = parseInt(spinner.max);
    const value = parseInt(spinner.value);

    if (value > max) {
        spinner.value = max;
    } else if (value < 1) {
        spinner.value = 1;
    }

    const productId = spinner.id.split('-')[1];
    const price = parseFloat(document.getElementById('price-' + productId).innerText.replace(/\./g, '').replace(',', '.').split(' ')[0]);
    const newTotal = parseInt(spinner.value) * price;
    document.getElementById('total-' + productId).innerText = number_format(newTotal, 2) + ' COP';

    // Actualizar total del carrito
    updateCartTotal();
}

// Inicializa el total del carrito
updateCartTotal();
</script>



</body>

</html>