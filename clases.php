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

.class-offer { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
    gap: 20px; 
    padding: 50px 0; 
    border-bottom: 1px solid #ccc; 
} 

.class-offer h2 { 
    margin-bottom: 20px; 
    font-size: 24px; 
    align-items: center; 
    text-align: center; 
} 

.class-details { 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    text-align: center; 
} 

.class-details img { 
    max-width: 15%; 
    margin-bottom: 20px; 
} 

.details { 
    margin-right: 0; 
} 

.details p { 
    margin-bottom: 10px; 
} 

.btn { 
    display: inline-block; 
    padding: 10px 20px; 
    background-color: #007bff; 
    color: #fff; 
    text-decoration: none; 
    border-radius: 5px; 
} 

.btn:hover { 
    background-color: #0056b3; 
} 

@media screen and (max-width: 768px) { 
    .class-details { 
        flex-direction: column; 
    } 
    .details { 
        margin-right: 0; 
    } 
}

        </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="class-offer">
        <div class="container">
            <h2>Clases de Dibujo y Pintura</h2>
            <div class="class-details">
                <img src="assets/img/Designer (3).jpeg" alt="Clases de Dibujo y Pintura">
                <div class="details">
                    <p><strong>Horario:</strong> Viernes, 10:00 - 11:30</p>
                    <p><strong>Precio:</strong> 30€/mes</p>
                    <a href="#" class="btn">Bono</a>
                </div>
            </div>
        </div>
    </section>

    <section class="class-offer">
        <div class="container">
            <h2>Clases de Restauración</h2>
            <div class="class-details">
                <img src="assets/img/clases/clase.jpeg" alt="Clases de Restauración">
                <div class="details">
                    <p><strong>Horario:</strong> Jueves, 17:00 - 19:00</p>
                    <p><strong>Precio:</strong> $60 por sesión</p>
                    <a href="#" class="btn">Bono</a>
                </div>
            </div>
        </div>
    </section>

    <section class="class-offer">
        <div class="container">
            <h2>Clases de Arte y Creatividad para Niños</h2>
            <div class="class-details">
                <img src="assets/img/clases/Designer (4).jpeg" alt="Clases de Arte y Creatividad para Niños">
                <div class="details">
                    <p><strong>Horario:</strong> Sábados, 10:00 - 12:00</p>
                    <p><strong>Precio:</strong> $40 por sesión</p>
                    <a href="#" class="btn">Bono</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>
