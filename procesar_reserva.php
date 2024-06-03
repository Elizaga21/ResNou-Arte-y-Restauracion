<?php
session_start();
require 'db_connection.php';

// Verificar si el usuario está autenticado y tiene el rol de cliente
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    echo "Acceso denegado.";
    exit();
}

// Obtener el ID del usuario de la sesión
$user_id = $_SESSION['user_id'];

// Obtener la fecha de la reserva
$date = $_GET['date'] ?? null;

if (!$date) {
    echo "Fecha no válida.";
    exit();
}

// Verificar que el usuario no excede su bono
$stmt_bono = $pdo->prepare("SELECT COUNT(*) as TotalReservas, u.PrecioBono6, u.PrecioBono10 
                            FROM reservas r 
                            JOIN usuarios u ON r.UsuarioID = u.id 
                            WHERE r.UsuarioID = ? AND r.activo = true");
$stmt_bono->execute([$user_id]);
$bono = $stmt_bono->fetch(PDO::FETCH_ASSOC);

if ($bono) {
    $total_reservas = $bono['TotalReservas'] ?? 0;
    $max_reservas = max($bono['PrecioBono6'], $bono['PrecioBono10']);
    if ($total_reservas >= $max_reservas) {
        echo "Has alcanzado el máximo de reservas permitidas según tu bono.";
        exit();
    }
}

// Procesar la reserva
$stmt_clase = $pdo->prepare("SELECT ClaseID FROM clases WHERE Dia = DAYNAME(?) AND CupoMaximo > PlazasReservadas LIMIT 1");
$stmt_clase->execute([$date]);
$clase = $stmt_clase->fetch(PDO::FETCH_ASSOC);

if (!$clase) {
    echo "No hay clases disponibles para este día.";
    exit();
}

// Actualizar el campo DiasReservados en la tabla reservas
if ($stmt_reserva->execute([$user_id, $clase['ClaseID'], $date, $dias_reservados])) {
    $reserva_id = $pdo->lastInsertId();
    $stmt_update_dias_reservados = $pdo->prepare("UPDATE reservas SET DiasReservados = JSON_INSERT(DiasReservados, '$.dates', CAST(? AS JSON)) WHERE ReservaID = ?");
    $stmt_update_dias_reservados->execute([$date, $reserva_id]);
    echo "Reserva realizada con éxito.";
} else {
    echo "Error al realizar la reserva.";
}

// Actualizar las plazas reservadas de la clase
$stmt_update_clase = $pdo->prepare("UPDATE clases SET PlazasReservadas = PlazasReservadas + 1 WHERE ClaseID = ?");
$stmt_update_clase->execute([$clase['ClaseID']]);
?>
