<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'administrador') {
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
    <title>Panel de Administrador</title>
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

.container-admin {
    margin-top: 180px; 
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
    margin-top: 20px; 
}

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

.admin-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.admin-link {
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

.admin-link:hover {
    background-color: var(--fern);
    color: var(--white);
}


@media (max-width: 768px) {
    .admin-links {
        flex-direction: column;
    }
}


    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container-admin">
        <h2>Panel de Administrador</h2>
        <?php if (isset($_SESSION['user_id'])) : ?>
            <?php
            $stmt_user = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
            $stmt_user->execute([$_SESSION['user_id']]);
            $admin = $stmt_user->fetch();
            ?>
            <p class="textoBienvenida">Bienvenido, <?php echo $admin['nombre']; ?></p>
        <?php endif; ?>

        
        <div class="admin-links">
            <a href="informe_usuarios.php" class="admin-link">Informe de Usuarios</a>
            <a href="informe_clases.php" class="admin-link">Mantenimiento de Clases</a>
            <a href="estadisticas_pedidos.php" class="admin-link">Estadísticas de Reservas</a>
            <a href="ventas.php" class="admin-link">Reservas del Mes</a>
        </div>

    </div>


    <?php include 'footer.php'; ?>
</body>
</html>



    
  