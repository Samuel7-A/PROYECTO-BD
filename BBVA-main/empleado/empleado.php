
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBVA</title>
    <link rel="stylesheet" href="estilo_empleado.css">
</head>
<body>
    <header>
        <h1>Portal del Empleado BBVA</h1>        
    </header>
    <main>
        <h2>Registros de eventos de clientes</h2>
        <input type="number" id="clienteIdInput" placeholder="Ingrese DNI del cliente">
        <button onclick="buscarEventos()">Buscar</button>

        <table id="tabla-registros">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI</th>
                    <th>Fecha</th>
                    <th>Tipo Evento</th>
                    <th>Monto Antiguo</th>
                    <th>Monto Nuevo</th>
                    <th>Estado Antiguo</th>
                    <th>Estado Nuevo</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </main>
    <button class="btn-salir" onclick="location.href='../indice/index.php'">Salir</button>

    <script src="eventos.js"></script>

</body>
</html>