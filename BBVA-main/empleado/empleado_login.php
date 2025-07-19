<!DOCTYPE html>

<?php
include('../../conexion.php'); // Ajusta esta ruta si tu conexion.php está en otra ubicación
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"]; // NO quites espacios internos
    $clave = $_POST["clave"];

    $consulta = $conexion->prepare("CALL ValidarEmpleadoPorID(?, ?)");
    $consulta->bind_param("ss", $usuario, $clave);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: ../empleado/empleado.php");
        exit;
    } else {
        $error = "Usuario o clave inválidos. Intente de nuevo.";
    }
}
?>


<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBVA</title>
    <link rel="stylesheet" href="estilo_empleado_login.css">
</head>

<body>
    <main class="principal">        
        <div class="contenedor">
            <h2>Iniciar Sesión</h2>
            <form class="formulario" action="" method="post">
                <div class="campo">
                    <label class="custom-label" for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <br>
                <div class="campo">
                    <label class="custom-label" for="clave">Clave de acceso</label>
                    <input type="password" id="clave" name="clave" maxlength="4" inputmode="numeric" pattern="\d{4}" required>
                </div>
                <button type="submit">Ingresar</button>
            </form>

            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

        </div>
    </main>
</body>

</html>
