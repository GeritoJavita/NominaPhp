<?php
session_start();

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$centro_costo = $_POST['centro_costo'];
$cargo = $_POST['cargo'];
$no_identificacion = $_POST['no_identificacion'];
$sueldo = $_POST['sueldo'];
$dias_laborados = $_POST['dias_laborados'];

// Crear un array con los datos de los empleados
$empleados = [];
for ($i = 0; $i < count($nombre); $i++) {
    $empleados[] = [
        'nombre' => $nombre[$i],
        'centro_costo' => $centro_costo[$i],
        'cargo' => $cargo[$i],
        'no_identificacion' => $no_identificacion[$i],
        'sueldo' => $sueldo[$i],
        'dias_laborados' => $dias_laborados[$i],
    ];
}

// Guardar los datos en la sesión
$_SESSION['empleados'] = $empleados;

// Redirigir a la página de visualización
header('Location: visualizar_nomina.php');
exit();
?>
