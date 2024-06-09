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
$date = $_POST['date'] ?? null;
$class_id = $_POST['class_id'] ?? null;

if (!$date || !$class_id) {
    echo "Fecha o Clase no válida.";
    exit();
}

// Verificar que el usuario no excede su bono
$stmt_bono = $pdo->prepare("SELECT COUNT(*) as TotalReservas, PrecioBonoSeleccionado 
                            FROM reservas 
                            WHERE UsuarioID = ? AND activo = 1");
$stmt_bono->execute([$user_id]);
$bono = $stmt_bono->fetch(PDO::FETCH_ASSOC);

$total_reservas = $bono['TotalReservas'] ?? 0;
$max_reservas = $bono['PrecioBonoSeleccionado'];

if ($total_reservas >= $max_reservas) {
    echo "Has alcanzado el máximo de reservas permitidas según tu bono.";
    exit();
}

// Procesar la reserva
$stmt_clase = $pdo->prepare("SELECT ClaseID, PlazasReservadas, CupoMaximo 
                            FROM clases 
                            WHERE ClaseID = ? AND CupoMaximo > PlazasReservadas");
$stmt_clase->execute([$class_id]);
$clase = $stmt_clase->fetch(PDO::FETCH_ASSOC);

if (!$clase) {
    echo "No hay plazas disponibles para esta clase.";
    exit();
}

// Actualizar el campo DiasReservados en la tabla reservas
$stmt_reserva = $pdo->prepare("SELECT ReservaID, DiasReservados FROM reservas WHERE UsuarioID = :user_id");
$stmt_reserva->execute(['user_id' => $user_id]);
$reserva = $stmt_reserva->fetch(PDO::FETCH_ASSOC);

$new_dias_reservados = [];
if ($reserva) {
    $existing_dias_reservados = json_decode($reserva['DiasReservados'], true);
    $new_dias_reservados = array_merge($existing_dias_reservados, [$date]);
    $stmt_update_dias_reservados = $pdo->prepare("UPDATE reservas SET DiasReservados = :dias_reservados WHERE ReservaID = :reserva_id");
    $stmt_update_dias_reservados->execute(['dias_reservados' => json_encode($new_dias_reservados), 'reserva_id' => $reserva['ReservaID']]);
} else {
    $stmt_new_reserva = $pdo->prepare("INSERT INTO reservas (UsuarioID, ClaseID, Fecha, EstadoReserva, DiasReservados, Direccion, Localidad, Provincia, Pais, CodPos, FormaPago, CompraID, activo) VALUES (:user_id, :class_id, :fecha, 'pendiente', :dias_reservados, '', '', '', '', '', '', '', 1)");
    $stmt_new_reserva->execute(['user_id' => $user_id, 'class_id' => $class_id, 'fecha' => $date, 'dias_reservados' => json_encode([$date])]);
}

// Actualizar plazas reservadas en la tabla clases
$stmt_update_class = $pdo->prepare("UPDATE clases SET PlazasReservadas = PlazasReservadas + 1 WHERE ClaseID = ?");
$stmt_update_class->execute([$class_id]);

echo "Reserva realizada con éxito.";
?>
