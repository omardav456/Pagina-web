<?php
session_start();
require('fpdf186/fpdf.php');
include 'funcionalidadFactura.php';

// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['Id_Factura'])) {
    AgregarFactura(intval($_SESSION['id']), $_POST['cedula'], $_POST['detalles'], $_POST['telefono'], $_POST['direccion'], $_POST['total'], $_POST['metodo_pago'], $_POST['Id_Cupon']);
    header("Location: usuario.php");
}

// Verificar si el campo 'Id_Factura' está presente en la solicitud POST
if (isset($_POST['Id_Factura'])) {
    $factura = ObtenerFacturaporId(intval($_POST['Id_Factura']));

    // Iniciar el PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Fondo de encabezado con color sólido (gris oscuro)
    $pdf->SetFillColor(33, 33, 33); // Fondo gris oscuro
    $pdf->Rect(0, 0, 210, 40, 'F'); // Fondo de encabezado

    // Título de la factura y fecha con fondo sólido (naranja brillante)
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(255, 140, 0); // Naranja brillante
    $pdf->Rect(0, 0, 210, 20, 'F'); // Fondo naranja brillante
    $pdf->Cell(190, 10, 'Factura Especial de Halloween', 0, 1, 'C', true);
    $pdf->Ln(5);

    // Fondo para el número de factura y fecha (gris oscuro para uniformidad)
    $pdf->SetFillColor(33, 33, 33); // Fondo gris oscuro
    $pdf->Rect(0, 20, 210, 20, 'F'); // Fondo gris para fecha y número de factura
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(255, 255, 255); // Blanco para texto
    $pdf->Cell(95, 10, 'Factura #'.$factura['Id_Factura'], 0, 0);
    $pdf->Cell(95, 10, 'Fecha: '.date('d/m/Y'), 0, 1, 'R');
    $pdf->Ln(10);

    // Información del cliente - color gris claro
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0); // Gris claro
    $pdf->Cell(95, 10, 'Cliente: '.$factura['Cedula_Cliente'], 0, 1);
    $pdf->Cell(95, 10, 'Telefono: '.$factura['Telefono_Cliente'], 0, 1);
    $direccion = ($factura['Direccion_Cliente']);
    $pdf->Cell(95, 10, 'Direccion: '.$direccion, 0, 1);
    $pdf->Ln(10);

    // Detalles de los productos
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(255, 165, 0); // Naranja brillante para destacar
    $pdf->Cell(190, 10, 'Detalles de los Productos', 0, 1, 'C');
    $pdf->Ln(5);

    // Crear tabla para los productos (con bordes elegantes y un toque de Halloween)
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0); // Color de texto oscuro
    $pdf->SetDrawColor(255, 140, 0); // Naranja para bordes

    // Encabezado de la tabla de productos con fondo oscuro y texto blanco
    $pdf->SetFillColor(255, 140, 0); // Naranja brillante
    $pdf->Cell(30, 10, 'ID', 1, 0, 'C', true);
    $pdf->Cell(70, 10, 'Producto', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Precio (COP)', 1, 1, 'C', true);

    // Detalles de los productos (con bordes y alineación adecuada)
    $pdf->SetFont('Arial', '', 12);
    $detallesProductos = explode("\n", $factura['Productos_Factura']);
    foreach ($detallesProductos as $producto) {
        // El formato es "ID: 34, Producto: Iphone 16, Cantidad: 1, Precio: 1900000"
        preg_match('/ID: (\d+), Producto: (.*), Cantidad: (\d+), Precio: ([0-9,]+)/', $producto, $matches);

        // Solo procesamos las líneas que coinciden con el formato correcto
        if (count($matches) == 5) {
            $id = $matches[1];
            $productoNombre = $matches[2];
            $cantidad = $matches[3];
            $precio = number_format(floatval($matches[4]), 2, ',', '.');

            // Rellenar las celdas con la información del producto
            $pdf->Cell(30, 10, $id, 1, 0, 'C');
            $pdf->Cell(70, 10, $productoNombre, 1, 0, 'L');
            $pdf->Cell(30, 10, $cantidad, 1, 0, 'C');
            $pdf->Cell(50, 10, $precio, 1, 1, 'C');
        }
    }

    // Total y Estado de la factura (en color verde calabaza)
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(76, 175, 80); // Verde calabaza

    // Alinear el total con la columna de precios
    $pdf->Cell(130, 10, 'Total: ', 0, 0, 'R');
    $pdf->Cell(50, 10, number_format(floatval($factura["Total_Factura"]), 2, ',', '.'), 0, 1, 'C');
    $pdf->Cell(130, 10, 'Estado: '. $factura["Estado_Factura"], 0, 1);

    // Método de pago (verde brillante)
    $pdf->SetTextColor(0, 255, 0); // Verde brillante
    $pdf->Cell(130, 10, 'Metodo de Pago: '. $factura["Metodo_Pago"], 0, 1);
    $pdf->Ln(10);

    // Agregar una imagen temática de Halloween (calabaza)
    $pdf->Image('calabaza.png', 170, 220, 30, 30); // Imagen de Halloween

    // Línea de pie de página decorativa (naranja brillante)
    $pdf->SetDrawColor(255, 140, 0); // Naranja brillante
    $pdf->SetLineWidth(1.5);
    $pdf->Line(10, 270, 200, 270); // Línea decorativa

    // Mensaje adicional de agradecimiento (con sombra para un toque de elegancia)
    $pdf->SetTextColor(169, 169, 169); // Gris suave para sombra
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Text(165, 275, '¡Gracias por confiar en nosotros!');

    // Marco adicional alrededor de la página para un diseño más elegante
    $pdf->SetDrawColor(0, 0, 0); // Negro para el marco exterior
    $pdf->SetLineWidth(2);
    $pdf->Rect(5, 5, 200, 287); // Marco negro alrededor de la factura

    // Salida del PDF al navegador
    $pdf->Output('I', 'Factura_'.$factura['Id_Factura'].'.pdf'); // 'I' para mostrar el PDF en el navegador
} else {
    echo "No se recibió el ID de la factura.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <script type="text/javascript">
        // Función para abrir la ventana con el nombre dinámico
        function abrirVentana() {
            // Nombre de la ventana generado dinámicamente desde PHP
            var ventanaNombre = "<?php echo $ventanaNombre; ?>";
            // Usar window.open() para abrir la ventana con el nombre generado
            window.open("generar_pdf.php?Id_Factura=<?php echo $_POST['Id_Factura']; ?>", ventanaNombre, "width=800, height=600");
        }

        // Al cargar la página, automáticamente abrir la ventana con el PDF generado
        window.onload = function() {
            abrirVentana();
        }
    </script>
</head>
<body>
    
</body>
</html>
