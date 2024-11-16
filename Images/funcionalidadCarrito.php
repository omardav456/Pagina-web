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


function agregarProducto($id_cliente,$id_producto, $cantidad){
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
// Verifica si existe el registro
  $stmt = $conn->prepare("SELECT * FROM Carrito_Compra WHERE Id_cliente = ? AND Id_Producto = ?");
  $stmt->bind_param("is", $id_cliente, $id_producto);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE Carrito_Compra SET Cantidad_Producto = Cantidad_Producto+ ? WHERE Id_Cliente = ? AND Id_Producto = ?");
    $stmt->bind_param("iii", $cantidad, $id_cliente, $id_producto);
    $stmt->execute();
  
    echo 'Cantidad actualizada: ' . $stmt->affected_rows;
  }else{
    $stmt = $conn->prepare("INSERT INTO Carrito_Compra (Id_Cliente, Id_Producto, Cantidad_Producto) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $id_cliente,$id_producto,$cantidad);
    $stmt->execute();
    $result = $stmt->get_result();
    echo 'Producto insertado, ID: ' . $stmt->insert_id;
  }

  $stmt->close();

  $conn->close();

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
    echo 'Cantidad actualizada: ' . $stmt->affected_rows;

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
        echo "Producto eliminado del carrito.";
      } else {
        echo "No se encontró el producto para eliminar.";
      }
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();



}
?>