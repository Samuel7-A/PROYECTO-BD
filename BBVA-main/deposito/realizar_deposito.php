
<?php
include '../../conexion.php'; // tu archivo de conexión

session_start();

if (!isset($_SESSION['dniCliente'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$dni = $_SESSION['dniCliente'];

// Leer los datos JSON enviados por JavaScript
$input = json_decode(file_get_contents("php://input"), true);
$monto = $input["monto"];
$moneda = $input["moneda"];

$response = [];

if (!$dni || !$monto || !$moneda) {
    $response["exito"] = false;
    $response["error"] = "Faltan datos";
    echo json_encode($response);
    exit;
}

$conexion->begin_transaction();

try {
    // 1. Verificar si existe una cuenta con ese DNI y moneda
    $stmt = $conexion->prepare("SELECT MONTO FROM CUENTAS WHERE C_DNI = ? AND MONEDATIPO = ?");
    $stmt->bind_param("ss", $dni, $moneda);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        throw new Exception("Cuenta no encontrada para el cliente y moneda seleccionada.");
    }

    // 2. Insertar en transacciones (esto activará el trigger que actualiza CUENTAS y CUENTAEVENTO)
    $fecha = date("Y-m-d");
    $tipo = "deposito";

    $stmt = $conexion->prepare("INSERT INTO TRANSACCIONES (TRANSACCION_TIPO, TRANSACCION_FECHA, C_DNI, TRANSACCION_MONTO) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $tipo, $fecha, $dni, $monto);
    $stmt->execute();

    // 3. Commit si todo fue bien
    $conexion->commit();
    $response["exito"] = true;

} catch (Exception $e) {
    $conexion->rollback();
    $response["exito"] = false;
    $response["error"] = $e->getMessage();
}

echo json_encode($response);
