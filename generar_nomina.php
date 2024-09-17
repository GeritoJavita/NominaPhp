<?php
session_start();
require('fpdf186/fpdf.php');

// Obtener datos de la sesión
$empleados = $_SESSION['empleados'] ?? [];

if (isset($_POST['generar_nomina_completa'])) {
    // Generar nómina completa
    foreach ($empleados as $empleado) {
        generarDesprendible($empleado);
    }
} elseif (isset($_POST['generar_desprendible']) && isset($_POST['empleado_id'])) {
    // Generar desprendible para un empleado específico
    $empleado_id = $_POST['empleado_id'];
    if (isset($empleados[$empleado_id])) {
        generarDesprendible($empleados[$empleado_id]);
    }
}
// Crear instancia de FPDF
function generarDesprendible($empleado){

// Recibe los datos del empleado
$nombre = $empleado['nombre'];
$centro_costo = $empleado['centro_costo'];
$cargo = $empleado['cargo'];
$no_identificacion = $empleado['no_identificacion'];
$sueldo = $empleado['sueldo'];
$dias_laborados = $empleado['dias_laborados'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título
$pdf->Cell(0, 10, 'Desprendible de Pago', 0, 1, 'C');

// Estilos de tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Información General', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, 'Nombre: ' . $nombre[0], 0, 1, 'L');
$pdf->Cell(0, 10, 'Centro de Costo: ' . $centro_costo[0], 0, 1, 'L');
$pdf->Cell(0, 10, 'Cargo: ' . $cargo[0], 0, 1, 'L');
$pdf->Cell(0, 10, 'No Identificación: ' . $no_identificacion[0], 0, 1, 'L');
$pdf->Cell(0, 10, 'Sueldo: ' . $sueldo[0], 0, 1, 'L');
$pdf->Cell(0, 10, 'Días Laborados: ' . $dias_laborados[0], 0, 1, 'L');

// Calcular Devengados
$salario_dias_laborados =  ($sueldo[0] / 30) * $dias_laborados[0];
$vacaciones_disfrutadas = $sueldo[0] * 21; // Ejemplo: 4% del sueldo
$auxilio_transporte = (97032/30)* $dias_laborados[0]; // Ejemplo fijo
$pago_incapacidad_eps = 0; // Ejemplo fijo
$pago_incapacidad_arl = (($sueldo[0] * 24)/30)*1; // Ejemplo fijo
$recargo_nocturno = 0; // Ejemplo fijo
$horas_dominicales = 0; // Ejemplo fijo
$auxilio_alimentacion = (150000/30) * $dias_laborados[0]; // Ejemplo fijo
$total_devengado = $salario_dias_laborados + $vacaciones_disfrutadas + $auxilio_transporte + $pago_incapacidad_eps + $pago_incapacidad_arl + $recargo_nocturno + $horas_dominicales + $auxilio_alimentacion;

// Tabla de Devengados
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Devengados', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 10, 'Concepto', 1, 0, 'C');
$pdf->Cell(0, 10, 'Valor', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 10, 'Salario según Días Laborados', 1);
$pdf->Cell(0, 10, number_format($salario_dias_laborados, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Vacaciones Disfrutadas', 1);
$pdf->Cell(0, 10, number_format($vacaciones_disfrutadas, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Auxilio de Transporte', 1);
$pdf->Cell(0, 10, number_format($auxilio_transporte, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Pago de Incapacidad EPS', 1);
$pdf->Cell(0, 10, number_format($pago_incapacidad_eps, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Pago Incapacidad ARL', 1);
$pdf->Cell(0, 10, number_format($pago_incapacidad_arl, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Recargo Nocturno', 1);
$pdf->Cell(0, 10, number_format($recargo_nocturno, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Horas Dominicales', 1);
$pdf->Cell(0, 10, number_format($horas_dominicales, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Auxilio Alimentación', 1);
$pdf->Cell(0, 10, number_format($auxilio_alimentacion, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Total Devengado', 1);
$pdf->Cell(0, 10, number_format($total_devengado, 2), 1, 1, 'R');

// Calcular Deducciones
$salud = $sueldo[0] * 0.04; // Ejemplo: 4% del sueldo
$pension = $sueldo[0] * 0.04; // Ejemplo: 4% del sueldo
$solidaridad_pension = 0; // Ejemplo fijo
$monto_prestamo = 0; // Ejemplo fijo
$num_cuotas_deducir = 0; // Ejemplo fijo
$fecha_desembolso = ''; // Ejemplo fijo
$cuotas_pagadas = 0; // Ejemplo fijo
$nomina_termina_prestamo = ''; // Ejemplo fijo
$valor_cuota = 0; // Ejemplo fijo
$saldo_prestamo = 0; // Ejemplo fijo
$deducciones_totales = $salud + $pension + $solidaridad_pension + $monto_prestamo;
$total_nomina_pagar = $total_devengado - $deducciones_totales;

// Cálculo de Prestaciones Sociales
$prima = ($sueldo[0] + $auxilio_transporte) * 0.083;
$cesantias = ($sueldo[0] + $auxilio_transporte )* 0.083;
$intereses_cesantias = $cesantias * 0.12;
$vacaciones = $sueldo[0]*0.041;
$total_prestaciones = $prima + $cesantias + $intereses_cesantias + $vacaciones;
// Tabla de Deducciones
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Deducciones', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 10, 'Concepto', 1, 0, 'C');
$pdf->Cell(0, 10, 'Valor', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 10, 'Salud', 1);
$pdf->Cell(0, 10, number_format($salud, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Pensión', 1);
$pdf->Cell(0, 10, number_format($pension, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Solidaridad de Pensión', 1);
$pdf->Cell(0, 10, number_format($solidaridad_pension, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Monto del Desembolso', 1);
$pdf->Cell(0, 10, number_format($monto_prestamo, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'No. de Cuotas a Descontar', 1);
$pdf->Cell(0, 10, $num_cuotas_deducir, 1, 1, 'R');

$pdf->Cell(80, 10, 'Fecha del Desembolso', 1);
$pdf->Cell(0, 10, $fecha_desembolso, 1, 1, 'R');

$pdf->Cell(80, 10, 'No. de Cuotas Pagadas', 1);
$pdf->Cell(0, 10, $cuotas_pagadas, 1, 1, 'R');

$pdf->Cell(80, 10, 'Nómina en que Termina el Préstamo', 1);
$pdf->Cell(0, 10, $nomina_termina_prestamo, 1, 1, 'R');

$pdf->Cell(80, 10, 'Valor de Cuota', 1);
$pdf->Cell(0, 10, number_format($valor_cuota, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Saldo al Préstamo', 1);
$pdf->Cell(0, 10, number_format($saldo_prestamo, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Deducciones Totales', 1);
$pdf->Cell(0, 10, number_format($deducciones_totales, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Total Nómina a Pagar', 1);
$pdf->Cell(0, 10, number_format($total_nomina_pagar, 2), 1, 1, 'R');

// Tabla de Prestaciones Sociales
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Prestaciones Sociales', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 10, 'Concepto', 1, 0, 'C');
$pdf->Cell(0, 10, 'Valor', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 10, 'Prima de Servicios', 1);
$pdf->Cell(0, 10, number_format($prima, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Cesantías', 1);
$pdf->Cell(0, 10, number_format($cesantias, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Intereses de Cesantías', 1);
$pdf->Cell(0, 10, number_format($intereses_cesantias, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Vacaciones', 1);
$pdf->Cell(0, 10, number_format($vacaciones, 2), 1, 1, 'R');

$pdf->Cell(80, 10, 'Total Prestaciones', 1);
$pdf->Cell(0, 10, number_format($total_prestaciones, 2), 1, 1, 'R');

// Output the PDF
$pdf->Output();
}
?>
