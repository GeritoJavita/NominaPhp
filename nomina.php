<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $salarioBase = $_POST['salario'] ?? 0;
    $diasTrabajados = $_POST['diasTrabajados'] ?? 0;
    $bono = $_POST['bono'] ?? 0;

    // Calcular salario diario
    $salarioDiario = $salarioBase / 30;
    $totalSalario = $salarioDiario * $diasTrabajados;

    // Total con bono
    $totalPagar = $totalSalario + $bono;
    $descuento = 0.05 * $totalPagar;  // Suponiendo un 5% de descuento
    $netoPagar = $totalPagar - $descuento;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Nómina</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Detalle de la Nómina</h1>
        <p><strong>Nombre del empleado:</strong> <?php echo htmlspecialchars($nombre); ?></p>
        <p><strong>Salario base:</strong> $<?php echo number_format($salarioBase, 2); ?></p>
        <p><strong>Días trabajados:</strong> <?php echo $diasTrabajados; ?></p>
        <p><strong>Bono:</strong> $<?php echo number_format($bono, 2); ?></p>
        <p><strong>Salario total (sin descuentos):</strong> $<?php echo number_format($totalPagar, 2); ?></p>
        <p><strong>Descuento (5%):</strong> $<?php echo number_format($descuento, 2); ?></p>
        <p><strong>Neto a pagar:</strong> $<?php echo number_format($netoPagar, 2); ?></p>
    </div>
</body>
</html>
