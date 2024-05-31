<?php
session_start();
include 'db_connection.php'; // Incluir la conexión a la base de datos

// Verificar si se han pasado los parámetros de la reserva
if (isset($_GET['claseID']) && isset($_GET['usuarioID']) && isset($_GET['fecha']) && isset($_GET['precioTotal'])) {
    $claseID = $_GET['claseID'];
    $usuarioID = $_GET['usuarioID'];
    $fecha = $_GET['fecha'];
    $precioTotal = $_GET['precioTotal'];

    // Obtener información adicional de la clase
    $query = $conn->prepare("SELECT Nombre, Descripcion FROM clases WHERE ClaseID = ?");
    $query->bind_param("i", $claseID);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $clase = $result->fetch_assoc();
        $nombreClase = $clase['Nombre'];
        $descripcionClase = $clase['Descripcion'];

        // Mostrar la confirmación de la reserva
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmación de Reserva</title>
        </head>
        <body>
            <h1>¡Reserva Confirmada!</h1>
            <p>Se ha reservado la clase <strong><?php echo $nombreClase; ?></strong> para el usuario con ID <?php echo $usuarioID; ?> el <?php echo $fecha; ?>.</p>
            <p>Descripción de la clase: <?php echo $descripcionClase; ?></p>
            <p>Precio Total: <?php echo $precioTotal; ?> euros</p>
            <p>¡Gracias por reservar con nosotros!</p>
        </body>
        </html>
        <?php
    } else {
        // Clase no encontrada
        echo "Error: Clase no encontrada.";
    }
} else {
    // Parámetros de reserva faltantes
    echo "Error: Parámetros de reserva faltantes.";
}
?>
