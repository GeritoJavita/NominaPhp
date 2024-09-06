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
        <h1>Nómina de empleados</h1>
        <form action="nomina.php" method="POST">
            <label for="nombre">Nombre del empleado:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="salario">Salario base:</label>
            <input type="number" id="salario" name="salario" required>

            <label for="diasTrabajados">Días trabajados:</label>
            <input type="number" id="diasTrabajados" name="diasTrabajados" required>

            <label for="bono">Bono:</label>
            <input type="number" id="bono" name="bono" value="0">

            <button type="submit">Generar Nómina</button>
        </form>
    </div>
</body>
</html>
