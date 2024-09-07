<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numEmpleados = $_POST['numEmpleados'] ?? 1;
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nómina</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Nómina para <?php echo htmlspecialchars($numEmpleados); ?> empleados</h1>
        <form action="nomina.php" method="POST">
            <?php for ($i = 1; $i <= $numEmpleados; $i++): ?>
                <div class="empleado">
                    <h3>Empleado <?php echo $i; ?></h3>
                    <label for="nombre<?php echo $i; ?>">Nombre del empleado:</label>
                    <input type="text" id="nombre<?php echo $i; ?>" name="nombre[]" required>

                    <label for="salario<?php echo $i; ?>">Salario base:</label>
                    <input type="number" id="salario<?php echo $i; ?>" name="salario[]" required>

                    <label for="diasTrabajados<?php echo $i; ?>">Días trabajados:</label>
                    <input type="number" id="diasTrabajados<?php echo $i; ?>" name="diasTrabajados[]" required>

                    <label for="bono<?php echo $i; ?>">Bono:</label>
                    <input type="number" id="bono<?php echo $i; ?>" name="bono[]" value="0">
                </div>
            <?php endfor; ?>
            <button type="submit">Generar Nómina</button>
        </form>
    </div>
</body>
</html>
