<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    .container-cliente {
        margin-top: 150px; 
    margin-bottom: 120px;
    display: flex;
    justify-content: center;
    text-align:center;
    flex-direction: column;
    align-items: center;
    max-width: auto;
        }

        h2 {
    text-align: center;
    color: var(--green);
}
.textoBienvenida {
    font-size: 1.2em;
    color: var(--fern);
    text-align: center;
    margin-bottom: 20px;
}

.cliente-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.cliente-link {
    display: block;
    padding: 15px 25px;
    background-color: var(--beige);
    color: var(--black);
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    font-weight: bold;
    text-align: center;
}

.cliente-link:hover {
    background-color: var(--fern);
    color: var(--white);
}

@media (max-width: 768px) {
    .cliente-links {
        flex-direction: column;
    }
}


    </style>
</head>
<body>
    
    <?php include 'header.php'; ?>

<div class="container-cliente">
        <h2>Panel de Cliente</h2>
        <?php if (isset($_SESSION['user_id'])) : ?>
            <?php
            $stmt_user = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
            $stmt_user->execute([$_SESSION['user_id']]);
            $cliente = $stmt_user->fetch();
            ?>
            <p class="textoBienvenida">Hola, <?php echo $cliente['nombre']; ?></p>
        <?php endif; ?>

        
        <div class="cliente-links">
            <a href="perfil.php" class="cliente-link">Perfil</a>
            <a href="mis_reservas.php" class="cliente-link"> Estado Reserva</a>
            <a href="clases_compradas.php" class="cliente-link">Tus clases compradas</a>
            <a href="eliminar_cuenta.php" class="cliente-link">Eliminar Cuenta</a>


        </div>

    </div>

    <?php include 'footer.php'; ?>


</body>
</html>
