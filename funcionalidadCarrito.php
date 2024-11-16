<?php

function consultarCarrito($id_cliente){
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



$stmt = $conn->prepare("
        SELECT 
          p.Id_Producto,
          p.URL_Producto, 
          p.Descripcion_Producto, 
          p.Cantidad_Producto, 
          p.Nombre_Producto, 
          p.Categoria_Producto,
          p.Precio_Producto, 
          cc.Cantidad_Producto AS Cantidad_Carrito
        FROM 
          Carrito_Compra cc 
        JOIN 
          Producto p ON cc.Id_Producto = p.Id_Producto 
        WHERE 
          cc.Id_Cliente = ?
        ");
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

$array_resultado = [];

while ($row = $result->fetch_assoc()) {
$array_resultado[] = $row;
}

// Imprimir el resultado


$stmt->close();
return $array_resultado;

}
function agregarProducto($id_cliente, $id_producto, $cantidad) {
  // Datos de conexión
  $servername = "sql10.freemysqlhosting.net";
  $username = "sql10736060";
  $password = "v3naSQAq5W";
  $dbname = "sql10736060";
  
  // Crear la conexión
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Verificar la conexión
  if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
  }

  // Mostrar el valor de cantidad para depuración
  error_log("Cantidad recibida: " . $cantidad); // Verifica el valor de cantidad

  // Paso 1: Verificar el stock del producto
  $stmt = $conn->prepare("SELECT Cantidad_Producto FROM Producto WHERE Id_Producto = ?");
  $stmt->bind_param("i", $id_producto);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $producto = $result->fetch_assoc();
      $stockDisponible = $producto['Cantidad_Producto'];

      // Paso 2: Verificar si el cliente ya tiene el producto en el carrito
      $stmt = $conn->prepare("SELECT * FROM Carrito_Compra WHERE Id_Cliente = ? AND Id_Producto = ?");
      $stmt->bind_param("ii", $id_cliente, $id_producto);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          // Si ya está en el carrito, verificar si se puede agregar la cantidad
          $carritoProducto = $result->fetch_assoc();
          $cantidadActual = $carritoProducto['Cantidad_Producto'];
          $nuevaCantidad = $cantidadActual + $cantidad;

          error_log("Cantidad actual: $cantidadActual, Nueva cantidad: $nuevaCantidad"); // Debug

          if ($nuevaCantidad <= $stockDisponible) {
              // Actualizar la cantidad en el carrito
              $stmt = $conn->prepare("UPDATE Carrito_Compra SET Cantidad_Producto = ? WHERE Id_Cliente = ? AND Id_Producto = ?");
              $stmt->bind_param("iii", $nuevaCantidad, $id_cliente, $id_producto);
              $stmt->execute();
              $stmt->close();
              $conn->close();
              return 'Cantidad actualizada.';
          } else {
              $stmt->close();
              $conn->close();
              return 'Error: La cantidad solicitada supera el stock disponible (' . $stockDisponible . ').';
          }
      } else {
          // Si no está en el carrito, verificar el stock antes de insertar
          error_log("Agregando producto por primera vez, cantidad: $cantidad"); // Debug
          if ($cantidad <= $stockDisponible) {
              $stmt = $conn->prepare("INSERT INTO Carrito_Compra (Id_Cliente, Id_Producto, Cantidad_Producto) VALUES (?, ?, ?)");
              $stmt->bind_param("iii", $id_cliente, $id_producto, $cantidad);
              $stmt->execute();
              $stmt->close();
              $conn->close();
              return 'Producto agregado al carrito.';
          } else {
              $stmt->close();
              $conn->close();
              return 'Error: La cantidad solicitada supera el stock disponible (' . $stockDisponible . ').';
          }
      }
  } else {
      $stmt->close();
      $conn->close();
      return 'Error: Producto no encontrado.';
  }
}





function ActualizarCantidadProducto($id_cliente,$id_producto,$cantidad){
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
    $stmt = $conn->prepare("UPDATE Carrito_Compra SET Cantidad_Producto =  ? WHERE Id_Cliente = ? AND Id_Producto = ?");
    $stmt->bind_param("iii", $cantidad, $id_cliente, $id_producto);
    $stmt->execute();
    //echo 'Cantidad actualizada: ' . $stmt->affected_rows;

}





function mostrarTabla($array){
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
    $i=$i+1;
    echo "<tr>";
    echo "<td>" . ($i) . "</td>";
    echo "<td><img src='" . htmlspecialchars($producto['URL_Producto']) . "' alt='Imagen de producto'></td>";
    echo "<td>" . htmlspecialchars($producto['Nombre_Producto']) . "</td>";
    echo "<td>" . htmlspecialchars($producto['Descripcion_Producto']) . "</td>";
    echo "<td>";
    echo '<div class="spinner" data-id="' . $producto['Id_Producto'] . '">';
    echo '<button onclick="changeQuantity(' . $producto['Id_Producto'] . ', -1)">-</button>';
    echo '<input type="number" id="spinner-' . $producto['Id_Producto'] . '" value="' . $producto['Cantidad_Carrito'] . '" min="' . 0 . '" max="' . $producto['Cantidad_Producto'] . '" readonly>';
    echo '<button onclick="changeQuantity(' . $producto['Id_Producto'] . ', 1)">+</button>';
    echo '</div>';
    echo "</td>";

    echo "<td id='price-'".$producto['Id_Producto']."'>" . htmlspecialchars($producto['Precio_Producto']) . "</td>";
    echo "<td id='total-'".$producto['Id_Producto']."'>" . ($producto['Precio_Producto'] * $producto['Cantidad_Producto']) . "</td>";
  echo "</tr>";
}
  // Botones de agregar y quitar
  

  echo "</tbody>";
  echo "</table>";

}

function eliminardelCarrito($id_Cliente,$id_producto){
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
    $stmt = $conn->prepare("DELETE FROM Carrito_Compra WHERE Id_Cliente = ? AND Id_Producto = ?");
    $stmt->bind_param("ii", $id_Cliente, $id_producto); // "ii" indica que ambos son enteros

    // Ejecutar la consulta
    if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
        //echo "Producto eliminado del carrito.";
      } else {
        //echo "No se encontró el producto para eliminar.";
      }
    } else {
        //echo "Error al eliminar el producto: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();



}
function eliminarTodoCarrito($id_Cliente) {
  // Datos de conexión
  $servername = "sql10.freemysqlhosting.net";  
  $username = "sql10736060";         
  $password = "v3naSQAq5W";             
  $dbname = "sql10736060";      

  // Crear la conexión
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Verificar la conexión
  if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
  }

  // Paso 1: Obtener los productos y cantidades del carrito
  $stmt = $conn->prepare("SELECT Id_Producto, Cantidad_Producto FROM Carrito_Compra WHERE Id_Cliente = ?");
  $stmt->bind_param("i", $id_Cliente);
  $stmt->execute();
  $result = $stmt->get_result();

  // Arreglo para almacenar los cambios
  $productos = [];

  while ($row = $result->fetch_assoc()) {
      $productos[] = $row; // Almacena los productos y cantidades
  }

  $stmt->close();

  // Paso 2: Actualizar la cantidad en la tabla de productos
  foreach ($productos as $producto) {
      $id_Producto = $producto['Id_Producto'];
      $cantidad = $producto['Cantidad_Producto'];

      // Verificar la cantidad disponible antes de restar
      $stmt = $conn->prepare("SELECT Cantidad_Producto FROM Producto WHERE Id_Producto = ?");
      $stmt->bind_param("i", $id_Producto);
      $stmt->execute();
      $resultProducto = $stmt->get_result();
      $productoExistente = $resultProducto->fetch_assoc();

      if ($productoExistente) {
          // Restar la cantidad del carrito
          $nuevaCantidad = $productoExistente['Cantidad_Producto'] - $cantidad;

          // Actualizar la cantidad en la tabla de productos
          if ($nuevaCantidad >= 0) {
              $stmt->close();
              $stmt = $conn->prepare("UPDATE Producto SET Cantidad_Producto = ? WHERE Id_Producto = ?");
              $stmt->bind_param("ii", $nuevaCantidad, $id_Producto);
              $stmt->execute();
          } else {
              echo "No hay suficiente stock para el producto ID: $id_Producto. No se restará la cantidad.";
          }
      }
      $stmt->close();
  }

  // Paso 3: Eliminar los productos del carrito
  $stmt = $conn->prepare("DELETE FROM Carrito_Compra WHERE Id_Cliente = ?");
  $stmt->bind_param("i", $id_Cliente);

  if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
          echo "Todos los productos del carrito han sido eliminados y las cantidades actualizadas en la tabla de productos.";
      } else {
          echo "No se encontraron productos en el carrito para el cliente especificado.";
      }
  } else {
      echo "Error al eliminar los productos del carrito: " . $stmt->error;
  }

  // Cerrar la declaración y la conexión
  $stmt->close();
  $conn->close();
}




?>