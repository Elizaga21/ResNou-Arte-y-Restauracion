<?php
require 'db_connection.php';
include 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Obtener los valores seleccionados del filtro de año y mes
$anioSeleccionado = isset($_GET['anio']) ? $_GET['anio'] : date('Y');
$mesSeleccionado = isset($_GET['mes']) ? $_GET['mes'] : date('m');

// Consulta para obtener información de ventas filtrada por año y mes
$sql = "SELECT YEAR(FechaCompra) as Anio, MONTH(FechaCompra) as Mes, COUNT(*) as CantidadCompras, SUM(PrecioTotal) as TotalVentas
        FROM compras
        WHERE YEAR(FechaCompra) = :anioSeleccionado AND MONTH(FechaCompra) = :mesSeleccionado
        GROUP BY YEAR(FechaCompra), MONTH(FechaCompra)";

$stmt = $pdo->prepare($sql);
$stmt->execute(['anioSeleccionado' => $anioSeleccionado, 'mesSeleccionado' => $mesSeleccionado]);
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

        .filtro {
    margin-bottom: 20px;
}

.filtro label {
    margin-right: 10px;
}

.filtro select,
.filtro button {
    padding: 8px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.filtro button {
    background-color: #525f48;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.filtro button:hover {
    background-color: #354037;
}


    </style>
</head>
<body>

    <div class="container-reservas">
    <h2>Información de Ventas</h2>
    <br>
    <div class="filtro">
        <form method="GET" action="">
            <label for="anio">Selecciona el año:</label>
            <select name="anio" id="anio">
                <?php for ($i = date('Y'); $i >= 2024; $i--): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="mes">Selecciona el mes:</label>
            <select name="mes" id="mes">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?php echo $m; ?>"><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>
    <table>
    <tr>
        <th>Año</th>
        <th>Mes</th>
        <th>Cantidad de Compras</th>
        <th>Total Ventas (€)</th>
    </tr>
    <?php foreach ($ventas as $venta): ?>
        <tr>
            <td><?php echo $venta['Anio']; ?></td>
            <td><?php echo $venta['Mes']; ?></td>
            <td><?php echo $venta['CantidadCompras']; ?></td>
            <td><?php echo number_format($venta['TotalVentas'], 2, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
