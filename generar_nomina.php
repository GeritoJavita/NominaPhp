<?php
session_start();
require('fpdf186/fpdf.php');

// Obtener datos de la sesión
$empleados = $_SESSION['empleados'] ?? [];

if (isset($_POST['generar_nomina_completa'])) {
    // Generar nomina completa
    generarNominaCompleta($empleados);

    
    


} elseif (isset($_POST['generar_desprendible']) && isset($_POST['empleado_id'])) {
    // Generar desprendible para un empleado específico
    $empleado_id = $_POST['empleado_id'];
    foreach ($empleados as $empleado) {
        if ($empleado['no_identificacion'] == $empleado_id) {
            // Crear un nuevo objeto FPDF para el desprendible individual
            $pdf = new FPDF(); 
            $pdf->AddPage();

            generarDesprendible($empleado, $pdf); 
            $pdf->Output(); 

            break; 
        }
    }
}



    
 
// Función para generar la nomina completa
function generarNominaCompleta($empleados) {
    $pdf = new FPDF();
    $pdf->AddPage(); 
    $pdf->SetFont('Arial', 'B', 12);

    // Título
    $pdf->Cell(0, 10, 'Nomina Completa', 0, 1, 'C');

    foreach ($empleados as $empleado) {
         // Recibe los datos del empleado
         $pdf->Cell(0, 10, ' Informacion General', 0, 1, 'C');
    $nombre = $empleado['nombre'];
    $centro_costo = $empleado['centro_costo'];
    $cargo = $empleado['cargo'];
    $no_identificacion = $empleado['no_identificacion'];
    $sueldo = $empleado['sueldo'];
    $dias_laborados = $empleado['dias_laborados'];
        // Título de cada empleado
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Nombre: ' . $nombre, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Centro de Costo: ' . $centro_costo, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Cargo: ' . $cargo, 0, 1, 'L');
        $pdf->Cell(0, 10, 'No Identificacinn: ' . $no_identificacion, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Sueldo: ' . $sueldo, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Dias Laborados: ' . $dias_laborados, 0, 1, 'L');
    

        // Tabla de Devengados
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Devengados', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(80, 10, 'Concepto', 1, 0, 'C');
        $pdf->Cell(0, 10, 'Valor', 1, 1, 'C');

        // Cálculo de devengados
        $salario_dias_laborados = ($empleado['sueldo'] / 30) * $empleado['dias_laborados'];
        $auxilio_transporte = (97032 / 30) * $empleado['dias_laborados'];
        $total_devengado = $salario_dias_laborados + $auxilio_transporte;

        // Añadir devengados a la tabla
        $pdf->Cell(80, 10, 'Salario segun Dias Laborados', 1);
        $pdf->Cell(0, 10, number_format($salario_dias_laborados, 2), 1, 1, 'R');
        $pdf->Cell(80, 10, 'Auxilio de Transporte', 1);
        $pdf->Cell(0, 10, number_format($auxilio_transporte, 2), 1, 1, 'R');

        $pdf->Cell(80, 10, 'Total Devengado', 1);
        $pdf->Cell(0, 10, number_format($total_devengado, 2), 1, 1, 'R');

        // Tabla de Deducciones
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Deducciones', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(80, 10, 'Concepto', 1, 0, 'C');
        $pdf->Cell(0, 10, 'Valor', 1, 1, 'C');

        // Cálculo de deducciones
        $salud = $empleado['sueldo'] * 0.04;
        $pension = $empleado['sueldo'] * 0.04;
        $total_deducciones = $salud + $pension;

        // Añadir deducciones a la tabla
        $pdf->Cell(80, 10, 'Salud', 1);
        $pdf->Cell(0, 10, number_format($salud, 2), 1, 1, 'R');
        $pdf->Cell(80, 10, 'Pension', 1);
        $pdf->Cell(0, 10, number_format($pension, 2), 1, 1, 'R');

        $pdf->Cell(80, 10, 'Total Deducciones', 1);
        $pdf->Cell(0, 10, number_format($total_deducciones, 2), 1, 1, 'R');

        // Tabla de Prestaciones Sociales
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Prestaciones Sociales', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(80, 10, 'Concepto', 1, 0, 'C');
        $pdf->Cell(0, 10, 'Valor', 1, 1, 'C');

        // Cálculo de prestaciones sociales
        $prima = ($empleado['sueldo'] + $auxilio_transporte) * 0.083;
        $cesantias = ($empleado['sueldo'] + $auxilio_transporte) * 0.083;
        $intereses_cesantias = $cesantias * 0.12;
        $vacaciones = $empleado['sueldo'] * 0.041;

        // Añadir prestaciones sociales a la tabla
        $pdf->Cell(80, 10, 'Prima de Servicios', 1);
        $pdf->Cell(0, 10, number_format($prima, 2), 1, 1, 'R');
        $pdf->Cell(80, 10, 'Cesantias', 1);
        $pdf->Cell(0, 10, number_format($cesantias, 2), 1, 1, 'R');
        $pdf->Cell(80, 10, 'Intereses de Cesantias', 1);
        $pdf->Cell(0, 10, number_format($intereses_cesantias, 2), 1, 1, 'R');
        $pdf->Cell(80, 10, 'Vacaciones', 1);
        $pdf->Cell(0, 10, number_format($vacaciones, 2), 1, 1, 'R');

        $pdf->Cell(80, 10, 'Total Prestaciones', 1);
        $pdf->Cell(0, 10, number_format($prima + $cesantias + $intereses_cesantias + $vacaciones, 2), 1, 1, 'R');

        // Espacio entre empleados
        $pdf->Ln(10);
    }

    // Output the PDF
    $pdf->Output();
}


// Función para calcular el total a pagar
function calcularTotalAPagar($empleado) {
    $sueldo = $empleado['sueldo'];
    $dias_laborados = $empleado['dias_laborados'];

    // Calcular devengados
    $salario_dias_laborados = ($sueldo / 30) * $dias_laborados;
    $auxilio_transporte = (97032 / 30) * $dias_laborados; // Valor de auxilio de transporte 
    $total_devengado = $salario_dias_laborados + $auxilio_transporte; // Puedes agregar más devengados 

    // Calcular deducciones
    $salud = $sueldo * 0.04;
    $pension = $sueldo * 0.04;
    $total_deducciones = $salud + $pension; // Puedes agregar más deducciones aquí

    // Total a pagar
    $total_a_pagar = $total_devengado - $total_deducciones;

    return $total_a_pagar;
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
    $fecha_desembolso = $empleado['fecha_desembolso'];
    $horas_nocturas = $empleado['horas_nocturnas'];

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Título
    $pdf->Cell(0, 10, 'Desprendible de Pago', 0, 1, 'C');

    // Estilos de tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Informacion General', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Nombre: ' . $nombre, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Centro de Costo: ' . $centro_costo, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Cargo: ' . $cargo, 0, 1, 'L');
    $pdf->Cell(0, 10, 'No Identificacinn: ' . $no_identificacion, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Sueldo: ' . $sueldo, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Dias Laborados: ' . $dias_laborados, 0, 1, 'L');



    // Calcular Devengados
    $salario_dias_laborados =  ($sueldo / 30) * $dias_laborados;
    $vacaciones_disfrutadas = $sueldo * 21; // Ejemplo: 4% del sueldo
    $auxilio_transporte = (97032/30)* $dias_laborados; // Ejemplo fijo
    $pago_incapacidad_arl = (($sueldo * 24)/30)*1; // Ejemplo fijo
    $recargo_nocturno = $horas_nocturas * 13000;
    $horas_dominicales = 0;


    if($dias_laborados <= 90){
        $pago_incapacidad_eps = ($sueldo*2)+(($sueldo * 0.6667)*88)+ (($sueldo *0.5)*90);
    }    
     elseif($dias_laborados <=180) {

        $pago_incapacidad_eps = ($sueldo*2)+ (($sueldo * 0.6667)*88) + (($sueldo *0.5) * ($dias_laborados - 90));

     }
    
    $auxilio_alimentacion = (150000/30) * $dias_laborados; // Ejemplo fijo
    $total_devengado = $salario_dias_laborados + $vacaciones_disfrutadas + $auxilio_transporte + $pago_incapacidad_arl  + $auxilio_alimentacion;

    // Tabla de Devengados
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Devengados', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(80, 10, 'Concepto', 1, 0, 'C');
    $pdf->Cell(0, 10, 'Valor', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(80, 10, 'Salario segun Dias Laborados', 1);
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

    $pdf->Cell(80, 10, 'Auxilio Alimentacion', 1);
    $pdf->Cell(0, 10, number_format($auxilio_alimentacion, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Total Devengado', 1);
    $pdf->Cell(0, 10, number_format($total_devengado, 2), 1, 1, 'R');

    // Calcular Deducciones
    $salud = $sueldo * 0.04; // Ejemplo: 4% del sueldo
    $pension = $sueldo * 0.04; // Ejemplo: 4% del sueldo
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
    $prima = ($sueldo + $auxilio_transporte) * 0.083;
    $cesantias = ($sueldo + $auxilio_transporte )* 0.083;
    $intereses_cesantias = $cesantias * 0.12;
    $vacaciones = $sueldo*0.041;
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

    $pdf->Cell(80, 10, 'Pension', 1);
    $pdf->Cell(0, 10, number_format($pension, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Solidaridad de Pension', 1);
    $pdf->Cell(0, 10, number_format($solidaridad_pension, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Monto del Desembolso', 1);
    $pdf->Cell(0, 10, number_format($monto_prestamo, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'No. de Cuotas a Descontar', 1);
    $pdf->Cell(0, 10, $num_cuotas_deducir, 1, 1, 'R');

    $pdf->Cell(80, 10, 'Fecha del Desembolso', 1);
    $pdf->Cell(0, 10, $fecha_desembolso, 1, 1, 'R');

    $pdf->Cell(80, 10, 'No. de Cuotas Pagadas', 1);
    $pdf->Cell(0, 10, $cuotas_pagadas, 1, 1, 'R');

    $pdf->Cell(80, 10, 'Nomina en que Termina el Prestamo', 1);
    $pdf->Cell(0, 10, $nomina_termina_prestamo, 1, 1, 'R');

    $pdf->Cell(80, 10, 'Valor de Cuota', 1);
    $pdf->Cell(0, 10, number_format($valor_cuota, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Saldo al Préstamo', 1);
    $pdf->Cell(0, 10, number_format($saldo_prestamo, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Deducciones Totales', 1);
    $pdf->Cell(0, 10, number_format($deducciones_totales, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Total Nomina a Pagar', 1);
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

    $pdf->Cell(80, 10, 'Cesantias', 1);
    $pdf->Cell(0, 10, number_format($cesantias, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Intereses de Cesantias', 1);
    $pdf->Cell(0, 10, number_format($intereses_cesantias, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Vacaciones', 1);
    $pdf->Cell(0, 10, number_format($vacaciones, 2), 1, 1, 'R');

    $pdf->Cell(80, 10, 'Total Prestaciones', 1);
    $pdf->Cell(0, 10, number_format($total_prestaciones, 2), 1, 1, 'R');

    // Output the PDF
    $pdf->Output();
}
?>