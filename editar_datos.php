<?php
session_start();
require 'db_connection.php';

$errors = array();

// Verifica si el usuario está autenticado y tiene el rol de usuario, administrador o editor
if (!isset($_SESSION['user_id']) || ($_SESSION['rol'] !== 'cliente' && $_SESSION['rol'] !== 'administrador' && $_SESSION['rol'] !== 'empleado')) {
    header("Location: login.php");
    exit();
}

$usuarioId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$usuarioId]);
$usuario = $stmt->fetch();

if ($_SESSION['rol'] === 'cliente' && $usuarioId != $_SESSION['user_id']) {
    header("Location: cliente.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $pais = $_POST['pais'];
    $codpos = $_POST['codpos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $rol = isset($_POST['rol']) ? $_POST['rol'] : '';

    if (empty($nombre) || empty($apellidos) || empty($direccion) || empty($localidad) || empty($provincia) ||  empty($pais) || empty($codpos) || empty($telefono) || empty($email)) {
        $errors[] = "Por favor, complete todos los campos.";
    } else {
        // Validar el teléfono
        if (!preg_match('/^[0-9]{9}$/', $telefono)) {
            $errors[] = "El formato del teléfono no es válido.";
        }

        // Validar el correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El formato del correo electrónico no es válido.";
        }

        // Comprobar el tamaño de los campos
        $maxSize = 255;
        if (
            strlen($nombre) > $maxSize ||
            strlen($direccion) > $maxSize ||
            strlen($localidad) > $maxSize ||
            strlen($provincia) > $maxSize ||
            strlen($pais) > $maxSize ||
            strlen($codpos) > $maxSize ||
            strlen($telefono) > $maxSize ||
            strlen($email) > $maxSize
        ) {
            $errors[] = "El tamaño de uno o más campos excede el límite permitido.";
        }

        // Si no hay errores, proceder con la actualización
        if (empty($errors)) {
            if ($_SESSION['rol'] === 'administrador' && !empty($rol)) {
                $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellidos = ?,  direccion = ?, localidad = ?, provincia = ?,  pais = ?, codpos = ?, telefono = ?, email = ?, rol = ? WHERE id = ?");
                $stmt->execute([$nombre, $apellidos, $direccion, $localidad, $provincia, $pais, $codpos , $telefono, $email, $rol, $usuarioId]);
            } elseif ($_SESSION['rol'] !== 'administrador') {
                $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellidos = ?, direccion = ?, localidad = ?, provincia = ?, pais= ?,  codpos = ?, telefono = ?, email = ? WHERE id = ?");
                $stmt->execute([$nombre, $apellidos, $direccion, $localidad, $provincia, $pais, $codpos, $telefono, $email, $usuarioId]);
            }

            $redirectPage = ($_SESSION['rol'] === 'cliente') ? "cliente.php" : ($_SESSION['rol'] === 'administrador' ? "informe_usuarios.php" : 'empleado.php');
            header("Location: $redirectPage?mensaje=Datos actualizados correctamente");
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Datos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
         .container-datos {
            margin-top: 150px; 
           margin-bottom: 150px;
           display: flex;
           justify-content: center;
           text-align:center;
            padding: 20px;
            background-color: #525f48; 
            border: 1px solid #ddd; 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
         }
         
         h2, h3 {
             color: #ffffff;
         }

        form {
            margin-top: 20px;
           

        }

        label {
            color: #a8bba2;
            margin-top: 10px;
            font-weight: bold;
            
        }

        input,
           select {
               margin-bottom: 10px; 
               width: 100%;
            padding: 10px;
            border: 1px solid #ddd; 
            border-radius: 4px; 
           }

        input[type="submit"] {
            background-color: #a8bba2;
            color: #000000;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #333;
            color: ffffff;
        }

        a {
            display: inline-block; 
            margin-top: 10px;
            text-decoration: none;
            color: #000;
            transition: color 0.3s;
        }

        a:hover {
            color: #333;
        }

        .error-container {
            background-color: #dc3545;
            color: #fff;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .error-list {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .error {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container-datos">
    <h2>Editar Datos</h2>

    <?php if (!empty($errors)) : ?>
    <div class="error-container">
        <ul class="error-list">
            <?php foreach ($errors as $error) : ?>
                <li class="error"><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>"><br>

        <label for="nombre">Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $usuario['apellidos']; ?>"><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $usuario['direccion']; ?>"><br>

        <label for="localidad">Localidad:</label>
        <input type="text" name="localidad" value="<?php echo $usuario['localidad']; ?>"><br>

        <label for="provincia">Provincia:</label>
        <input type="text" name="provincia" value="<?php echo $usuario['provincia']; ?>"><br>

        <label for="pais">Pais:</label>
        <input type="text" name="pais" value="<?php echo $usuario['pais']; ?>"><br>

        <label for="codpos">Código Postal:</label>
        <input type="text" name="codpos" value="<?php echo $usuario['codpos']; ?>"><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $usuario['telefono']; ?>"><br>

       
<label for="email">Email:</label>
<input type="email" name="email" value="<?php echo $usuario['email']; ?>"><br>

<?php if ($_SESSION['rol'] === 'administrador'): ?>
    <label for="rol">Rol:</label>
    <select name="rol">
        <option value="cliente" <?php echo ($usuario['rol'] === 'cliente') ? 'selected' : ''; ?>>Cliente</option>
        <option value="administrador" <?php echo ($usuario['rol'] === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
        <option value="empleado" <?php echo ($usuario['rol'] === 'empleado') ? 'selected' : ''; ?>>Empleado</option>
    </select> <br>
<?php endif; ?>

<input type="submit" value="Guardar Cambios">
    </form>
    <a href="<?php echo ($_SESSION['rol'] === 'cliente') ? 'cliente.php' : 'informe_usuarios.php'; ?>">Volver</a>
</div>
    
    <?php include 'footer.php'; ?>

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
