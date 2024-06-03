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
       :root {
            --black: #000000;
            --white: #ffffff;
            --green: #66BB6A;
            --dark-green: #525f48;
            --light-green: #A8BBA2;
            --beige: #b79e94;
        }


        .container-reservas {
            max-width: 800px;
            margin: 50px auto;
            margin-top: 140px;
            padding: 20px;
            border-radius: 10px;
            background-color: var(--white);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .container-reservas h2 {
            color: var(--dark-green);
            margin-bottom: 20px;
            text-align: center;
            font-size: 2em;
        }

        .reserva {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
            padding: 15px;
            background-color: var(--light-green);
            border-radius: 5px;
        }

        .reserva:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .reserva h4 {
            color: var(--dark-green);
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .reserva p {
            margin: 5px 0;
        }

        .btn__hero {
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid var(--green);
            color: var(--white);
            font-size: 1.2rem;
            background-color: var(--green);
            font-weight: bold;
            cursor: pointer;
            transition: all .3s;
            position: relative;
            overflow: hidden;
            z-index: 1;
            margin-top: 20px;
            text-align: center;
            border-radius: 5px;
        }

        .btn__hero:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-green);
            z-index: -2;
            transition: all .3s;
        }

        .btn__hero:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background-color: var(--white);
            transition: all .3s;
            z-index: -1;
        }

        .btn__hero:hover {
            color: var(--dark-green);
        }

        .btn__hero:hover:before {
            width: 100%;
        }

        @media (max-width: 768px) {
            .container-reservas {
                margin: 30px 15px;
                padding: 15px;
            }

            .container-reservas h2 {
                font-size: 1.5em;
            }

            .reserva h4 {
                font-size: 1.2em;
            }

            .btn__hero {
                font-size: 1rem;
                padding: 8px 16px;
            }
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
