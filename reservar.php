<?php
session_start();
require 'db_connection.php';

// Verificar si el usuario está autenticado y tiene el rol de cliente
if (isset($_SESSION['user_id']) && $_SESSION['rol'] === 'cliente') {
    // Obtener el ID del usuario de la sesión
    $user_id = $_SESSION['user_id'];

    // Consultar la base de datos para obtener los datos del usuario
    $stmt_usuario = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt_usuario->execute([$user_id]);
    $usuario = $stmt_usuario->fetch();

    // Obtener la fecha actual
    $fecha_actual = date('Y-m-d');

    // Verificar si se han recibido los datos de la reserva por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $clase = $_POST['clase'];
        $bono = $_POST['bono'];
        $fecha = $fecha_actual; // Utilizar la fecha actual
        $direccion = $_POST['direccion'];
        $localidad = $_POST['localidad'];
        $provincia = $_POST['provincia'];
        $pais = $_POST['pais'];
        $codpos = $_POST['codpos'];
        $formaPago = $_POST['forma_pago'];

        // Consultar la base de datos para obtener el ID de la clase
        $stmt_clase = $pdo->prepare("SELECT ClaseID FROM clases WHERE Nombre = ?");
        $stmt_clase->execute([$clase]);
        $clase_row = $stmt_clase->fetch();

        if ($clase_row) {
            $clase_id = $clase_row['ClaseID'];

            // Insertar la reserva en la tabla reservas
            $stmt_reserva = $pdo->prepare("INSERT INTO reservas (UsuarioID, ClaseID, Fecha, Direccion, Localidad, Provincia, Pais, CodPos, FormaPago, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, true)");
            $stmt_reserva->execute([$user_id, $clase_id, $fecha, $direccion, $localidad, $provincia, $pais, $codpos, $formaPago]);

            // Redirigir al usuario a una página de éxito
            header("Location: confirmar_reserva.php");
            exit();
        }   else {
            // Manejar el caso en que no se encuentre la clase
            echo "La clase seleccionada no existe.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Bono</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>
/* Estilos CSS */
.container-reserva {
    max-width: 600px;
    margin: 50px auto;
    margin-top: 140px; 
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.container-reserva h2 {
    text-align: center;
    color: var(--fern);
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="date"],
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-group select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="%23414141" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
}


    .form-group .btn__hero[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        border: 1px solid #66BB6A;
        color: #ffffff;
        font-size: 1.8rem;
        box-shadow: 1px 10px 30px -10px #66bb6a;
        background-color: #66BB6A;
        font-weight: bold;
        cursor: pointer;
        transition: all .3s;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .form-group .btn__hero:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #525f48;
        z-index: -2;
    }

    .form-group .btn__hero:before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background-color: #ffffff;
        transition: all .3s;
        z-index: -1;
    }

    .form-group .btn__hero:hover {
        color: #525f48;
    }

    .form-group .btn__hero:hover:before {
        width: 100%;
    }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-reserva">
        <h2>Reservar Bono</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Campos del formulario -->
            <input type="hidden" name="clase" value="<?php echo htmlspecialchars($_GET['clase']); ?>">
            <input type="hidden" name="bono" value="<?php echo htmlspecialchars($_GET['bono']); ?>">
            <div class="form-group">
    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha" value="<?php echo $fecha_actual; ?>" readonly required>
       </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required>
            </div>
            <div class="form-group">
                <label for="localidad">Localidad:</label>
                <input type="text" id="localidad" name="localidad" value="<?php echo htmlspecialchars($usuario['localidad']); ?>" required>
            </div>
            <div class="form-group">
                <label for="provincia">Provincia:</label>
                <input type="text" id="provincia" name="provincia" value="<?php echo htmlspecialchars($usuario['provincia']); ?>" required>
            </div>
            <div class="form-group">
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($usuario['pais']); ?>" required>
            </div>
            <div class="form-group">
                <label for="codpos">Código Postal:</label>
                <input type="text" id="codpos" name="codpos" value="<?php echo htmlspecialchars($usuario['codpos']); ?>" required>
            </div>
            <div class="form-group">
                <label for="forma_pago">Forma de Pago:</label>
                <select id="forma_pago" name="forma_pago" required>
                    <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                    <option value="Bizum">Bizum</option>
                    <option value="Efectivo en local">Efectivo en local</option>
                </select>
            </div>
            <button type="submit" class="form-group btn__hero">Reservar</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>