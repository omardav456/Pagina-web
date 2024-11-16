<?php
session_start();
require('fpdf186/fpdf.php');
include 'funcionalidadFactura.php';
// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    AgregarFactura(intval( $_SESSION['id']), $cedula, $detalles, $telefono, $direccion, $total, $metodo_pago, $idcupon);
    

    // Crear un nuevo PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    
    // Agregar contenido al PDF
    $pdf->Cell(40, 10, 'Factura');
    $pdf->Ln();
    $pdf->Cell(40, 10, "Cedula: $cedula");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Telefono: $telefono");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Direccion: $direccion");
    $pdf->Ln();
    
    // Reemplazar saltos de línea por guiones
    $detallesConGuiones = str_replace("\n", "\n- ", $detalles);
    
    // Usar MultiCell para los detalles
    $pdf->Cell(40, 10, "Detalles: ");
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 12); // Cambiar el tamaño de la fuente para detalles
    $pdf->MultiCell(0, 10, "- " . $detallesConGuiones); // Agregar un guion al inicio
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, "Total: $totalFactura COP");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Estado: $estado");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Metodo de Pago: $metodo_pago");
    
    // Salida del PDF
    $pdf->Output();
    



}







?>
