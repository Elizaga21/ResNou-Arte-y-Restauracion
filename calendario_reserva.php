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

// Consultar la base de datos para obtener las clases disponibles
$sql = "SELECT * FROM clases WHERE Dia IN ('Jueves', 'Viernes', 'Sábado')";
$stmt_classes = $pdo->query($sql);
$classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

// Generar el arreglo de eventos para FullCalendar
$events = [];

foreach ($classes as $class) {
    $day_of_week = $class['Dia'];
    $start_time = $class['Hora'];
    $duration_minutes = $class['DuracionMinutos'];

    // Calcular la próxima fecha específica de la semana
    $next_date = date('Y-m-d', strtotime("next $day_of_week"));

    // Calcular la hora de inicio y fin
    $start_datetime = "$next_date $start_time";
    $end_datetime = date('Y-m-d H:i:s', strtotime("$start_datetime + $duration_minutes minutes"));

    // Añadir el evento al arreglo
    $events[] = [
        'id' => $class['ClaseID'],
        'title' => $class['Nombre'],
        'start' => $start_datetime,
        'end' => $end_datetime,
        'description' => $class['Descripcion'],
        'precio' => $class['Precio'],
        'cupomaximo' => $class['CupoMaximo'],
        'plazasreservadas' => $class['PlazasReservadas'],
        'categoria' => $class['Categoria'],
        'materiales' => $class['Materiales']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Reservas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-calendario {
            margin-top: 100px;
            margin-bottom: 80px;
            margin-left: 25px;
            text-align: center;
            margin-right: 25px;
        }
        #calendar {
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }
        #reserve-form {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-calendario">
        <h2>Selecciona un Día para Reservar</h2>
        <div id="calendar"></div>
        <div id="reserve-form" class="card">
            <div class="card-body">
                <h5 class="card-title">Reservar Clase</h5>
                <form id="reservation-form">
                    <div class="form-group">
                        <label for="class-name">Clase</label>
                        <input type="text" class="form-control" id="class-name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="class-description">Descripción</label>
                        <textarea class="form-control" id="class-description" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="class-price">Precio</label>
                        <input type="text" class="form-control" id="class-price" readonly>
                    </div>
                    <div class="form-group">
                        <label for="class-materials">Materiales</label>
                        <textarea class="form-control" id="class-materials" readonly></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Reservar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                editable: false,
                eventLimit: true,
                events: <?php echo json_encode($events); ?>,
                eventClick: function(event) {
                    $('#reserve-form').show();
                    $('#class-name').val(event.title);
                    $('#class-description').val(event.description);
                    $('#class-price').val(event.precio);
                    $('#class-materials').val(event.materiales);
                    $('#reserve-form').data('class', event);
                }
            });

            $('#reservation-form').submit(function(e) {
                e.preventDefault();
                var event = $('#reserve-form').data('class');
                var formData = {
                    date: moment(event.start).format('YYYY-MM-DD'),
                    class_id: event.id
                };
                $.ajax({
                    url: 'procesar_reserva.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $('#reserve-form').hide();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
