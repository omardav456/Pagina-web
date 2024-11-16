<?php
session_start();
include 'funcionalidadCarrito.php';

echo "<script>
alert('Hola ".intval( $_SESSION['id'])."');
      
</script>";
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
    <title>Document</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    img {
        max-width: 100px; /* Ajusta el tamaño de la imagen */
        height: auto;
    }
</style>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
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
    <div>
        <h1>Carrito de Compars</h1>
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
                        <button type="submit">Eliminar</button>';
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
                echo"<h2>Todavia no hay productos</h2>";
            }
            
          
        ?>
    </div>
    <h3>Total Carrito: $<span id="totalCarrito">0</span></h3>
    <h1>Falta mejorar el diseño y  poner un boton de pagar </h1>
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