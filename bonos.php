<?php
session_start(); // Iniciar la sesión
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php'); // Redirigir al usuario al login si no tiene el rol de cliente
    exit(); // Detener la ejecución del script
}

// Continuar con el resto del código solo si el usuario tiene el rol de cliente
$user_id = $_SESSION['user_id'];
    if(isset($_GET['clase']) && isset($_GET['bono'])) {
        // Obtener los parámetros de la URL
        $clase = $_GET['clase'];
        $bono = $_GET['bono'];
    
        // Consultar la base de datos para obtener los detalles de la clase y el precio del bono
        $stmt_clase = $pdo->prepare("SELECT * FROM clases WHERE Nombre = ?");
        $stmt_clase->execute([$clase]);
        $claseDetails = $stmt_clase->fetch();
        
        // Verificar si se encontraron resultados y determinar el precio del bono seleccionado
        if($claseDetails) {
            $precioBono = ($bono == '6') ? $claseDetails['PrecioBono6'] : $claseDetails['PrecioBono10'];
        } else {
            // Manejar el caso en que no se encuentre la clase
            echo "La clase seleccionada no existe.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonos</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>

:root {
    --black: #000000;
    --white: #ffffff;
    --green: #525f48;
    --beige: #b79e94;
    --fern: #a8bba2;
}

.container-bonos {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 20px;
    margin-top: 100px; 
    margin-bottom: 50px;
    position: relative; 
    z-index: 1; 
}


.product {
    background-color: var(--green);
    border: 2px solid var(--fern);
    border-radius: 10px;
    margin: 10px;
    width: 220px;
    text-align: center;
    padding: 20px;
    box-sizing: border-box;
}

.img-container {
    position: relative;
    width: 100%;
}

.default-img, .hover-img {
    max-width: 100%;
    transition: opacity 0.5s ease-in-out;
}

.hover-img {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.img-container:hover .hover-img {
    opacity: 1;
}

.img-container:hover .default-img {
    opacity: 0;
}

.description h2 {
    font-size: 1.2em;
    margin: 10px 0;
    color: #a8bba2;
}

.description p {
    font-size: 1em;
    color: var(--white);
}

.bonus-button {
    display: inline-block;
    background-color: var(--fern);
    color: var(--black);
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1em;
    text-decoration: none;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out, font-weight 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.bonus-button:hover {
    background-color: var(--beige);
    transform: translateY(-3px);
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
    font-weight: bold;
}

.bonus-button:link, .bonus-button:visited {
    color: var(--black);
    text-decoration: none;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
    }

    .product {
        width: 80%;
        margin: 10px 0;
    }
}

@media (max-width: 480px) {
    .product {
        width: 100%;
        padding: 10px;
    }

    .description h2 {
        font-size: 1em;
    }

    .description p {
        font-size: 0.9em;
    }

    .bonus-button {
        font-size: 0.9em;
        padding: 8px 16px;
    }
}

    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-bonos">
        <?php
        if(isset($claseDetails)) {
            echo "<div class='product'>";
            echo "<div class='description'>";
            echo "<h2>Detalles de la Clase</h2>";
            echo "<p><strong>Nombre:</strong> {$claseDetails['Nombre']}</p>";
            echo "<p><strong>Descripción:</strong> {$claseDetails['Descripcion']}</p>";
            echo "<p><strong>Dia:</strong> {$claseDetails['Dia']}</p>";
            echo "<p><strong>Precio del Bono {$bono}:</strong> {$precioBono}€</p>";
            echo "</div>";
            echo "<a href='reservar.php?clase={$claseDetails['Nombre']}&bono={$bono}' class='bonus-button'>Reservar</a>";
            echo "</div>";
        } else {
            echo "La clase seleccionada no existe.";
        }
        ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
