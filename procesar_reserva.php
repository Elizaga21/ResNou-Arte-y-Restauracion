<?php
session_start();
include 'db_connection.php';
// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

// Obtener datos del formulario
$usuarioID = $_SESSION['usuario_id'];
$clase = $_POST['clase'];
$bono = $_POST['bono'];
$precio = $_POST['precio'];
$fechaCompra = date('Y-m-d H:i:s');

// Insertar en la tabla compras
$sql = "INSERT INTO compras (UsuarioID, ClaseID, FechaCompra, PrecioTotal, FormaPago) VALUES (?, ?, ?, ?, 'Tarjeta de Crédito')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisd", $usuarioID, $clase, $fechaCompra, $precio);

if ($stmt->execute()) {
    echo "Reserva realizada con éxito.";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
