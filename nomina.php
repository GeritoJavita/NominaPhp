<?php
require('fpdf186/fpdf.php');

// Recibir datos del formulario
$empleados = [];
foreach ($_POST['nombre'] as $index => $nombre) {
    $empleados[] = [
        'nombre' => $nombre,
        'salario' => $_POST['salario'][$index],
        'diasTrabajados' => $_POST['diasTrabajados'][$index],
        'bono' => $_POST['bono'][$index]
    ];
}

// Función para generar nómina en PDF
function generarNominaPDF($empleados) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(190, 10, 'Nómina de Empleados', 1, 1, 'C');

    // Cabecera
    $pdf->Cell(40, 10, 'Nombre', 1);
    $pdf->Cell(40, 10, 'Salario Base', 1);
    $pdf->Cell(40, 10, 'Dias Trabajados', 1);
    $pdf->Cell(30, 10, 'Bono', 1);
    $pdf->Cell(40, 10, 'Total a Pagar', 1);
    $pdf->Ln();

    // Datos de los empleados
    foreach ($empleados as $empleado) {
        $totalSalario = ($empleado['salario'] / 30) * $empleado['diasTrabajados'] + $empleado['bono'];
        $pdf->Cell(40, 10, $empleado['nombre'], 1);
        $pdf->Cell(40, 10, number_format($empleado['salario'], 2), 1);
        $pdf->Cell(40, 10, $empleado['diasTrabajados'], 1);
        $pdf->Cell(30, 10, number_format($empleado['bono'], 2), 1);
        $pdf->Cell(40, 10, number_format($totalSalario, 2), 1);
        $pdf->Ln();
    }

    // Salida del archivo
    $pdf->Output('D', 'nomina.pdf');
}

generarNominaPDF($empleados);
