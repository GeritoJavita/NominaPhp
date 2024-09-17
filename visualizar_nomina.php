<?php
session_start();
$empleados = $_SESSION['empleados'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Nómina</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            width: 70%;
            margin: 0 auto;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $index => $empleado): ?>
                        <tr>
                            <td><input type="radio" name="empleado_id" value="<?php echo $index; ?>"></td>
                            <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['centro_costo']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['cargo']); ?></td>
                            <td><?php echo htmlspecialchars($empleado['no_identificacion']); ?></td>
                            <td><?php echo number_format($empleado['sueldo'], 2); ?></td>
                            <td><?php echo htmlspecialchars($empleado['dias_laborados']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="submit" name="generar_desprendible" class="button" value="Generar Desprendible">
            <input type="hidden" name="toda_nomina" value="1">
            <input type="submit" name="generar_nomina_completa" class="button" value="Generar Nómina Completa">
        </form>
    </div>
</body>
</html>
