<!DOCTYPE html>
{assign var='userlogged' value=$userlogged|default:'nouser'}
{assign var='tipo' value=$tipo|default:'nouser'}
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>FacceBeve</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/Smarty/template/assets/img/favicon.png" rel="icon">
    <link href="/Smarty/template/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Vendor CSS Files -->
    <link href="/Smarty/template/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/Smarty/template/assets/css/style.css" rel="stylesheet">

    <!-- JavaScript-->
    <script type="text/javascript">
        function setList() {    //In input le categorie
            var x = document.getElementById("tipo");
            var y = x.value;
            var z,q;
            q = document.getElementById(y);
            if(y==='Locali'){
                q.style.display = "flex";
                z = document.getElementById("Eventi");
                z.style.display = "none";

            }else{
                q.style.display = "inline-block";
                z = document.getElementById("Locali");
                z.style.display = "none";
            }
        }

        /** function defaultView() {
            var x = document.getElementById("Eventi");
            x.style.display = "none";
            var y = document.getElementById("Locali");
            y.style.display = "flex";
        };**/


    </script>




</head>
<body> <!--onload="defaultView()"-->
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="index.html"><img src="/Smarty/template/assets/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

        {if $userlogged=='nouser'}
            <div class="sign">
                <a href="login.html">Accedi</a>
                <a href="registrazioneUtente.html">Registrati</a>
                <a href="registrazioneProprietario.html">Vuoi pubblicizzare il tuo locale?</a>
            </div>
        {elseif $tipo=='EUtente'}
            <div class="sign">
                <a href="areaPersonaleUtente.html">Il tuo profilo personale</a>
                <a href="areaPersonaleUtente.html">I tuoi locali preferiti</a> <!--Come si fa?-->
                <a href="registrazioneProprietario.html">Logout</a> <!--Qui direi una semplice action  -->
            </div>
        {elseif $tipo=='EProprietario'}
            <div class="sign">
                <a href="areaPersonaleProprietario.html">Il tuo profilo personale</a>
                <a href="areaPersonaleUtente.html">I tuoi locali gestiti</a> <!--Quasi quasi ne farei solo 2 di bottoni-->
                <a href="registrazioneProprietario.html">Logout</a> <!--Qui direi una semplice action  -->
            </div>
        {/if}

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex justify-content-center align-items-center" >
    <div id="heroCarousel" class="container carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="carousel-item active">
            {if $userlogged!='nouser'}
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" >Puoi ricercare...</h4>
                    <select name="tipo" id="tipo" onChange="setList()">
                        <option  selected value="Locali">Locali</option>
                        <option value="Eventi">Eventi</option>
                    </select>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Locali" style="display: flex;justify-content: center;">
                    <form class="Search"  action="risultatiRicerca.html">
                        <input type="text" placeholder="Inserisci la città" name="citta">
                        <input type="text" placeholder="Inserisci il nome" name="nomeLocale">
                        <select name="categorie" style="border-radius:6px;">
                            <option>Scegli il tipo</option>
                            <option value="bar">Bar</option>
                            <option value="pub">Pub</option>
                        </select>
                        <button type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Eventi" style="display: none;justify-content: center;" >
                    <form class="Search" action="risultatiRicerca.html">
                        <input type="text" placeholder="Inserisci la città" name="citta">
                        <input type="text" placeholder="Inserisci il nome del Locale" name="nomeLocale">
                        <input type="text" placeholder="Inserisci il nome del Evento" name="nomeEvento">
                        <input type="date" placeholder="Inserisci la data del Evento" name="dataEvento">
                        <button type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            {else}
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0">Trova i locali della tua città</h4>
                </div>

                <div class="ricerca animate__animated animate__fadeInDown" style="display: flex;justify-content: center;">
                    <form class="Search"  action="risultatiRicerca.html">
                        <input type="text" placeholder="Inserisci la città" name="citta">
                        <input type="text" placeholder="Inserisci il nome" name="nomeLocale">
                        <select name="categorie" style="border-radius:6px;">
                            <option>Scegli il tipo</option>
                            <option value="bar">Bar</option>
                            <option value="pub">Pub</option>
                        </select>
                        <button type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>

            {/if}
        </div>

    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= Services Section ======= -->
    <section class="services">
        <div class="container">

            <div class="row">
                <h2>Ecco i TOP 4 locali in Italia:</h2>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="icon-box icon-box-pink">
                        <div class="icon"><i class="bx bxl-dribbble"></i></div>
                        <h4 class="title"><a href="">Lorem Ipsum</a></h4>
                        <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias
                            excepturi sint occaecati cupiditate non provident</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box icon-box-cyan">
                        <div class="icon"><i class="bx bx-file"></i></div>
                        <h4 class="title"><a href="">Sed ut perspiciatis</a></h4>
                        <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                            dolore eu fugiat nulla pariatur</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box icon-box-green">
                        <div class="icon"><i class="bx bx-tachometer"></i></div>
                        <h4 class="title"><a href="">Magni Dolores</a></h4>
                        <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                            deserunt mollit anim id est laborum</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box icon-box-blue">
                        <div class="icon"><i class="bx bx-world"></i></div>
                        <h4 class="title"><a href="">Nemo Enim</a></h4>
                        <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                            praesentium voluptatum deleniti atque</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Services Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
    <!--
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Contact Us</h4>
                        <p>
                            A108 Adam Street <br>
                            New York, NY 535022<br>
                            United States <br><br>
                            <strong>Phone:</strong> +1 5589 55488 55<br>
                            <strong>Email:</strong> info@example.com<br>
                        </p>

                    </div>

                    <div class="col-lg-3 col-md-6 footer-info">
                        <h3>About Moderna</h3>
                        <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita
                            valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    -->
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>Moderna</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="/Smarty/template/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="/Smarty/template/assets/vendor/aos/aos.js"></script>
<script src="/Smarty/template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/Smarty/template/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/Smarty/template/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/Smarty/template/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/Smarty/template/assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="/Smarty/template/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/Smarty/template/assets/js/main.js"></script>

</body>

</html>