<!DOCTYPE html>
{assign var='tipo' value=$tipo|default:'nouser'}
{assign var='genere_cat' value=$genere_cat}
{assign var='locali' value=$locali}
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>FacceBeve</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Favicons -->
    <link href="/template/img/favicon.png" rel="icon">
    <link href="/template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Vendor CSS Files -->
    <link href="/template/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="/template/vendor/aos/aos.css" rel="stylesheet">
    <link href="/template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/template/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/template/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/template/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/template/css/style.css" rel="stylesheet">
</head>

<body> <!--onload="defaultView()"-->

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

        {if $tipo=='nouser'}
            <div class="sign">
                <a href="/Accesso/formLogin">Accedi</a>
                <a href="/Accesso/formRegistrazioneUtente">Registrati</a>
                <a href="/Accesso/formRegistrazioneProprietario">Vuoi pubblicizzare il tuo locale?</a>
            </div>
        {elseif $tipo=='EUtente'}
            <div class="sign">
                <a href="/Profilo/mostraProfilo">Area Personale Utente</a> <!--DEBUG ZIO PERA-->
                <a href="/Accesso/logout">Logout</a>
            </div>
        {elseif $tipo=='EProprietario'}
            <div class="sign">
                <a href="/Profilo/mostraProfilo">Area Personale Ciccarelli</a>
                <a href="/Accesso/logout">Logout</a>
            </div>
        {/if}

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex justify-content-center align-items-center" >
    <div id="heroCarousel" class="container carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="carousel-item active">
            {if $tipo!='nouser'}
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" style="color:white">Puoi ricercare...</h4>
                    <select onchange=setList() method=post name="tipo" id="tipo" style="border-radius:10px;">
                        <option selected value="Locali">Locali</option>
                        <option value="Eventi">Eventi</option>
                    </select>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Locali" style="display: flex;justify-content: center;">
                    <form class="Search" name="ricercaLocali1" onsubmit="return validateResearchForm(1)"  action="/Ricerca/ricerca" method="POST">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta1">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome" name="nomeLocale1">
                        <select  name="categorie1" style="border-radius:7px; height: 50px  ;">
                            <option>--Scegli il tipo--</option>
                            {if !empty($genere_cat)}
                                {foreach $genere_cat as $genere}
                                    <option type="radio" name="genere" value="{$genere}"> {$genere}</option>
                                {/foreach}
                            {/if}
                        </select>
                        <button class="input" type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Eventi" style="display: none;justify-content: center;" >
                    <form class="Search"  name="ricercaEventi" onsubmit="return validateResearchForm(1)"  action="/Ricerca/ricerca" method="POST">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome del Locale" name="nomeLocale">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome del Evento" name="nomeEvento">
                        <input type="date" placeholder="Inserisci la data del Evento" name="dataEvento">
                        <button type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            {else}
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" style="color:white;">Trova i locali della tua città</h4>
                </div>

                <div class="ricerca animate__animated animate__fadeInDown" style="display: flex;justify-content: center;">
                    <form class="Search" name="ricercaLocali0" action="/Ricerca/ricerca" method="POST" onsubmit="return validateResearchForm(0)">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome" name="nomeLocale">
                        <select name="categorie" style="border-radius:7px; height: 50px ">
                            <option>--Scegli il tipo--</option>
                            {if !empty($genere_cat)}
                                {foreach $genere_cat as $genere}
                                    <option type="radio" name="genere" value="{$genere}"> {$genere}</option>
                                {/foreach}
                            {/if}
                        </select>
                        <button type="submit" style="border-radius:7px; height: 50px"><i class="fa fa-search"></i></button>
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
                {if !empty($locali )}
                    {foreach $locali as $locale}
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up">
                            <div class="icon-box icon-box-pink">
                                <h4 class="title"><a href="">{$locale.nome}</a></h4>
                                <p class="description">{$locale.descrizione}</p>
                            </div>
                        </div>
                    {/foreach}
                {else}
                    <p>Non ci sono locali</p>
                {/if}

            </div>
            <!--
            <div class="row">
                <h2>Eventi più vicini ad oggi:</h2>
                {foreach $locali as $locale}
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up">
                        <div class="icon-box icon-box-pink">
                            <h4 class="title"><a href="">{$locale.nome}</a></h4>
                            <p class="description">{$locale.descrizione}</p>
                        </div>
                    </div>
                {/foreach}-->
            </div>

        </div>
    </section><!-- End Services Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
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
<script src="/template/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="/template/vendor/aos/aos.js"></script>
<script src="/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/template/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/template/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/template/vendor/waypoints/noframework.waypoints.js"></script>
<script src="/template/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script type="text/javascript" src="/template/js/main.js"></script>

</body>

</html>