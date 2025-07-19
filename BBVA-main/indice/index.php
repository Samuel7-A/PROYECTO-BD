<!DOCTYPE html>

<?php
include('../../conexion.php'); // Ajusta esta ruta si tu conexion.php está en otra ubicación
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tarjeta = str_replace(' ', '', $_POST["numero_tarjeta"]);
    $clave = $_POST["clave"];

    $consulta = $conexion->prepare("SELECT * FROM TARJETA WHERE TARJETA_ID = ? AND CLAVETARJETA = ?");
    $consulta->bind_param("ss", $tarjeta, $clave);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: ../apartado/apartado.html");
        exit;
    } else {
        $error = "Número de tarjeta o clave inválidos. Intente de nuevo.";
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