<?php
// actualizar_carrito.php

// Conexión a la base de datos
$servername = "sql10.freemysqlhosting.net";
$username = "sql10736060";
$password = "v3naSQAq5W";
$dbname = "sql10736060";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

$id_cliente = intval($data['id_cliente']);
$id_producto = intval($data['id_producto']);
$nueva_cantidad = intval($data['nueva_cantidad']);

// Actualizar la cantidad en la base de datos
$stmt = $conn->prepare("UPDATE Carrito_Compra SET Cantidad_Producto = ? WHERE Id_Cliente = ? AND Id_Producto = ?");
$stmt->bind_param("iii", $nueva_cantidad, $id_cliente, $id_producto);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cantidad actualizada']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
}

$stmt->close();
$conn->close();
?>
