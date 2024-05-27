<?php
require 'db_connection.php';
include 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Consulta para obtener información de ventas
$sql = "SELECT r.Fecha, r.EstadoReserva, COUNT(*) as Cantidad, SUM(r.FormaPago) as TotalVentas, SUM(c.PrecioTotal) as TotalPedido
        FROM reservas r
        JOIN compras c ON r.CompraID = c.CompraID
        GROUP BY r.Fecha, r.EstadoReserva";

$stmt = $pdo->query($sql);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Ventas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>
      :root {
    --black: #000000;
    --white: #ffffff;
    --green: #525f48;
    --beige: #b79e94;
    --fern: #a8bba2;
}
        .container-reservas {
    margin-top: 150px; 
    margin-bottom: 150px;
    display: flex;
    justify-content: center;
    text-align:center;
    flex-direction: column;
    padding: 20px;
    align-items: center;
    max-width: auto;
        }

        h2 {
            color: #525f48;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #525f48;
            color: #fff;
        }

    </style>
</head>
<body>

    <div class="container-reservas">
    <h2>Información de Ventas</h2>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Estado de la Reserva</th>
                <th>Cantidad de Reservas</th>
                <th>Total Ventas</th>
                <th>Total Pagado (€)</th>
            </tr>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?php echo $venta['Fecha']; ?></td>
                    <td><?php echo $venta['EstadoReserva']; ?></td>
                    <td><?php echo $venta['Cantidad']; ?></td>
                    <td><?php echo $venta['TotalVentas']; ?></td>
                    <td><?php echo $venta['TotalPedido']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

