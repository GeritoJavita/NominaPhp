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
        <h1>Nómina Dinámica</h1>
        <form action="formulario_nomina.php" method="POST">
            <label for="numEmpleados">Ingrese la cantidad de empleados:</label>
            <input type="number" id="numEmpleados" name="numEmpleados" min="1" required>
            <button type="submit">Generar Formulario</button>
        </form>
    </div>
</body>
</html>
