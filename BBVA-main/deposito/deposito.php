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


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Depósito BBVA</title>
    <link rel="stylesheet" href="estilo_deposito.css">
</head>

<body>
    <div class="bbva-logo">BBVA</div>
    <main class="deposito-main">
        <div class="titulos">
            <h2>Ingresa el monto a depositar</h2>
            <p class="subtitulo">Usa el teclado para digitar los números</p>
        </div>

        <div class="deposito-contenedor">
            <section class="deposito-formulario">
                <label for="monto">Ingresa la cantidad del monto</label>
                <input type="text" id="monto" maxlength="10" autocomplete="off"
                    oninput="this.value = this.value.replace(/\D/g, '')">
                <div class="moneda-selector">
                    <button class="boton-moneda activo">Soles</button>
                    <button class="boton-moneda">Dólares</button>
                </div>
                <button id="continuar" class="continuar-boton" type="button">Continuar</button>
                <p id="mensaje" style="color: green; display: none;">Procesando tu depósito...</p>



            </section>
        </div>
    </main>

    <div class="regresar-menuprincipal">
        <button class="button-regresar-menu" onclick="location.href='../apartado/apartado.php'">Menu principal</button>
        <p>Depositar, pagar y retirar</p>
    </div>
    <script src="../deposito/scriptdeposito.js"></script>
</body>

</html>