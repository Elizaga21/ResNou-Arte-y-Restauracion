<?php
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit();
}


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtén la clase desde la URL
$clase = isset($_GET['clase']) ? $_GET['clase'] : '';

// Obtener la información de la clase desde la base de datos
$sql = "SELECT * FROM clases WHERE Nombre = '$clase'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $clase_id = $row['ClaseID'];
    $cupo_maximo = $row['CupoMaximo'];
    $plazas_reservadas = $row['PlazasReservadas'];
} else {
    echo 'Clase no válida.';
    exit();
}


// Días inactivos: lunes (1), martes (2), miércoles (3), y domingos (0)
$inactive_days_of_week = [0, 1, 2, 3];

// Obtener días reservados por el usuario
$sql_reservas_usuario = "SELECT Fecha FROM reservas WHERE UsuarioID = $usuario_id AND ClaseID = $clase_id";
$reservas_usuario = $conn->query($sql_reservas_usuario);

$reserved_days = [];
if ($reservas_usuario->num_rows > 0) {
    while ($row = $reservas_usuario->fetch_assoc()) {
        $reserved_days[] = $row['Fecha'];
    }
}

// Obtener días con aforo completo
$sql_full_days = "SELECT Fecha, COUNT(*) as num_reservas FROM reservas WHERE ClaseID = $clase_id GROUP BY Fecha HAVING num_reservas >= $cupo_maximo";
$full_days_result = $conn->query($sql_full_days);

$full_days = [];
if ($full_days_result->num_rows > 0) {
    while ($row = $full_days_result->fetch_assoc()) {
        $full_days[] = $row['Fecha'];
    }
}

// Convertimos las fechas a un formato JSON para usarlas en JavaScript
$reserved_days_json = json_encode($reserved_days);
$full_days_json = json_encode($full_days);
$inactive_days_of_week_json = json_encode($inactive_days_of_week);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Bonos</title>
    <link rel="stylesheet" href="assets/css/calendar.css">
    <style>
        .calendar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            max-width: 500px;
            margin: 20px;
        }
        .calendar .day {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .calendar .inactive {
            background-color: #ddd;
            cursor: not-allowed;
        }
        .calendar .reserved {
            background-color: orange;
        }
        .calendar .full {
            background-color: red;
            cursor: not-allowed;
        }
        .calendar .active {
            background-color: green;
        }
        .calendar .selected {
            border: 2px solid blue;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="calendar-container">
    <h1>Reserva tu Bono para <?php echo ucfirst(str_replace('_', ' ', $clase)); ?></h1>
    <div id="calendar" class="calendar"></div>
    <form id="reserveForm" method="POST" action="reserva.php">
        <input type="hidden" name="selectedDay" id="selectedDayInput">
        <input type="hidden" name="clase" value="<?php echo $clase; ?>">
        <button type="submit" id="reserveButton" disabled>Reservar</button>
    </form>
</div>
<?php include 'footer.php'; ?>

<script>
    const reservedDays = <?php echo $reserved_days_json; ?>;
    const fullDays = <?php echo $full_days_json; ?>;
    const inactiveDaysOfWeek = <?php echo $inactive_days_of_week_json; ?>;
    const calendar = document.getElementById('calendar');
    const reserveButton = document.getElementById('reserveButton');
    let selectedDay = null;

    function generateCalendar() {
        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 1; i <= daysInMonth; i++) {
            const date = new Date(year, month, i);
            const day = date.toISOString().split('T')[0];
            const dayOfWeek = date.getDay();
            const dayElement = document.createElement('div');
            dayElement.className = 'day';
            dayElement.textContent = i;

            if (inactiveDaysOfWeek.includes(dayOfWeek)) {
                dayElement.classList.add('inactive');
            } else if (reservedDays.includes(day)) {
                dayElement.classList.add('reserved');
            } else if (fullDays.includes(day)) {
                dayElement.classList.add('full');
            } else {
                dayElement.classList.add('active');
                dayElement.addEventListener('click', () => selectDay(dayElement, day));
            }

            calendar.appendChild(dayElement);
        }
    }

    function selectDay(element, day) {
        if (selectedDay) {
            selectedDay.classList.remove('selected');
        }
        element.classList.add('selected');
        selectedDay = element;
        reserveButton.disabled = false;
        reserveButton.onclick = () => reserveDay(day);
    }

    function reserveDay(day) {
        document.getElementById('selectedDayInput').value = day;
        document.getElementById('reserveForm').submit();
    }

    generateCalendar();
</script>

</body>
</html>
