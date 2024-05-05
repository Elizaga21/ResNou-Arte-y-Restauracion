

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/gallery.css"> 
    <style>

.services {
    padding: 80px 0;
}

.section__title {
    color: #333333;
    font-size: 32px;
    margin-bottom: 40px;
}

.service__title {
    color: #333333;
    font-size: 24px;
    margin-bottom: 10px;
}

.service__description {
    color: #666666;
    margin-bottom: 20px;
}

.service__more-info {
    color: #666666;
}
        /* Custom CSS */
        .service-image {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<section class="services">
    <div class="container">
        <h2 class="section__title">Nuestros servicios</h2>
        <div class="service">
            <h3 class="service__title">Restauración de antigüedades y bienes artísticos</h3>
            <p class="service__description">Uno de nuestros servicios más destacados es el relacionado con la restauración de antigüedades y bienes artísticos. Te ayudamos a poner en valor tu patrimonio, tu historia.</p>
            <p class="service__more-info">En Venot nos dedicamos a la restauración de toda clase de antigüedades; madera, metal, escultura, pintura, un largo etcétera. Estamos en constante actualización, formación e investigación con el fin de garantizarte el mejor resultado.</p>
        </div>
        <div class="service">
            <h3 class="service__title">Decoración y rehabilitación de muebles</h3>
            <p class="service__description">Si tus gustos han cambiado y no quieres comprar muebles nuevos. Si buscas una pieza llamativa que marque la diferencia y destaque en tu decoración. Si quieres crear un espacio único alejado de lo standard. Contrata este servicio.</p>
        </div>
        <div class="service">
            <h3 class="service__title">Clases de arte para niños</h3>
            <p class="service__description">"Si los niños se interesan por el arte, el mundo camina" - Matilde Pérez, artista chilena. Todos los sábados por la mañana puedes ofrecer a tu hijo la oportunidad para desarrollar su creatividad.</p>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>