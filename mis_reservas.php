<?php
session_start();
require 'db_connection.php';

// Verificar si el usuario está autenticado y tiene el rol de cliente
if (isset($_SESSION['user_id']) && $_SESSION['rol'] === 'cliente') {
    // Obtener el ID del usuario de la sesión
    $user_id = $_SESSION['user_id'];

    // Consultar la base de datos para obtener las reservas del usuario

    $stmt_reservas = $pdo->prepare("SELECT r.*, c.Nombre AS ClaseNombre, c.Descripcion AS ClaseDescripcion, c.Dia, c.Hora, 
                                            CASE WHEN c.PrecioBono6 IS NOT NULL THEN c.PrecioBono6 ELSE c.PrecioBono10 END AS PrecioBono
                                    FROM reservas r 
                                    JOIN clases c ON r.ClaseID = c.ClaseID 
                                    WHERE r.UsuarioID = ? AND r.activo = true
                                    ORDER BY r.Fecha DESC");
    $stmt_reservas->execute([$user_id]);
    $reservas = $stmt_reservas->fetchAll();
} else {
    echo "Acceso denegado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-reservas {
            max-width: 800px;
            margin: 50px auto;
            margin-top: 140px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .container-reservas h2 {
            color: var(--fern);
            margin-bottom: 20px;
            text-align: center;
        }

        .reserva {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .reserva:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .reserva h4 {
            color: var(--fern);
        }

        .reserva p {
            margin: 0;
        }

        .btn__hero {
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid #66BB6A;
            color: #ffffff;
            font-size: 1.8rem;
            box-shadow: 1px 10px 30px -10px #66bb6a;
            background-color: #66BB6A;
            font-weight: bold;
            cursor: pointer;
            transition: all .3s;
            position: relative;
            overflow: hidden;
            z-index: 1;
            margin-top: 20px;
            text-align: center;
        }

        .btn__hero:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #525f48;
            z-index: -2;
        }

        .btn__hero:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background-color: #ffffff;
            transition: all .3s;
            z-index: -1;
        }

        .btn__hero:hover {
            color: #525f48;
        }

        .btn__hero:hover:before {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-reservas">
        <h2>Mis Reservas</h2>
        <?php if (count($reservas) > 0): ?>
            <?php foreach ($reservas as $reserva): ?>
                <div class="reserva">
                    <h4><?php echo htmlspecialchars($reserva['ClaseNombre']); ?></h4>
                    <p><strong>Fecha de la reserva:</strong> <?php echo htmlspecialchars($reserva['Fecha']); ?></p>
                    <p><strong>Dirección:</strong> <?php echo htmlspecialchars($reserva['Direccion']); ?></p>
                    <p><strong>Localidad:</strong> <?php echo htmlspecialchars($reserva['Localidad']); ?></p>
                    <p><strong>Provincia:</strong> <?php echo htmlspecialchars($reserva['Provincia']); ?></p>
                    <p><strong>País:</strong> <?php echo htmlspecialchars($reserva['Pais']); ?></p>
                    <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($reserva['CodPos']); ?></p>
                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($reserva['ClaseDescripcion']); ?></p>
                    <p><strong>Dia de la clase:</strong> <?php echo htmlspecialchars($reserva['Dia']); ?></p>
                    <p><strong>Hora de la clase:</strong> <?php echo htmlspecialchars($reserva['Hora']); ?></p>
                    <p><strong>Precio del bono:</strong> <?php echo htmlspecialchars($reserva['PrecioBono']); ?></p>
                    <p><strong>Forma de Pago:</strong> <?php echo htmlspecialchars($reserva['FormaPago']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes reservas realizadas.</p>
        <?php endif; ?>
        <a href="index.php" class="btn__hero">Volver al Inicio</a>
        <a href="calendario_reserva.php" class="btn__hero">Reservar Día</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
