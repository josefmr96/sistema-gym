<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gym | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="/web/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/web/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/web/css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="/web/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/web/css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="/web/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/web/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/web/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="./">Home</a></li>
                <li><a href="./nosotros">Nosotros</a></li>
                <li><a href="./clases">Clases</a></li>
                <li><a href="./servicios">Servicios</a></li>
                <li><a href="./entrenadores">Entrenadores</a></li>
                <li><a href="./contacto">Contacto</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="./index.html">
                            <img src="/web/img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                        <li><a href="./">Home</a></li>
                        <li><a href="./nosotros">Nosotros</a></li>
                        <li><a href="./clases">Clases</a></li>
                        <li><a href="./servicios">Servicios</a></li>
                        <li class="active"><a href="./entrenadores">Entrenadores</a></li>
                        <li><a href="./contacto">Contacto</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="top-option">
                        <div class="to-search search-switch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="to-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/web/img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Entrenadores</h2>
                        <div class="bt-option">
                            <a href="./">Home</a>
                            <span>Entrenadores</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Team Section Begin -->
    <section class="team-section team-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title">
                        <div class="section-title">
                            <span>Entrenadores</span>
                            <h2>Comenza a entrenar con los mejores expertos</h2>
                        </div>
                        <a href="/servicios" class="primary-btn btn-normal appoinment-btn">¡Comenzar ya!</a>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach($array_entrenadores as $entrenador)
                <div class="col-lg-4 col-sm-6">
                    <div class="ts-item set-bg" data-setbg="/images/{{ $entrenador->foto }}">
                        <div class="ts_text">
                            <h4><a href="/entrenador/{{ $entrenador->identrenador }}">{{ $entrenador->nombre }}</a></h4>
                            <span>Gym Trainer</span>
                        </div>
                    </div>
                </div>
                @endforeach
             
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Alicia Moreau de Justo 1150<br>
                            Piso 3 Oficina 306-A<br/>
                            Buenos Aires</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li>5273-8922</li>
                            <li>+54 11 3407-5725</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <i class="fa fa-envelope"></i>
                        <p>info@moveonfit.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fs-about">
                        <div class="fa-logo">
                            <a href="#"><img src="/web/img/logo.png" alt=""></a>
                        </div>
                        <p>Si no te esfuerzas hasta el máximo,<br> 
                            ¿cómo sabrás donde está tu límite?</p>
                        <div class="fa-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa  fa-envelope-o"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Enlaces útiles</h4>
                        <ul>
                            <li><a href="#">Acerca de</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Clases</a></li>
                            <li><a href="#">Contaco</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Soporte</h4>
                        <ul>
                            <li><a href="#">Iniciar sesión</a></li>
                            <li><a href="#">Mi Cuenta</a></li>
                            <li><a href="#">Suscribirse</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Consejos y guías</h4>
                        <div class="fw-recent">
                            <h6><a href="#">La aptitud física puede ayudar a prevenir la depresión y la ansiedad</a></h6>
                            <ul>
                                <li>3 min de lectura</li>
                                <li>20 Comentarios</li>
                            </ul>
                        </div>
                        <div class="fw-recent">
                            <h6><a href="#">Fitness: el mejor ejercicio para perder grasa abdominal y tonificarse ...</a></h6>
                            <ul>
                                <li>3 min de lectura</li>
                                <li>20 Comentarios</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos los derechos reservados | DePCsuite <i class="fa fa-heart" aria-hidden="true"></i>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="/web/js/jquery-3.3.1.min.js"></script>
    <script src="/web/js/bootstrap.min.js"></script>
    <script src="/web/js/jquery.magnific-popup.min.js"></script>
    <script src="/web/js/masonry.pkgd.min.js"></script>
    <script src="/web/js/jquery.barfiller.js"></script>
    <script src="/web/js/jquery.slicknav.js"></script>
    <script src="/web/js/owl.carousel.min.js"></script>
    <script src="/web/js/main.js"></script>


</body>

</html>