<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php'; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empleado</title>
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
.container-empleado {
    margin-top: 160px; 
    margin-bottom: 150px;
    display: flex;
    justify-content: center;
    text-align:center;
    flex-direction: column;
    padding: 20px;
    align-items: center;
    max-width: auto;
}

h2, h3 {
    text-align: center;
    color: var(--green);
    margin-bottom: 20px;

}

.welcome-text {
    font-size: 1.2em;
    color: var(--fern);
    text-align: center;
    margin-bottom: 20px;
    margin-top: 20px; }

.order-form {
    margin-top: 20px;
}

.order-button {
    background-color: #000; 
    color: #fff; 
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.order-button:hover {
    background-color: #333; 
}

.empleado-links {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
    justify-content: center;
    gap: 15px;
}

.empleado-link {
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

.empleado-link:hover {
    background-color: var(--fern);
    color: var(--white);
}

@media (max-width: 768px) {
    .empleado-links  {
        flex-direction: column;
    }
}
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container-empleado">
        <h2>Panel de Empleado</h2>
        <?php if (isset($_SESSION['user_id'])) : ?>
            <?php
            $stmt_user = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
            $stmt_user->execute([$_SESSION['user_id']]);
            $empleado = $stmt_user->fetch();
            ?>
            <p class="textoBienvenida">Bienvenido, <?php echo $empleado['nombre']; ?></p>
        <?php endif; ?>

        
        <div class="empleado-links">
        <a href="mantenimiento_categorias.php" class="empleado-link">Mantenimiento de Clases</a>
        <a href="estadisticas_pedidos.php" class="empleado-link">Estadísticas de Reservas</a>
      </div>

    </div>


    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

