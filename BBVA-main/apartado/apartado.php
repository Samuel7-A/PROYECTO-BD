<!DOCTYPE html>

<?php
session_start();

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: ../cliente/index.php");
    exit;
}

include('../../conexion.php');

$tarjeta_id = $_SESSION['tarjeta_id'];
$dni_cliente = $_SESSION['dniCliente']; // ✅ debe coincidir con el nombre del index

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// Consulta para obtener información de la cuenta
$query = "
    SELECT 
        C.C_NOMBRE, 
        C.C_APELLIDO, 
        CU.TIPOCUENTA, 
        CU.MONTO, 
        T.TARJETA_ID
    FROM CUENTAS CU
    JOIN CLIENTES C ON C.C_DNI = CU.C_DNI
    JOIN TARJETA T ON T.C_DNI = CU.C_DNI
    WHERE CU.C_DNI = ?
";

$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $dni_cliente);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $nombre = $fila['C_NOMBRE'] . ' ' . $fila['C_APELLIDO'];
    $tipo = $fila['TIPOCUENTA'];
    $numero = $fila['TARJETA_ID'];
    $saldo = $fila['MONTO'];
} else {
    // Si no hay datos, puedes redirigir o mostrar un mensaje de error
    $nombre = "No encontrado";
    $tipo = "N/A";
    $numero = "N/A";
    $saldo = "0.00";
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBVA</title>
    <link rel="stylesheet" href="estilo_apartado.css">
</head>

<body>
    <h1>Bienvenido a BBVA</h1>
    <main class="contenedor-apartado">
        <div class="caja-apartado">
            <div class="info-cuenta">
                <h2>Información de tu cuenta</h2>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
                <p><strong>Tipo de cuenta:</strong> <?= htmlspecialchars($tipo) ?></p>
                <p><strong>Número de tarjeta:</strong> <?= htmlspecialchars($numero) ?></p>
                <p><strong>Monto total:</strong> <?= htmlspecialchars($saldo) ?></p>
            </div>
        </div>
        <div class="opciones-acciones">
            <!-- Botón Depositar con dropdown -->
            <div class="opcion-tarjeta dropdown" id="depositoDropdown">
                <div class="icono-opcion">
                    <svg width="24" height="24" fill="#296CFF" viewBox="0 0 24 24">
                        <rect x="3" y="7" width="18" height="10" rx="2" fill="#fff" stroke="#296CFF" stroke-width="2" />
                        <rect x="7" y="3" width="10" height="4" rx="1" fill="#fff" stroke="#296CFF" stroke-width="2" />
                    </svg>
                </div>
                <div class="texto-opcion">
                    <span class="titulo-opcion"><strong>Depositar</strong></span>
                </div>
                <div class="flecha-opcion">
                    <svg width="18" height="18" fill="#6c7a89" viewBox="0 0 24 24">
                        <path d="M9 6l6 6-6 6" />
                    </svg>
                </div>
                <div class="dropdown-content">
                    <a href="../deposito/deposito.php">Cuenta propia</a>
                </div>
            </div>
            <!-- Botón Ir a la página de inicio -->
            <div class="opcion-tarjeta" onclick="window.location.href='../indice/index.php'">
                <div class="texto-opcion">
                    <span class="titulo-opcion"><strong>Salir</strong></span>
                </div>
            </div>
        </div>
    </main>
    <script>
        const dropdown = document.getElementById('depositoDropdown');
        dropdown.addEventListener('click', function (e) {
            // Solo abre/cierra si no se hizo click en el enlace
            if (!e.target.closest('.dropdown-content a')) {
                e.stopPropagation();
                dropdown.classList.toggle('open');
            }
        });
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    </script>
</body>

</html>