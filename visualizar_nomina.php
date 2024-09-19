<?php
session_start();
$empleados = $_SESSION['empleados'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Nómina</title>
    <link rel="stylesheet" href="styles_nomina.css">
</head>
<body>
    <div class="container">
        <h1>Visualizar Nómina</h1>
        <form action="generar_nomina.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Nombre</th>
                        <th>Centro de Costo</th>
                        <th>Cargo</th>
                        <th>No Identificación</th>
                        <th>Sueldo</th>
                        <th>Días Laborados</th>
                        <th>Fecha de ingreso</th>
                        <th>Horas Nocturnas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><input type="radio" name="empleado_id" value="<?php echo htmlspecialchars($empleado['no_identificacion']); ?>"></td> 
                            <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['centro_costo']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['cargo']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['no_identificacion']); ?></td>
                            <td><?php echo number_format($empleado['sueldo'], 2); ?></td>
                            <td><?php echo htmlspecialchars($empleado['dias_laborados']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['fecha_desembolso']); ?></td>
                            <td><?php echo number_format($empleado['horas_nocturnas']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="submit" name="generar_desprendible" class="button" value="Generar Desprendible">
            <input type="submit" name="generar_nomina_completa" class="button" value="Generar Nómina Completa">
        </form>
    </div>
</body>
</html>
