<?php
include 'db_connection.php';
session_start();


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
</head>

<body>
    <div class="container">
    <?php include 'header.php'; ?>
   
        <section class="hero w-120">
            <div class="hero__content">
                <div class="hero__text">
                    <h1 class="hero__title">Convierte lo que tienes en lo que quieres</h1>
                    <p class="hero__description">
                        Restauramos todas tus antigüedades, muebles y objetos. ¿Qué cuentas cuando enseñas tu casa? Llénala de objetos especiales, con historia, con tu identidad y tus valores. 
                        La velada será inolvidable.
                    </p>
                    <a href="#" class="btn btn__hero">Reservar una cita</a>
                </div>
                <div class="hero__img">
                    <img src="assets/img/home1.png" alt="">
                </div>
            </div>
        </section>
        
        <section class="opportunities">
            <div class="opportunities__img">
                <img src="assets/img/leaf.png" alt="">
            </div>
            <div class="opportunities__content w-105">
                <div class="opportunities__head">
                    <h2 class="opportunities__title">New Opportunities</h2>
                    <p class="opportunities__description">We are the first and the only crowdfunding platform enabling you to help finance our farmers.</p>
                </div>
                <div class="opportunities__body">
                    <div class="opportunity">
                        <img src="assets/img/opportunites/opportunity-1.svg" alt="Icon" class="opportunity__icon">
                        <h4 class="opportunity__title">Connect with our farmers</h4>
                        <p class="opportunity__description">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                        </p>
                    </div>

                    <div class="opportunity active">
                        <img src="assets/img/opportunites/opportunity-2.svg" alt="Icon" class="opportunity__icon">
                        <h4 class="opportunity__title">Grow your business</h4>
                        <p class="opportunity__description">
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                        </p>
                    </div>
                    <div class="opportunity">
                        <img src="assets/img/opportunites/opportunity-3.svg" alt="Icon" class="opportunity__icon">
                        <h4 class="opportunity__title">Social Impact Invesment
                        </h4>
                        <p class="opportunity__description">
                            At vero eos et accusamus et iusto odio praesentium atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="invest  w-105">
            <div class="invest__content">
                <div class="invest__head">
                    <h2 class="invest__title">Invest on your convenience</h2>
                    <p class="invest__description">Autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
                </div>
                <div class="invest__body">
                    <div class="invest__item">
                        <div class="invest__item__head">
                            <h5 class="invest__item__subtitle">NEW FARM TODAY</h5>
                        </div>
                        <div class="invest__item__body">
                            <h4 class="invest__item__title">Short terms investment</h4>
                            <p class="invest__item_description">
                                Invest in farms that will be ready for harvest in 3-18 months
                            </p>
                        </div>
                        <div class="invest__item__footer">
                            <a href="#" class="btn btn__invest">Browse Farm</a>
                        </div>
                    </div>
                    <div class="invest__item">
                        <div class="invest__item__head">
                            <h5 class="invest__item__subtitle">FULLY FUNDED</h5>
                        </div>
                        <div class="invest__item__body">
                            <h4 class="invest__item__title">Long terms investment
                            </h4>
                            <p class="invest__item_description">
                                Consider farms that have long term investment program.
                            </p>
                        </div>
                        <div class="invest__item__footer">
                            <a href="#" class="btn btn__invest">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-is-works w-120">
            <div class="works__content">
                <div class="works__head">
                    <h2 class="works__title">How it works</h2>
                    <p class="works__description">
                        Take your pick from the supply chain and participate in agribusiness projects that are backed up not only by Zou, but also by the best land, family heritage, innovation and overall superior expertise.
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
                        <h3 class="works__step_title"> Select your farmshare and complete reservation form.</h3>
                        <p class="works__step_description">
                            Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere
                        </p>
                    </div>
                    <div class="works__step__content">
                        <h3 class="works__step_title"> Swallowed a planet!.</h3>
                        <p class="works__step_description">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda mollitia, voluptates obcaecati molestias quod velit!
                        </p>
                    </div>
                    <div class="works__step__content">
                        <h3 class="works__step_title">It's art! A statement</h3>
                        <p class="works__step_description">
                            Father Christmas. Santa Claus. Or as I've always known him: Jeff. Sorry, checking all the water in this area; there's an escaped fish. I hate yogurt. It's just stuff with bits in. Annihilate
                        </p>
                    </div>
                    <div class="works__step__content">
                        <h3 class="works__step_title"> Register</h3>
                        <p class="works__step_description">
                            It's art! A statement on modern society, 'Oh Ain't Modern Society Awful?'! I am the Doctor, and you are the Daleks! Stop talking, brain thinking. Hush. You've swallowed a planet! Sorry, checking all the water in this area; there's an escaped fish.
                        </p>
                    </div>
                </div>
            </div>


        </section>

        <section class="testimonials">
            <div class="testimonials__content">
                <div class="testimonials__head w-105">
                    <img src="assets/img/quote.svg" alt="Quote" class="testimonials__quote">
                    <h2 class="testimonials__title">What investors like you are saying about Zou</h2>
                </div>
                <div class="testimonials__body">
                    <div class="testimonials__list">
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/1.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Fernando Soler</h4>
                                    <h4 class="testimonial__title">Telecommunication Engineer</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/2.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Ilone Pickford</h4>
                                    <h4 class="testimonial__title">Head of Agrogofund Groups</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/3.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> John Doe</h4>
                                    <h4 class="testimonial__title">Software Engineer</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/2.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Ilone Pickford</h4>
                                    <h4 class="testimonial__title">Head of Agrogofund Groups</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/1.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Fernando Soler</h4>
                                    <h4 class="testimonial__title">Telecommunication Engineer</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/2.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Ilone Pickford</h4>
                                    <h4 class="testimonial__title">Head of Agrogofund Groups</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/3.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> John Doe</h4>
                                    <h4 class="testimonial__title">Software Engineer</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/2.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> Ilone Pickford</h4>
                                    <h4 class="testimonial__title">Head of Agrogofund Groups</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, “
                            </p>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial__profile">
                                <div class="testimonial__img">
                                    <img src="assets/img/testimonials/3.png" alt="Testimonial">
                                </div>
                                <div class="testimonial__info">
                                    <h4 class="testimonial__name"> John Doe</h4>
                                    <h4 class="testimonial__title">Software Engineer</h4>
                                </div>
                            </div>
                            <p class="testimonial__description">
                                “ At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium “
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
            <h2 class="farm-invest__title">The future of <span>Farm Investing</span> is Zou</h2>
            <a href="#" class="btn btn__farm--invest">Invest Now</a>

        </section>
        <?php include 'footer.php'; ?>

    </div>
    <script src="assets/js/main.js" type="module"></script>

</body>

</html>