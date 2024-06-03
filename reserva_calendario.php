<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    echo "Acceso denegado.";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $claseId = $_POST['claseId'];

    // Obtener la información de la clase
    $stmt_clase = $pdo->prepare("SELECT * FROM clases WHERE ClaseID = :claseId");
    $stmt_clase->execute(['claseId' => $claseId]);
    $clase = $stmt_clase->fetch(PDO::FETCH_ASSOC);

    // Verificar si la clase tiene plazas disponibles
    if ($clase['PlazasReservadas'] < $clase['CupoMaximo']) {
        // Actualizar las plazas reservadas
        $stmt_update = $pdo->prepare("UPDATE clases SET PlazasReservadas = PlazasReservadas + 1 WHERE ClaseID = :claseId");
        $stmt_update->execute(['claseId' => $claseId]);

        // Actualizar los días reservados del usuario
        $stmt_reserva = $pdo->prepare("SELECT DiasReservados FROM reservas WHERE UsuarioID = :user_id");
        $stmt_reserva->execute(['user_id' => $user_id]);
        $reserva_usuario = $stmt_reserva->fetch(PDO::FETCH_ASSOC);

        $dias_reservados = json_decode($reserva_usuario['DiasReservados'], true);
        $dias_reservados[] = $date;

        $stmt_update_reserva = $pdo->prepare("UPDATE reservas SET DiasReservados = :diasReservados WHERE UsuarioID = :user_id");
        $stmt_update_reserva->execute(['diasReservados' => json_encode($dias_reservados), 'user_id' => $user_id]);

        echo "Reserva realizada con éxito.";
    } else {
        echo "No hay plazas disponibles.";
    }
} else {
    echo "Solicitud no válida.";
}
?>
