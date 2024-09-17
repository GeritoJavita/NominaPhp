<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Nómina</title>
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
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Formulario de Nómina</h1>
        <form action="guardar_empleados.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Centro de Costo</th>
                        <th>Cargo</th>
                        <th>No Identificación</th>
                        <th>Sueldo</th>
                        <th>Días Laborados</th>
                    </tr>
                </thead>
                <tbody id="empleados">
                    <tr>
                        <td><input type="text" name="nombre[]" required></td>
                        <td><input type="text" name="centro_costo[]" required></td>
                        <td><input type="text" name="cargo[]" required></td>
                        <td><input type="text" name="no_identificacion[]" required></td>
                        <td><input type="number" name="sueldo[]" required></td>
                        <td><input type="number" name="dias_laborados[]" required></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" onclick="agregarEmpleado()">Agregar Empleado</button>
            <input type="submit" class="button" value="Guardar y Ver Nómina">
        </form>
    </div>

    <script>
        function agregarEmpleado() {
            const tabla = document.getElementById('empleados');
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td><input type="text" name="nombre[]" required></td>
                <td><input type="text" name="centro_costo[]" required></td>
                <td><input type="text" name="cargo[]" required></td>
                <td><input type="text" name="no_identificacion[]" required></td>
                <td><input type="number" name="sueldo[]" required></td>
                <td><input type="number" name="dias_laborados[]" required></td>
            `;
            tabla.appendChild(fila);
        }
    </script>
</body>
</html>
