<?php 
session_start();
include 'funcionalidadCupones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalFactura  = $_POST['total'];
    $detalles = $_POST['detalles'];
    $id_cliente = intval($_SESSION['id']);
    $idcupon=$_POST['Id_Cupon'];
    //echo "<script>alert('".$idcupon."');</script>";
    
} else {
    echo "<h2>No se han enviado datos.</h2>";
}

// Cambia esto según tus necesidades

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pago</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-form {
            margin-top: 50px;
            border: 1px solid #ced4da;
            padding: 20px;
            border-radius: 5px;
            background-color: white;
        }
        .total-container {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="payment-form">
        <h2 class="text-center">Formulario de Pago</h2>
        <form method="POST" action="usuario.php">
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d{10}" title="Ingrese 10 dígitos" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="detalles">Detalles del Producto</label>
                <textarea class="form-control" id="detalles" name="detalles" rows="3" readonly><?php echo htmlspecialchars($detalles); ?></textarea>
            </div>
            <div class="total-container">
                <p>Total de la factura: <span id="total"><?php echo number_format($totalFactura, 2, ',', '.'); ?> COP</span></p>
            </div>
            <div class="form-group" style="visibility:hidden;">
                <input type="hidden" name="total" value="<?php echo $totalFactura; ?>">
                <input type="hidden" name="Id_Cupon" id="Id_Cupon" value="<?php echo $idcupon; ?>">  <!-- Campo oculto para el Id_Cupon -->
                <select class="form-control" id="estado" name="estado" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Pagado">Pagado</option>
                </select>
            </div>
            <div class="form-group">
                <label>Método de Pago</label>
                <select class="form-control" name="metodo_pago" required>
                    <option value="Contraentrega">Contraentrega</option>
                    <option value="Tarjeta">Tarjeta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Realizar Pago</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
