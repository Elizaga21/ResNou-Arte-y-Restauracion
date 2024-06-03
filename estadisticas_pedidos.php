<?php
session_start();
require 'db_connection.php';
include 'header.php';

// Función para modificar el EstadoReserva
function modificarEstadoReserva($pdo, $reservaID, $nuevoEstado) {
    $stmt = $pdo->prepare("UPDATE reservas SET EstadoReserva = ? WHERE ReservaID = ?");
    $stmt->execute([$nuevoEstado, $reservaID]);
}

// Función para eliminar una reserva (baja lógica)
function eliminarReserva($pdo, $reservaID) {
    $stmtEliminarReserva = $pdo->prepare("UPDATE reservas SET activo = 0 WHERE ReservaID = ?");
    $stmtEliminarReserva->execute([$reservaID]);
}

// Verificar si se envió el formulario para modificar el EstadoReserva
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modificar_estado'])) {
        $reservaID = $_POST['reserva_id'];
        $nuevoEstado = $_POST['nuevo_estado'];
        modificarEstadoReserva($pdo, $reservaID, $nuevoEstado);
    } elseif (isset($_POST['eliminar_reserva'])) {
        $reservaID = $_POST['reserva_id'];
        eliminarReserva($pdo, $reservaID);
    }
}

// Paginación
$elementosPorPagina = 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$indiceInicio = ($paginaActual - 1) * $elementosPorPagina;

// Consulta para obtener detalles de reservas con límite y desplazamiento (solo registros activos)
$sqlReservas = "SELECT r.ReservaID, r.UsuarioID, r.EstadoReserva, r.Fecha, r.Direccion, r.Localidad, r.Provincia, r.Pais, r.CodPos, c.PrecioTotal 
                FROM reservas r 
                LEFT JOIN compras c ON r.CompraID = c.CompraID
                WHERE r.activo = 1
                LIMIT :indiceInicio, :elementosPorPagina";

$stmtReservas = $pdo->prepare($sqlReservas);
$stmtReservas->bindParam(':indiceInicio', $indiceInicio, PDO::PARAM_INT);
$stmtReservas->bindParam(':elementosPorPagina', $elementosPorPagina, PDO::PARAM_INT);
$stmtReservas->execute();
$reservasPaginadas = $stmtReservas->fetchAll(PDO::FETCH_ASSOC);

// Consulta para contar el total de reservas (solo registros activos)
$sqlTotalReservas = "SELECT COUNT(*) as total FROM reservas WHERE activo = 1";
$stmtTotalReservas = $pdo->query($sqlTotalReservas);
$totalReservas = $stmtTotalReservas->fetch(PDO::FETCH_ASSOC)['total'];
$paginasTotales = ceil($totalReservas / $elementosPorPagina);

// Consulta para obtener estadísticas de reservas (solo registros activos)
$sqlEstadisticas = "SELECT EstadoReserva, COUNT(*) as Cantidad FROM reservas WHERE activo = 1 GROUP BY EstadoReserva";
$stmtEstadisticas = $pdo->query($sqlEstadisticas);
$estadisticasReservas = $stmtEstadisticas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas y Detalles de Reservas</title>
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
        .container-estadis {
            margin-top: 160px; 
            margin-bottom: 150px;
            display: flex;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            padding: 20px;
            align-items: center;
            max-width: auto;
        }

        h2 {
            color: #525f48;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        table th {
            background-color: #525f48;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #a8bba2;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        .btn-group {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .btn-delete {
        background-color: #a8bba2;
        color: #fff;
        border: none;
        margin-top: 20px;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        margin-right: 5px;
    }

    .btn-delete:hover {
        background-color: #c82333;
        transform: scale(1.05);
    }

        .pagination {
            display: inline-block;
            margin-bottom: 0;
        }

        .pagination a {
            color: #525f48;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            border: 1px solid #ddd;
        }

        .pagination a:hover {
            background-color: #525f48;
            color: #fff;
            border: 1px solid #525f48;
        }

        .pagination .active a {
            background-color: #a8bba2;
            color: #fff;
            border: 1px solid #525f48;
        }

        .pagination li {
            display: inline-block;
            margin-right: 5px;
        }

        .pagination li:last-child {
            margin-right: 0;
        }
          /* Estilos responsivos */
          @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }

            table th,
            table td {
                font-size: 14px;
                padding: 8px;
            }

            .btn-group {
                display: flex;
                flex-direction: column;
            }

            .btn-group form {
                margin-bottom: 5px;
            }

            .pagination {
                display: flex;
                flex-wrap: wrap;
            }

            .pagination li {
                margin-right: 3px;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 480px) {
            table th,
            table td {
                font-size: 12px;
                padding: 6px;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-group form {
                margin-bottom: 5px;
            }

            .pagination a {
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
<div class="container-estadis">
    <h2>Estadísticas y Detalles de Reservas</h2>
    
    <!-- Estadísticas de Reservas -->
    <div class="table-container">
        <table>
            <tr>
                <th>Estado de la Reserva</th>
                <th>Cantidad</th>
            </tr>
            <?php foreach ($estadisticasReservas as $estadistica): ?>
                <tr>
                    <td><?php echo htmlspecialchars($estadistica['EstadoReserva']); ?></td>
                    <td><?php echo htmlspecialchars($estadistica['Cantidad']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<br>
    <!-- Lista de Reservas -->
    <h1>Lista de Reservas</h1>
    <div class="table-container">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ReservaID</th>
                    <th>UsuarioID</th>
                    <th>Estado de la Reserva</th>
                    <th>Fecha</th>
                    <th>Dirección</th>
                    <th>Localidad</th>
                    <th>Provincia</th>
                    <th>País</th>
                    <th>Código Postal</th>
                    <th>Total de la Compra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservasPaginadas as $reserva): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['ReservaID']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['UsuarioID']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['EstadoReserva']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Fecha']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Direccion']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Localidad']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Provincia']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['Pais']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['CodPos']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['PrecioTotal']); ?></td>
                        <td>
                            <div class="btn-group">
                                <!-- Formulario para modificar estado de la reserva -->
                                <form method="post" action="">
                                    <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reserva['ReservaID']); ?>">
                                    <select name="nuevo_estado" onchange="this.form.submit()">
                                        <option value="">Cambiar Estado</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Pagado">Pagado</option>
                                    </select>
                                    <input type="hidden" name="modificar_estado" value="1">
                                </form>
                                <!-- Formulario para eliminar reserva -->
                                <form method="post" action="" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reserva?');">
                                    <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reserva['ReservaID']); ?>">
                                    <input type="hidden" name="eliminar_reserva" value="1">
                                    <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($paginaActual > 1): ?>
                    <li><a href="?pagina=<?php echo $paginaActual - 1; ?>">Anterior</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $paginasTotales; $i++): ?>
                    <li class="<?php echo ($i === $paginaActual) ? 'active' : ''; ?>"><a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <?php if ($paginaActual < $paginasTotales): ?>
                    <li><a href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<?php include 'footer.php'; ?>

</body>
</html>
