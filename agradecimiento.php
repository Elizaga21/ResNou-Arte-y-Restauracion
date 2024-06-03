<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    echo "Acceso denegado.";
    exit();
}

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimiento por tu Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="assets/css/main.css">
    <style>

:root {
    --black: #000000;
    --white: #ffffff;
    --green: #525f48;
    --beige: #b79e94;
    --fern: #a8bba2;
}

        .container-gracias {
            max-width: 600px;
            margin: 50px auto;
            margin-top: 140px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }
        

        
        .button-container {
            margin-top: 20px;
        }

        .button-container a {
            text-decoration: none;
            background-color: #525f48;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .button-container a:first-child {
            margin-right: 10px; 
        }

        .button-container a:hover {
            background-color: #a8bba2;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container-gracias">
        <h2>Agradecemos tu Compra</h2>
        <p>Gracias por elegir nuestro bono. Tu compra ha sido realizada con éxito.</p>
     
       
        <div class="button-container">
        <a href="clases_compradas.php">Ver Bono Comprado</a>
            <a href="index.php">Volver a la Página Principal</a>
          
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
