<?php
session_start();
include 'funcionalidadCupones.php';
 // Establece un total inicial.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total = $_POST['total'];
    $detalles = $_POST['detalles'];
    $id_cliente= intval( $_SESSION['id']);
} else {
    echo "<h2>No se han enviado datos.</h2>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Cupones</title>
    <link rel="stylesheet" href="stylescupon.css">
    <style>
        .coupon-container {
            margin: 20px;
        }
        .coupon-menu {
            display: none; /* Ocultar el menú inicialmente */
        }
        .coupon-item {
            margin: 10px 0;
        }
        .total-container {
            margin-top: 20px;
            font-size: 1.2em;
            text-align: center; /* Centrar el texto */
        }
        .hidden {
            display: none;
        }
        .show {
            display: block;
        }
        /* Estilos para el botón de proceder al pago */
        .proceed-button {
            background-color: #4CAF50; /* Verde */
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        .proceed-button:hover {
            background-color: #45a049; /* Verde más oscuro */
        }
    </style>
</head>
<body>

<div class="coupon-container">
    <button id="toggleButton" class="coupon-btn" onclick="toggleMenu()">💸 Ver cupones</button>
    
    <div class="coupon-menu" id="couponMenu">
        <?php $cupones = consultarCupones($id_cliente); ?>
        
        <?php foreach ($cupones as $cupon): ?>
            <div class="coupon-item">
                <p><?php echo number_format($cupon['Descuento_Cupon'], 0, ',', '.'); ?> Pesos</p>
                <button class="apply-btn" onclick="applyCoupon(this, <?php echo $cupon['Descuento_Cupon']; ?>, <?php echo $cupon['Id_Cupon']; ?>)">Aplicar Cupón</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="total-container">
    <h3>Total a Pagar: <span id="totalAmount"><?php echo number_format($total, 0, ',', '.'); ?> Pesos</span></h3>
    <form id="paymentForm" method="POST" action="pago.php">
        <input type="hidden" name="total" id="totalInput" value="<?php echo $total; ?>">
        <input type="hidden" name="Id_Cupon" id="Id_Cupon">  <!-- Campo oculto para el Id_Cupon -->
        <input type="hidden" name="detalles" id="detallesInput" value="<?php echo $detalles; ?>">
        <button id="proceedButton" class="proceed-button" type="submit" onclick="updateTotal()">Proceder al Pago</button>
    </form>
</div>

<script>
    let currentTotal = <?php echo $total; ?>;
    let couponApplied = false; // Variable para verificar si se ha aplicado un cupón

    function toggleMenu() {
        const menu = document.getElementById('couponMenu');
        menu.classList.toggle('show');
    }

    function applyCoupon(button, discount, idCupon) {
        if (couponApplied) {
            alert("Ya se ha aplicado un cupón. Solo se permite uno.");
            return; // Salir si ya se ha aplicado un cupón
        }

        // Ocultar el menú de cupones y el botón
        const menu = document.getElementById('couponMenu');
        menu.innerHTML = ""; // Borra toda la información del menú
        document.getElementById('toggleButton').classList.add('hidden');

        // Actualizar el total
        currentTotal -= discount;
        document.getElementById('totalAmount').textContent = currentTotal.toLocaleString() + " Pesos";
        document.getElementById('totalInput').value = currentTotal; // Actualizar el valor del total en el formulario

        // Asignar el ID del cupón al campo oculto
        document.getElementById('Id_Cupon').value = idCupon;

        // Mostrar mensaje de éxito
        alert(`Cupón de ${discount} aplicado! Nuevo total: ${currentTotal.toLocaleString()} Pesos`);

        couponApplied = true; // Marcar que se ha aplicado un cupón
    }

    function updateTotal() {
        document.getElementById('totalInput').value = currentTotal; // Asegurarse de que el total sea correcto
    }
</script>

</body>
</html>
