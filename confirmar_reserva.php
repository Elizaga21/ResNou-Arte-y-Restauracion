<?php
session_start();
require 'db_connection.php';

// Verificar si el usuario está autenticado y tiene el rol de cliente
if (isset($_SESSION['user_id']) && $_SESSION['rol'] === 'cliente') {
    // Obtener el ID del usuario de la sesión
    $user_id = $_SESSION['user_id'];

    // Consultar la base de datos para obtener los datos del usuario
    $stmt_usuario = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt_usuario->execute([$user_id]);
    $usuario = $stmt_usuario->fetch();

    // Consultar la última reserva del usuario para mostrar los detalles
    $stmt_reserva = $pdo->prepare("SELECT r.*, c.Nombre AS ClaseNombre, c.Descripcion AS ClaseDescripcion 
                                   FROM reservas r 
                                   JOIN clases c ON r.ClaseID = c.ClaseID 
                                   WHERE r.UsuarioID = ? ORDER BY r.ReservaID DESC LIMIT 1");
    $stmt_reserva->execute([$user_id]);
    $reserva = $stmt_reserva->fetch();

    if (!$reserva) {
        echo "No se encontró la reserva.";
        exit();
    }
}   if ($reserva['FormaPago'] === 'Tarjeta de Crédito') {
    header("Location: pasarela.php");
    exit();
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
    <title>Confirmación de Reserva</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-confirmacion {
            max-width: 600px;
            margin: 50px auto;
            margin-top: 140px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .container-confirmacion h2 {
            color: var(--fern);
            margin-bottom: 20px;
        }

        .container-confirmacion p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .container-confirmacion .btn__hero {
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
        }

        .container-confirmacion .btn__hero:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #525f48;
            z-index: -2;
        }

        .container-confirmacion .btn__hero:before {
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

        .container-confirmacion .btn__hero:hover {
            color: #525f48;
        }

        .container-confirmacion .btn__hero:hover:before {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-confirmacion">
        <h2>Reserva Confirmada</h2>
        <p>¡Gracias por tu reserva, <?php echo htmlspecialchars($usuario['nombre']); ?>!</p>
        <p>Detalles de la reserva:</p>
        <p><strong>Clase:</strong> <?php echo htmlspecialchars($reserva['ClaseNombre']); ?></p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($reserva['ClaseDescripcion']); ?></p>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($reserva['Fecha']); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($reserva['Direccion']); ?></p>
        <p><strong>Localidad:</strong> <?php echo htmlspecialchars($reserva['Localidad']); ?></p>
        <p><strong>Provincia:</strong> <?php echo htmlspecialchars($reserva['Provincia']); ?></p>
        <p><strong>País:</strong> <?php echo htmlspecialchars($reserva['Pais']); ?></p>
        <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($reserva['CodPos']); ?></p>
        <p><strong>Forma de Pago:</strong> <?php echo htmlspecialchars($reserva['FormaPago']); ?></p>
          <!-- Botón de Pago Bizum si la forma de pago es Bizum -->
          <?php if ($reserva['FormaPago'] === 'Bizum'): ?>
            <a href="confirmar_pago_bizum.php" class="btn__hero">Pago Bizum</a>
            <p>Si tienes alguna pregunta o necesitas ayuda con el pago, puedes contactar directamente con Eva por WhatsApp al <a href="https://api.whatsapp.com/send/?phone=34670335748" target="_blank" rel="noopener"><i class="fab fa-whatsapp">

            </i> 670 33 57 48</a>.</p>
        <?php endif; ?>
        <a href="index.php" class="btn__hero">Volver al Inicio</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
