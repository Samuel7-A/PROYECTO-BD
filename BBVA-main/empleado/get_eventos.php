
<?php
include '../../conexion.php';
header('Content-Type: application/json');

if (isset($_GET['clienteId'])) {
    $clienteId = $_GET['clienteId'];

    $stmt = $conexion->prepare("CALL ObtenerEventosCliente(?)");
    $stmt->bind_param("i", $clienteId);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $eventos = [];

    while ($fila = $resultado->fetch_assoc()) {
        $eventos[] = $fila;
    }

    echo json_encode($eventos);
    $stmt->close();
    $conexion->close();
}
?>

