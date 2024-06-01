<?php
include 'db_connection.php';
session_start();

if (count($_COOKIE) == 0) {
    setcookie('test', 'test', time() + 3600, '/');
    if (count($_COOKIE) == 0) {
        $cookiesEnabled = false;
    } else {
        setcookie('test', '', time() - 3600, '/'); // Eliminar cookie de prueba
        $cookiesEnabled = true;
    }
} else {
    $cookiesEnabled = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>ResNou</title>
    <link rel="icon" type="image/png" href="assets/img/LogoRESNOUNegroC.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/main.css">

    <style>
        .cookie-consent {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }
        .cookie-consent p {
            margin: 0;
        }
        .cookie-button {
            background-color: #ff6f61;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .cookie-button:hover {
            background-color: #e65b50;
        }
    </style>
</head>

<body>
    <div class="container">
    <?php include 'header.php'; ?>

       <!-- Mensaje de advertencia de cookies -->
       <?php if (!$cookiesEnabled): ?>
        <div id="cookieWarning" class="cookie-warning">
            <p>Las cookies no están habilitadas en su navegador. Por favor, habilite las cookies para continuar utilizando este sitio web.</p>
        </div>
        <?php else: ?>
        <!-- Popup de aceptación de cookies -->
        <div id="cookieConsent" class="cookie-consent">
            <div class="cookie-message">
                <p>Utilizamos cookies para mejorar su experiencia en nuestro sitio web. Al continuar navegando, usted acepta nuestro uso de cookies. 
                <a href="cookie-policy.html" target="_blank">Más información</a>.</p>
                <button id="acceptCookies" class="cookie-button">Aceptar</button>
            </div>
        </div>
        <?php endif; ?>
   
        <section class="hero w-120">
            <div class="hero__content">
                <div class="hero__text">
                    <h1 class="hero__title">Convierte lo que tienes en lo que quieres</h1>
                    <p class="hero__description">
                        Restauramos todas tus antigüedades, muebles y objetos. ¿Qué cuentas cuando enseñas tu casa? Llénala de objetos especiales, con historia, con tu identidad y tus valores. 
                        La velada será inolvidable.
                    </p>
                    <a href="contacto.php" class="btn btn__hero">Reservar una cita</a>
                </div>
                <div class="hero__img">
                    <img src="assets/img/home1.png" alt="">
                </div>
            </div>
        </section>
        
        <section class="opportunities">
            <div class="opportunities__img">
<!-- <img src="assets/img/Designer__6_-removebg-preview.png" alt="Muebles"> -->
</div>
            <div class="opportunities__content w-105">
                <div class="opportunities__head">
                    <h2 class="opportunities__title">Nuevas oportunidades para tus muebles y antigüedades</h2>
                    <p class="opportunities__description">Trae tus muebles y dales una segunda vida.</p>
                </div>
                <div class="opportunities__body">
                    <div class="opportunity">
                        <img src="assets/img/phone_in_talk_FILL0_wght400_GRAD0_opsz24.svg" alt="Icon" class="opportunity__icon">
                        <h4 class="opportunity__title">Contacta con nosotros y pide un presupuesto</h4>
                        <p class="opportunity__description"> Dinos tu idea y le daremos forma.
                        </p>
                    </div>

                    <div class="opportunity active">
                        <img src="assets/img/view_timeline_24dp_FILL0_wght400_GRAD0_opsz24.svg" alt="Icon" class="opportunity__icon">
                        <h4 class="opportunity__title">Ten los detalles del proceso de restauración</h4>
                        <p class="opportunity__description">
                        Una vez que la idea se ha convertido en un proyecto, el proceso de restauración comienza.
                        </p>
                    </div>
                    <div class="opportunity">
                        <img src="assets/img/check_small_24dp_FILL0_wght400_GRAD0_opsz24.svg" alt="Icon" class="opportunity__icon">
                        <h4 class="opportunity__title">Mueble restaurado
                        </h4>
                        <p class="opportunity__description">
                            Contactaremos contigo cuando el mueble esté listo.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="invest  w-105">
            <div class="invest__content">
                <div class="invest__head">
                    <h2 class="invest__title">Restauración de antigüedades y talleres artísticos</h2>
                    <p class="invest__description">Restaura. Renueva. Revive. Reinventa</p>
                </div>
                <div class="invest__body">
                    <div class="invest__item">
                        <div class="invest__item__head">
                            <h5 class="invest__item__subtitle">Descubre nuestro proyectos:</h5>
                        </div>
                        <div class="invest__item__body">
                            <h4 class="invest__item__title">Restauración de muebles</h4>
                            <p class="invest__item_description">
                                Pide tu presupuesto y  nosotros te ayudamos a elegir la forma que mejor se adapte a tus necesidades.
                            </p>
                        </div>
                        <div class="invest__item__footer">
                            <a href="#" class="btn btn__invest">Ver Galería</a>
                        </div>
                    </div>
                    <div class="invest__item">
                        <div class="invest__item__head">
                            <h5 class="invest__item__subtitle">Descubre nuestras clases</h5>
                        </div>
                        <div class="invest__item__body">
                            <h4 class="invest__item__title">Clases Artísticas
                            </h4>
                            <p class="invest__item_description">
                                Compra los bonos que más se adapten a ti ,te permitirán asistir a las clases de arte y de restauración.
                            </p>
                        </div>
                        <div class="invest__item__footer">
                            <a href="#" class="btn btn__invest">Ver clases</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-is-works w-120">
            <div class="works__content">
                <div class="works__head">
                    <h2 class="works__title">Cómo reservar un bono de clases</h2>
                    <p class="works__description">
                        Selecciona el bono que más te interese y elige los días según tu disponibilidad.
                    </p>
                </div>
                <div class="works__body">
                    <ul class="form_progressbar">
                        <li class="progressbar__step active" data-step="1">01</li>
                        <li class="progressbar__step" data-step="2">02</li>
                        <li class="progressbar__step" data-step="3">03</li>
                        <li class="progressbar__step" data-step="4">04</li>
                    </ul>
                </div>
                <div class="works__footer">
                    <div class="works__step__content first_step">
                        <h3 class="works__step_title"> Selecciona el apartado de Reservas.</h3>
                        <p class="works__step_description">
                            Te llevará a la página principal donde podrás ver todos los bonos disponibles.
                        </p>
                    </div>
                    <div class="works__step__content">
                        <h3 class="works__step_title">  Selecciona tu bono y completa el formulario de reserva.</h3>
                        <p class="works__step_description">
                            Haz clic en "Reservar Bono".
                        </p>
                    </div>
                    <div class="works__step__content">
                        <h3 class="works__step_title">Dispondrás de la opción de comprar bono.</h3>
                        <p class="works__step_description">
                            Si decides adquirirlo, sigue las instrucciones para finalizar la compra. Tenemos varias formas de compra.
                        </p>
                    </div>
                    <div class="works__step__content">
                        <h3 class="works__step_title"> Reservado y completado.</h3>
                        <p class="works__step_description">
                            Una vez realizada la compra, recibirás una confirmación por correo electrónico con los detalles de tu compra.
                        </p>
                    </div>
                </div>
            </div>


        </section>

        <section class="testimonials">
            <div class="testimonials__content">
                <div class="testimonials__head w-105">
                    <img src="assets/img/quote.svg" alt="Quote" class="testimonials__quote">
                    <h2 class="testimonials__title">Mejoramos cada día con vuestras opiniones</h2>
                </div>
                <div class="testimonials__body">
                    <div class="testimonials__list">
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Paula García</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                            “ Cuando pensé en renovar el baúl de mis abuelos cómo recuerdo, quería que fuera muy especial, estuve buscando en varias webs, 
                            y cuanto encontré a Res Nou Art lo tuve claro, les escribí un correo con todo lo que quería hacer y mis dudas,para mi sorpresa 
                            fueron encantadores contestaron todas mis dudas y entendieron a la perfección lo que quería. “ 
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Antonio Rodriguez</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Trabajar con Eva es presenciar la pasión convertida en arte. Su amor por la restauración se refleja en el esmero 
                                que pone en cada trabajo.Desde el primer contacto hasta la entrega final, su compromiso con la excelencia es evidente.
                                 No solo restaura muebles, si no también les devuelve el alma “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Carolina Mira</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ El trabajo realizado por Res Nou ha sido de 10. Eva se ha preocupado en todo momento y nos ha aconsejado y ayudado.
                                 Sin duda volveré a acudir a ella cuando tengo que volver a restaurar“
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Pilar Griñó</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Me han reformado una cómoda y el resultado me encanta. Hemos estado en contacto todo el tiempo según avanzaba el trabajo 
                                para pedirme opinión. Los cajones no abrían bien y los han reparado y forrado con papel por dentro. Estoy muy contenta. Lo recomiendo. “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Raimundo Murcia</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Muy buena profesional y trato excelente, gracias por hacer posible el recuperar este recuerdo tan especial para mi. “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Cristina Bellon</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Eva y su equipo son grandes profesionales y todas unas artistas. Todo lo que pasa por sus manos se transforma dando 
                                paso a una nueva vida llena de encanto y estilo … y algo increíble y recomendable son tus talleres didácticos interactivos“
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Maria Candela</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ El trato ha sido excelente. Aunque iba con algunas dudas de cómo hacer, me ha sabido recomendar y aconsejar. 
                                Resultado maravilloso. rápido. Buen servicio y flexibilidad en el horario para la recogida. Agradecida 1000 “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Mariano Caballero</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Si tienes algo que restaurar, por muy deteriorado que esté, Eva conseguirá un resultado espectacular, toda una experta en el tema. 
                                Además imparte cursos muy variados en sus instalaciones. “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Jaime Latour</h4>
                                    <h4 class="testimonial__title">Reseña de Google</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Muy recomendable, profesionales y de mucha confianza. 
                                Conocimos Venot por las clases de pintura de mi hijo. Son grupos reducidos donde además de aprender diferentes técnicas,
                                 las relacionan con pintores y estilos artísticos. Se lo pasan en grande.“
                            </p>
                        </div>
                    </div>
                </div>
                <div class="testimonials__footer  w-105">
                    <div class="testimonials__directions">
                        <button class="btn__testimonials btn__testimonials__prev disable">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                        <button class="btn__testimonials btn__testimonials__next">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="farm-invest w-105">
            <h2 class="farm-invest__title">Nuestros <span>Bonos de Clase</span> para aprender</h2>
            <a href="#" class="btn btn__farm--invest">Reserva los bonos</a>

        </section>
        <?php include 'footer.php'; ?>

    </div>
    <script src="assets/js/main.js" type="module"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
            }

            if (getCookie('acceptCookies')) {
                document.getElementById('cookieConsent').style.display = 'none';
            } else {
                document.getElementById('cookieConsent').style.display = 'block';
            }

            document.getElementById('acceptCookies').addEventListener('click', function() {
                setCookie('acceptCookies', 'true', 365);
                document.getElementById('cookieConsent').style.display = 'none';
            });
        });
    </script>
</body>

</html>