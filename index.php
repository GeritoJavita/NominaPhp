<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Nómina</title>
    <link rel="stylesheet" href="styles.css">
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
                        <th>Fecha</th>
                        <th>Horas Nocturas</th>
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
                        <td><input type="text" name="fecha_desembolso[]" require></td>
                        <td><input type="number" name="horas_nocturnas[]" require></td>
                        
                        
                        
                        
                    
                    </tr>
                </tbody>
            </table>
            <button type="button" class="add-button" onclick="agregarEmpleado()">Agregar Empleado</button>
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

       
                        <td><input type="text" name="fecha_desembolso[]" require></td>
        
                        <td><input type="number" name="horas_nocturnas[]" require></td>
            `;
            tabla.appendChild(fila);
        }
    </script>
</body>
</html>
