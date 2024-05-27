<?php
session_start();

require 'db_connection.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['rol'] !== 'cliente' && $_SESSION['rol'] !== 'administrador' && $_SESSION['rol'] !== 'empleado')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'];

    if ($_SESSION['rol'] === 'cliente' && $usuarioId != $_SESSION['user_id']) {
        header("Location: cliente.php");
        exit();
    }

    $stmt = $pdo->prepare("UPDATE usuarios SET activo = false WHERE id = ?");
    $stmt->execute([$usuarioId]);

    if ($_SESSION['rol'] === 'administrador' && $usuarioId != $_SESSION['user_id']) {
        header("Location: informe_usuarios.php?mensaje=Usuario eliminado correctamente");
    } else {
        session_destroy();
        header("Location: login.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Cuenta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
              body {
            font-family: 'Arial', sans-serif;
           background-color: #f8f9fa;
           margin: 0;
        }

        

        .container-delete {
    max-width: 400px;
    width: 100%;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: auto;
    margin-top: 180px; 
    margin-bottom: 100px;
}

.container-delete h2{
    text-align: center;

}

        p {
            text-align: center;
            color: #495057;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        form input[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #c82333;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container-delete">
    <h2>Eliminar Cuenta</h2>
    <p>¿Estás seguro de que deseas eliminar este usuario? Esta acción es irreversible.</p>
    <form method="POST">
        <input type="submit" value="Confirmar Eliminación">
    </form>
    <a href="<?php echo ($_SESSION['rol'] === 'cliente') ? 'cliente.php' : 'informe_usuarios.php'; ?>">Volver</a>
    </div>
    <?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
