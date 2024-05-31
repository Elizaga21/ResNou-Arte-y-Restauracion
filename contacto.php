
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto ResNou</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>

.contact-info {
    background-color: #f7f7f7;
    margin-top: 100px; 
    margin-bottom: 50px;
    display: flex;
    justify-content: center;
    text-align:center;
    align-items: center;
    max-width: auto;
        }

.container-info {
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    max-width: 80rem;
}

.contact-info h2 {
    margin-bottom: 2rem;
}

.contact-info ul {
    margin-bottom: 3rem;
}

.contact-info ul li {
    margin-bottom: 1rem;
}

.contact-form {
    background-color: #ffffff;
    padding: 5rem 0;
    text-align: center;
    margin-top: 5rem;
}

.contact-form h2 {
    margin-bottom: 3rem;
}

.contact-form form {
    max-width: 50rem;
    margin: 0 auto;
}

.contact-form label {
    display: block;
    margin-bottom: 1.5rem;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 1rem;
    margin-bottom: 2rem;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
    resize: none;
}

.contact-form button {
    background-color: #525f48;
    color: #ffffff;
    border: none;
    padding: 1.5rem 3rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.contact-form button:hover {
    background-color: #40513f;
}


    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="contact-info">
        <div class="container-info">
            <h2>Información de Contacto</h2>
            <br>
            <p><strong>Nuestras instalaciones:</strong> Visítanos en nuestro establecimiento o contacta con tus dudas a través del formulario, en nuestro teléfono, en nuestras redes...</p>
            <p>Envíanos una foto de tu mueble u objeto antiguo y podré darte mi opinión y ofrecerte una valoración aproximada.</p>
            <p>No lo dudes y recupera tus objetos antiguos. ¡Contacta con nosotros!</p>
            <p><strong>Datos de contacto:</strong></p>
            <p><strong>Dirección:</strong> calle México 2, local 5<br>03206, Elche / Alicante, Alicante, España</p>
            <p><strong>Teléfono:</strong> 670 335 748</p>
            <p><strong>E-mail:</strong> eva@resnou.com</p>
            <a href="https://api.whatsapp.com/send/?phone=34670335748" target="_blank" rel="noopener">
    <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
</a>

        </div>
    </section>

    <div id="map" style="height: 400px;"></div>


     <section class="contact-form">
        <div class="container">
            <h2>Formulario de contacto</h2>
            <form action="send_email.php" method="post">
                <label for="name">Nombre<span>*</span>:</label>
                <input type="text" id="name" name="name" required>
                <label for="last_name">Apellidos:</label>
                <input type="text" id="last_name" name="last_name">
                <label for="email">Email<span>*</span>:</label>
                <input type="email" id="email" name="email" required>
                <label for="phone">Teléfono:</label>
                <input type="text" id="phone" name="phone">
                <label for="message">Mensaje<span>*</span>:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                <div class="privacy">
                    <input type="checkbox" id="privacy_policy" name="privacy_policy" required>
                    <label for="privacy_policy">He leído y acepto la <a href="#">Política de Privacidad</a></label>
                </div>
                <div class="permission">
                    <input type="checkbox" id="commercial_permission" name="commercial_permission">
                    <label for="commercial_permission">Autorizo a contactarme por email o por cualquier medio con fines comerciales</label>
                </div>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <script>
    var map = L.map('map').setView([38.27359016430133, -0.7181396491327836], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
        maxZoom: 19,
    }).addTo(map);

    var marker = L.marker([38.27359016430133, -0.7181396491327836]).addTo(map); 
    marker.bindPopup("<b>Calle México 2, local 5</b>").openPopup(); 
</script>



</body>
</html>
