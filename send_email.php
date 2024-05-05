<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $to = "eva@resnou.com";

    $subject = "Mensaje de contacto de $name $last_name";

    $body = "Nombre: $name $last_name\nCorreo electrónico: $email\nTeléfono: $phone\nMensaje: $message";

    $headers = "From: $name $last_name <$email>";

    if (mail($to, $subject, $body, $headers)) {
        echo "¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.";
    } else {
        echo "Lo sentimos, hubo un problema al enviar tu mensaje.";
    }
}

?>
