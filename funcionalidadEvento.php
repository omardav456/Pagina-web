<?php


function comprobarEvento(){
    // Datos de conexión
$servername = "sql10.freemysqlhosting.net";  
$username = "sql10736060";         
$password = "v3naSQAq5W";             
$dbname = "sql10736060";      

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener el primer registro de la tabla Eventos
$sql = "SELECT * FROM Eventos ORDER BY id LIMIT 1"; // Asegúrate de que 'id' sea el nombre de la columna por la que quieres ordenar
$result = $conn->query($sql);

// Comprobar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Obtener el primer registro
    $row = $result->fetch_assoc();
    // Mostrar el registro
    print_r($row);
    
} else {
    echo "No hay Eventos.";
}

// Cerrar la conexión
$conn->close();



}

function DisponibilidadCupon($idEvento){
    // Datos de conexión
    $servername = "sql10.freemysqlhosting.net";  
    $username = "sql10736060";         
    $password = "v3naSQAq5W";             
    $dbname = "sql10736060";      

// Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

// Consulta para obtener el primer registro de la tabla Eventos
    $sql = "SELECT Cupones_Entregados, Total_Cupones FROM Eventos ORDER BY id LIMIT 1"; // Ajusta 'id' según tu esquema
    $result = $conn->query($sql);

// Comprobar si se obtuvieron resultados
    if ($result->num_rows > 0) {
    // Obtener el primer registro
    $row = $result->fetch_assoc();
    
    // Comparar Cupones_Entregados y Total_Cupones
    if ($row['Cupones_Entregados'] == $row['Total_Cupones']) {
        echo "Cupones entregados son iguales a total de cupones.";
    } else {
        echo "Cupones entregados son diferentes del total de cupones.";
    }

    // Mostrar los valores (opcional)
    echo "Cupones Entregados: " . $row['Cupones_Entregados'] . "<br>";
    echo "Total Cupones: " . $row['Total_Cupones'] . "<br>";
    } else {
    echo "No hay registros en la tabla Eventos.";
    }

// Cerrar la conexión
$conn->close();

}




?>