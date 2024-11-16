<?php
function consultarCupones($id_cliente){
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

// Consulta SQL
$sql = "
    SELECT c.*, e.Fecha_Final 
    FROM Cupon c
    JOIN Evento e ON c.Id_Evento = e.Id_Evento 
    WHERE c.Id_Cliente = ?";
    
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente); // "i" indica que el parámetro es un entero
$stmt->execute();

// Obtener el resultado
$result = $stmt->get_result();
$array_resultado = []; // Array para guardar los resultados

if ($result->num_rows > 0) {
    // Guardar los datos en el array
    while($row = $result->fetch_assoc()) {
        $array_resultado[] = $row;
    }
} else {
    echo "0 resultados";
}



// Cerrar conexiones
$stmt->close();
$conn->close();
print_r ($array_resultado);

}

function agregarCupon($id_cliente, $id_evento) {
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

    // Valor del descuento
    $descuento_cupon = 5000;

    // Consulta SQL para insertar
    $stmt = $conn->prepare("INSERT INTO Cupon (Id_Cliente, Nombre_Cupon, Descuento_Cupon, Id_Evento) VALUES (?, ?, ?, ?)");
    $nombre_cupon = "Prueba"; // Usar variable para mayor claridad
    $stmt->bind_param("isii", $id_cliente, $nombre_cupon, $descuento_cupon, $id_evento);
    
    // Ejecutar la consulta y verificar errores
    if (!$stmt->execute()) {
        echo "Error al insertar el cupón: " . $stmt->error;
        return;
    }
    
    echo 'Producto insertado, ID: ' . $stmt->insert_id;

    // Consulta SQL para actualizar
    $stmt->close(); // Cerrar el statement anterior
    $stmt = $conn->prepare("UPDATE Evento SET Cupones_Entregados = Cupones_Entregados + ? WHERE Id_Evento = ?");
    
    // Valor a agregar
    $cupones_a_entregar = 1;
    $stmt->bind_param("ii", $cupones_a_entregar, $id_evento);
    
    // Ejecutar la consulta y verificar errores
    if (!$stmt->execute()) {
        echo "Error al actualizar los cupones: " . $stmt->error;
        return;
    }
    
    echo 'Cupones actualizados para el evento con ID: ' . $id_evento;

    // Cerrar el statement y la conexión
    $stmt->close();
    $conn->close();
}


?>