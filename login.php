<?php
session_start();
require 'db_connection.php';

// Si el usuario ya está conectado, redirige a la página de inicio correspondiente
if (isset($_SESSION['user_id'])) {
    if($_SESSION['rol'] === 'administrador') {
        header("Location: admin.php");
    }  elseif ($_SESSION['rol'] === 'empleado') {
        header("Location: empleado.php");
    }  elseif ($_SESSION['rol'] === 'cliente') {
        header("Location: cliente.php");
    } else{
        header("Location: user.php");
    }
    exit();
}

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contrasena = $_POST['contrasena'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id, email, contrasena, rol FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Iniciar sesión y redirigir según el rol
        switch ($user['rol']) {
            case 'administrador':
                if ($contrasena === 'root') {
                    iniciarSesion($user);
                    header("Location: admin.php");
                    exit();
                }
                break;
            case 'empleado':
                if (password_verify($contrasena, $user['contrasena'])) {
                    iniciarSesion($user);
                    header("Location: empleado.php");
                    exit();
                }
                break;
            case 'cliente':
                if (password_verify($contrasena, $user['contrasena'])) {
                    iniciarSesion($user);
                    header("Location: cliente.php");
                    exit();
                }
                break;
        }
    }

    $error = "Credenciales incorrectas.";
    
}


function iniciarSesion($usuario) {
    $_SESSION['user_id'] = $usuario['id'];
    $_SESSION['rol'] = $usuario['rol'];
    $_SESSION['nombre'] = obtenerNombreDeUsuario();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

  .login-container {
    background-color: #f7f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.form-container {
    background-color: #ffffff;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    max-width: 30rem;
}

.form-container h2 {
    text-align: center;
    margin-bottom: 2rem;
}

.form-container form {
    display: flex;
    flex-direction: column;
}

.form-container input[type="text"],
.form-container input[type="password"] {
    margin-bottom: 1rem;
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: .5rem;
}

.form-container input[type="submit"] {
    background-color: #525f48;
    color: #ffffff;
    border: none;
    padding: 1rem;
    border-radius: .5rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-container input[type="submit"]:hover {
    background-color: #5a9c5d;
}

.form-container .links {
    margin-top: 1rem;
}

.form-container .links p {
    margin-bottom: .5rem;
}

.form-container .links a {
    color: #525f48;
}

.form-container .links a:hover {
    text-decoration: underline;
    color: #5a9c5d;
}


    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="login-container">
        <div class="form-container">
            <h2>Iniciar sesión</h2>
            <div class="logoLogin">
            <img src="assets/img/LogoRESNOUNegroC.svg" alt="Logo de ResNou">
        </div>
            <?php if (isset($error)) { echo '<p style="color: #e74c3c;">' . $error . '</p>'; } ?>
            <form method="POST">
                <input type="text" name="email" placeholder="email">
                <input type="password" name="contrasena" placeholder="contraseña">
                <input type="submit" value="Iniciar sesión">
            </form>
            <div class="links">
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                <p><a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a></p>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>
   
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>