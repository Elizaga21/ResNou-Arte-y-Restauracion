<?php
session_start();
require 'db_connection.php';

// Verificar si el usuario está autenticado como cliente
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Consulta para obtener los artículos comprados por el cliente
$stmt = $pdo->prepare("SELECT c.Nombre AS NombreClase, c.Descripcion, cp.FechaCompra, cp.PrecioTotal, cp.FormaPago
                      FROM compras cp
                      JOIN clases c ON cp.ClaseID = c.ClaseID
                      WHERE cp.UsuarioID = ?
                      ORDER BY cp.FechaCompra DESC");

$stmt->execute([$user_id]);
$articulosComprados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonos Comprados</title>
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

        .container-clases {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin-top: 140px; 
            margin-bottom: 50px;
        }

        .compras-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .compra {
            background-color: var(--green);
            color: var(--white);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 300px;
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s;
        }

        .compra:hover {
            transform: translateY(-5px);
        }

        .compra strong {
            display: block;
            padding: 10px;
            color: var(--fern);
            width: 100%;
            text-align: center;
            border-radius: 8px 8px 0 0;
            font-size: 1.2em;
        }

        .compra p {
            margin: 10px 0;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
            color: var(--black);
        }

        @media (max-width: 600px) {
            .container-clases {
                margin-top: 50px;
                margin-bottom: 30px;
            }

            .compra {
                max-width: 100%;
            }

            h2 {
                font-size: 1.5em;
            }
        }
    </style>
      
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container-clases">
        <h2>Clases Compradas</h2>
        <?php if (!empty($articulosComprados)): ?>
    <div class="compras-container">
        <?php foreach ($articulosComprados as $compra): ?>
            <div class="compra">
                <strong><?php echo htmlspecialchars($compra['NombreClase']); ?></strong>
                <p>Descripción: <?php echo htmlspecialchars($compra['Descripcion']); ?></p>
                <p>Fecha de Compra: <?php echo htmlspecialchars($compra['FechaCompra']); ?></p>
                <p>Precio Total: <?php echo htmlspecialchars($compra['PrecioTotal']); ?> €</p>
                <p>Forma de Pago: <?php echo htmlspecialchars($compra['FormaPago']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No has comprado ninguna clase aún.</p>
<?php endif; ?>

    </div>

    <?php include 'footer.php'; ?>

</body>
</html>