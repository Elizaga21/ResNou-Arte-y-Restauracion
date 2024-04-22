<?php
require 'db_connection.php';
include 'header.php'; 
session_start();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $DNI = $_POST['DNI'];
    $Nombre = $_POST['Nombre'];
    $Telefono = $_POST['Telefono'];
    $Direccion = $_POST['Direccion'];
    $Localidad = $_POST['Localidad'];
    $Provincia = $_POST['Provincia'];
    $Pais = $_POST['Pais'];
    $Codpos = $_POST['Codpos'];
    $Email = $_POST['Email'];
    $Contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $Rol = 'Cliente'; 

    if (empty($DNI) || empty($Nombre) ||  empty($Telefono)|| empty($Direccion) || empty($Localidad) || empty($Provincia) || empty($Pais) || empty($Codpos) || empty($Email) || empty($Contrasena)) {
        $errors[] = "Por favor, complete todos los campos.";
    } else {
        if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $DNI)) {
            $errors[] = "El formato del DNI no es válido.";
        } else {
            // Obtener la letra del DNI
            $letraDNI = strtoupper(substr($DNI, -1));
            $numerosDNI = substr($DNI, 0, -1);

            // Calcular la letra correcta
            $letrasPosibles = 'TRWAGMYFPDXBNJZSQVHLCKE';
            $letraCorrecta = $letrasPosibles[$numerosDNI % 23];

            // Comprobar si la letra es correcta
            if ($letraCorrecta !== $letraDNI) {
                $errors[] = "La letra del DNI no es correcta.";
            }

            // Validar el teléfono
            if (!preg_match('/^[0-9]{9}$/', $Telefono)) {
                $errors[] = "El formato del teléfono no es válido.";
            } else {
                // Validar el correo electrónico
                if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "El formato del correo electrónico no es válido.";
                } else {
                    // Comprobar si el correo electrónico ya existe
                    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
                    $stmt->execute([$Email]);
                    $existingEmail = $stmt->fetch();
                }

                    if ($existingEmail) {
                        $errors[] = "El correo electrónico ya está registrado.";
                    } else {
                    // Comprobar si el DNI ya existe
                    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE dni = ?");
                    $stmt->execute([$DNI]);
                    $existingUser = $stmt->fetch();

                    if (!$existingUser) {
                        // Comprobar el tamaño de los campos
                        $maxSize = 255; 
                        if (
                            strlen($Nombre) > $maxSize ||
                            strlen($Telefono) > $maxSize ||
                            strlen($Email) > $maxSize
                        ) {
                            $errors[] = "El tamaño de uno o más campos excede el límite permitido.";
                        } else {
        // Insertar usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuarios (dni, nombre, telefono, direccion, localidad, provincia, pais, codpos, email, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?)");
        $stmt->execute([$DNI, $Nombre, $Telefono, $Direccion, $Localidad, $Provincia, $Pais, $Codpos, $Email, $Contrasena, $Rol]);
        
        header("Location: login.php");
        exit();
    }
}
}
}
}
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de usuario</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>

.main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
    max-width: 400px;
    padding: 20px;
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.container form {
    display: flex;
    flex-direction: column;
}

.container input[type="text"],
.container input[type="password"] {
    margin-bottom: 15px;
    padding: 10px;
    border: none;
    border-bottom: 2px solid #ccc;
    background-color: transparent;
    transition: border-bottom-color 0.3s;
}

.container input[type="text"]:focus,
.container input[type="password"]:focus {
    outline: none;
    border-bottom-color: #66BB6A;
}

.container input[type="submit"] {
    background-color: #66BB6A;
    color: #ffffff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.container input[type="submit"]:hover {
    background-color: #5a9c5d;
}

.error {
    color: #e74c3c;
    margin-top: 10px;
}

@media screen and (max-width: 600px) {
    .container {
        max-width: 100%;
        padding: 10px;
    }
}


    </style>
</head>
<body>

<div class="main-container">
    <div class="container">

        <h2>Registro de usuario</h2>
        <form method="POST">
            <input type="text" name="DNI" placeholder="DNI">
            <input type="text" name="Nombre" placeholder="Nombre">
            <input type="text" name="Telefono" placeholder="Teléfono">
            <input type="text" name="Direccion" placeholder="Dirección">
            <input type="text" name="Localidad" placeholder="Localidad">
            <input type="text" name="Provincia" placeholder="Provincia">
            <input type="text" name="Pais" placeholder="País">
            <input type="text" name="Codpos" placeholder="Código Postal">
            <input type="text" name="Email" placeholder="Email">
            <input type="password" name="contrasena" placeholder="Contraseña">
            <input type="submit" value="Registrarse" class="btn btn-success">
        </form>
        <?php if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<p class="error">' . $error . '</p>';
            }
        } ?>
    </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
