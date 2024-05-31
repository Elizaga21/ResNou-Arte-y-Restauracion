<?php
session_start();
require 'db_connection.php';

// Verificar si el usuario está autenticado y tiene el rol de cliente
if (isset($_SESSION['user_id']) && $_SESSION['rol'] === 'cliente') {
    // Obtener el ID del usuario de la sesión
    $user_id = $_SESSION['user_id'];

    // Verificar si se han recibido los datos de la reserva por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $clase = $_POST['clase'];
        $bono = $_POST['bono'];
        $fecha = $_POST['fecha'];
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
            header("Location: reserva_exitosa.php");
            exit();
        } else {
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
    <title>Reservar Clase</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>
    /* Estilos CSS */
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Reservar Clase</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Campos del formulario -->
            <input type="hidden" name="clase" value="<?php echo htmlspecialchars($_GET['clase']); ?>">
            <input type="hidden" name="bono" value="<?php echo htmlspecialchars($_GET['bono']); ?>">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="localidad">Localidad:</label>
                <input type="text" id="localidad" name="localidad" required>
            </div>
            <div class="form-group">
                <label for="provincia">Provincia:</label>
                <input type="text" id="provincia" name="provincia" required>
            </div>
            <div class="form-group">
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" required>
            </div>
            <div class="form-group">
                <label for="codpos">Código Postal:</label>
                <input type="text" id="codpos" name="codpos" required>
            </div>
            <div class="form-group">
                <label for="forma_pago">Forma de Pago:</label>
                <select id="forma_pago" name="forma_pago" required>
                    <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                    <option value="Bizum">Bizum</option>
                    <option value="Efectivo en local">Efectivo en local</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Reservar</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
