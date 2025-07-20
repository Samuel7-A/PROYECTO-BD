<!DOCTYPE html>

<?php
session_start(); // <--- Siempre al principio

include('../../conexion.php'); // Ajusta esta ruta si tu conexion.php está en otra ubicación
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tarjeta = str_replace(' ', '', $_POST["numero_tarjeta"]);
    $clave = $_POST["clave"];

    $consulta = $conexion->prepare("SELECT * FROM TARJETA WHERE TARJETA_ID = ? AND CLAVETARJETA = ? AND TARJETA_ESTADO != 'bloqueada'");
    $consulta->bind_param("ss", $tarjeta, $clave);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    // Si el login fue exitoso, borrar intentos fallidos de hoy
    $borrarIntentos = $conexion->prepare("DELETE FROM INTENTOSFALLIDOS WHERE TARJETA_ID = ? AND FECHAINTENTO = CURDATE()");
    $borrarIntentos->bind_param("s", $tarjeta);
    $borrarIntentos->execute();
    $borrarIntentos->close();


    $_SESSION['tarjeta_id'] = $usuario['TARJETA_ID'];
    $_SESSION['dniCliente'] = $usuario['C_DNI'];
    $_SESSION['autenticado'] = true; // ✅ importante
    unset($_SESSION['cliente_dni']);
    header("Location: ../apartado/apartado.php");
    exit;
    } else {
        $error = "Número de tarjeta o clave inválidos. Intente de nuevo.";

        // Registrar intento fallido SOLO si existe ese número de tarjeta
        $verificarTarjeta = $conexion->prepare("SELECT TARJETA_ID FROM TARJETA WHERE TARJETA_ID = ?");
        $verificarTarjeta->bind_param("s", $tarjeta);
        $verificarTarjeta->execute();
        $resultadoTarjeta = $verificarTarjeta->get_result();

        if ($resultadoTarjeta->num_rows > 0) {
            // Ejecutar procedimiento almacenado
            $call = $conexion->prepare("CALL RegistrarIntentoFallido(?)");
            $call->bind_param("s", $tarjeta); // asumiendo que TARJETA_ID es INT

            if (!$call->execute()) {
                echo "Error al ejecutar el procedimiento: " . $call->error;
            }else {
                // Obtener resultado del SELECT final del procedimiento
                $resultado = $call->get_result(); // <- esto es clave

                if ($resultado && $fila = $resultado->fetch_assoc()) {
                    echo "Intentos restantes: " . $fila['intentos_restantes'];
                } else {
                    echo "No se pudo obtener el número de intentos restantes.";
                }

                $resultado->free(); // liberar memoria
            }
            $call->close();

            // Verificar si la tarjeta fue bloqueada
            $verificaBloqueo = $conexion->prepare("SELECT TARJETA_ESTADO FROM TARJETA WHERE TARJETA_ID = ?");
            if (!$verificaBloqueo) {
                die("Error en prepare (verificaBloqueo): " . $conexion->error);
            }
            $verificaBloqueo->bind_param("s", $tarjeta);
            $verificaBloqueo->execute();
            $resultadoBloqueo = $verificaBloqueo->get_result();

            if ($resultadoBloqueo->num_rows > 0) {
                $fila = $resultadoBloqueo->fetch_assoc();
                if ($fila['TARJETA_ESTADO'] == 'bloqueada') {
                    $error = "Su tarjeta ha sido bloqueada. Comuníquese con un empleado.";
                }
            }
            $verificaBloqueo->close();
        }
    }
}    
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBVA</title>
    <link rel="stylesheet" href="estilo_index.css">
</head>

<body>
    <main class="principal">
        <div class="lado-izquierdo">
            <img src="../imagenes/BBVA.png" alt="Logo de BBVA" class="logo" width="180" height="180">
            <p>Bienvenido a la interfaz de autenticación del Banco BBVA. Por favor, ingresa tus credenciales para
                acceder a tu cuenta.</p>
        </div>
        <div class="lado-derecho">
            <h2>Iniciar Sesión</h2>
            <form class="formulario" action="" method="post">
                <div class="campo">
                    <label class="custom-label" for="numero-tarjeta">Número de tarjeta</label>
                    <input type="text" id="numero-tarjeta" name="numero_tarjeta" maxlength="19" autocomplete="off">
                </div>
                <br>
                <div class="campo">
                    <label class="custom-label" for="clave">Clave de acceso</label>
                    <input type="password" id="clave" name="clave" maxlength="4" inputmode="numeric" pattern="\d{4}" required
                        oninput="this.value = this.value.replace(/\D/g, '')">
                </div>
                <button type="submit">Ingresar</button>
            </form>

            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <button class="btn-empleado" onclick="location.href='../empleado/empleado_login.php'">Ingresar como
                Empleado</button>
        </div>
    </main>
    <script src="codigo_index.js"></script>
</body>

</html>