<?php
include 'funcionalidadCupones.php';
include 'funcionalidadCarrito.php';
    function AgregarFactura($id_Cliente, $Cedula, $Productos, $Telefono, $Direccion, $Total, $Metodo, $idcupon) {
        // Datos de conexión
        $servername = "sql10.freemysqlhosting.net";  
        $username = "sql10736060";         
        $password = "v3naSQAq5W";             
        $dbname = "sql10736060";      
    
        // Crear la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($conn, "utf8mb4");
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Preparar la sentencia SQL para insertar la factura
        $stmt = $conn->prepare("INSERT INTO Facturas (Id_Cliente, Cedula_Cliente, Productos_Factura, Telefono_Cliente, Direccion_Cliente, Total_Factura, Metodo_Pago) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Vincular parámetros
        $stmt->bind_param("issssss", $id_Cliente, $Cedula, $Productos, $Telefono, $Direccion, $Total, $Metodo);
    
        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Obtener el ID de la factura insertada
            $id_factura = $conn->insert_id;
    
            // Verificar si el método es "Contraentrega"
            if ($Metodo === "Contraentrega") {
                // Actualizar el estado de la factura a "Pendiente"
                $stmt3 = $conn->prepare("UPDATE Facturas SET Estado_Factura = 'Pendiente' WHERE Id_Factura = ?");
                $stmt3->bind_param("i", $id_factura);
                $stmt3->execute();
                $stmt3->close();
            }else{
                $stmt3 = $conn->prepare("UPDATE Facturas SET Estado_Factura = 'Transaccion' WHERE Id_Factura = ?");
                $stmt3->bind_param("i", $id_factura);
                $stmt3->execute();
                $stmt3->close();

            }
    
            //echo "Factura agregada exitosamente. ID: " . $id_factura;
            if ($idcupon>0) {
                eliminarCupon($idcupon);
            }
            eliminarTodoCarrito($id_Cliente);

        } else {
            //echo "Error al agregar la factura: " . $stmt->error;
        }
    
        // Cerrar la declaración y la conexión
        $stmt->close();
        $conn->close();
    }
    function consultarFacturas($idCliente){
        // Datos de conexión
$servername = "sql10.freemysqlhosting.net";  
$username = "sql10736060";         
$password = "v3naSQAq5W";             
$dbname = "sql10736060";      

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8mb4");
// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ID del cliente que deseas consultar


// Consulta para obtener todas las facturas del cliente
$sql = "SELECT * FROM Facturas WHERE Id_Cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCliente); // Asumiendo que Id_Cliente es un entero
$stmt->execute();
$result = $stmt->get_result();

// Comprobar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Mostrar todas las facturas
    // Cerrar la conexión
    $stmt->close();
    $conn->close();
    return $result;
} else {

    echo "No se encontraron facturas para este cliente.";
    
}

// Cerrar la conexión
$stmt->close();
$conn->close();


    }
    function ObtenerFacturaporId($idFactura) {
        // Datos de conexión
        $servername = "sql10.freemysqlhosting.net";  
        $username = "sql10736060";         
        $password = "v3naSQAq5W";             
        $dbname = "sql10736060";  
    
        // Crear la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($conn, "utf8mb4");
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Preparar la consulta SQL
        $sql = "SELECT * FROM Facturas WHERE Id_Factura = ?";
        
        // Usar sentencias preparadas para prevenir SQL Injection
        if ($stmt = $conn->prepare($sql)) {
            // Bind de los parámetros
            $stmt->bind_param("i", $idFactura); // 'i' es el tipo de dato entero para idFactura
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener los resultados
            $result = $stmt->get_result();
    
            // Verificar si se encontró la factura
            if ($result->num_rows > 0) {
                // Obtener los datos de la factura
                $factura = $result->fetch_assoc(); // Retorna la factura como un arreglo asociativo
    
                // Aquí puedes retornar la factura o procesarla como desees
                return $factura;
            } else {
                //echo "No se encontró la factura con el ID proporcionado.";
                return null;
            }
    
            // Cerrar la declaración
            $stmt->close();
        } else {
            //echo "Error al preparar la consulta: " . $conn->error;
        }
    
        // Cerrar la conexión
        $conn->close();
    }


?>