<!DOCTYPE html>
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
                    <input type="text" id="numero-tarjeta" name="numero-tarjeta" maxlength="19" autocomplete="off">
                </div>
                <br>
                <div class="campo">
                    <label class="custom-label" for="clave">Clave de acceso</label>
                    <input type="password" id="clave" name="clave" maxlength="4" inputmode="numeric" pattern="\d{4}"
                        required oninput="this.value = this.value.replace(/\D/g, '')">
                </div>
                <button type="button" onclick="location.href='../apartado/apartado.html'">Ingresar</button>
            </form>
            <button class="btn-empleado" onclick="location.href='../empleado/empleado_login.html'">Ingresar como
                Empleado</button>
        </div>
    </main>
    <script src="codigo_index.js"></script>
</body>

</html>