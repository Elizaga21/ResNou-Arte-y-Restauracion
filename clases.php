<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases Ofertadas</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <style>

:root {
    --black: #000000;
    --white: #ffffff;
    --green: #525f48;
    --beige: #b79e94;
    --fern: #a8bba2;
}

.container-clases {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 20px;
    margin-top: 100px; 
    margin-bottom: 50px;
    position: relative; 
    z-index: 1; 
}


.product {
    background-color: var(--green);
    border: 2px solid var(--fern);
    border-radius: 10px;
    margin: 10px;
    width: 220px;
    text-align: center;
    padding: 20px;
    box-sizing: border-box;
}

.img-container {
    position: relative;
    width: 100%;
}

.default-img, .hover-img {
    max-width: 100%;
    transition: opacity 0.5s ease-in-out;
}

.hover-img {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.img-container:hover .hover-img {
    opacity: 1;
}

.img-container:hover .default-img {
    opacity: 0;
}

.description h2 {
    font-size: 1.2em;
    margin: 10px 0;
}

.description p {
    font-size: 1em;
    color: var(--white);
}

.bonus-button {
    display: inline-block;
    background-color: var(--fern);
    color: var(--black);
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1em;
    text-decoration: none;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out, font-weight 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.bonus-button:hover {
    background-color: var(--beige);
    transform: translateY(-3px);
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
    font-weight: bold;
}

.bonus-button:link, .bonus-button:visited {
    color: var(--black);
    text-decoration: none;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
    }

    .product {
        width: 80%;
        margin: 10px 0;
    }
}

@media (max-width: 480px) {
    .product {
        width: 100%;
        padding: 10px;
    }

    .description h2 {
        font-size: 1em;
    }

    .description p {
        font-size: 0.9em;
    }

    .bonus-button {
        font-size: 0.9em;
        padding: 8px 16px;
    }
}

    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-clases">
        <div class="product">
            <div class="img-container">
                <img src="assets/img/clases/Designer (4).jpeg" alt="Foto dibujo" class="default-img">
                <img src="assets/img/Designer (3).jpeg" alt="Foto dibujo2" class="hover-img">
            </div>
            <div class="description">
                <h2>Clases de Dibujo y Pintura</h2>
                <p>Viernes de 10:00 a 11:30</p>
                <p>30€/mes</p>
                <a href="bonos.php?clase=dibujo_pintura" class="bonus-button">Bonos</a>
            </div>
        </div>
        <div class="product">
            <div class="img-container">
                <img src="assets/img/clases/clase.jpeg" alt="Clase Restauracion" class="default-img">
                <img src="ruta/a/hover2.jpg" alt="Clase Restauracion" class="hover-img">
            </div>
            <div class="description">
                <h2>Clases de Restauración</h2>
                <p>Los jueves con tres opciones de horario:</p>
                <p>09:30 a 12:00 / 12:00 a 14:30 / 17:30 a 20:00</p>
                <p>45€/mes</p>
                <a href="bonos.php?clase=restauracion" class="bonus-button">Bonos</a>
                 </div>
        </div>
        <div class="product">
            <div class="img-container">
                <img src="assets/img/Designer (3).jpeg" alt="Clase Arte" class="default-img">
                <img src="assets/img/clases/Designer (4).jpeg" alt="Clase Arte" class="hover-img">
            </div>
            <div class="description">
                <h2>Clases de Arte y Creatividad para niños</h2>
                <p>Viernes de 17:30 a 19:00 y Sábado de 12:00 a 13:30</p>
                <p>30€/mes</p>
                <a href="bonos.php?clase=arte_creatividad_ninos" class="bonus-button">Bonos</a>
             </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
