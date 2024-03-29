<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>FacceBeve</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Favicons -->
    <link href="/FacceBeve/template/img/favicon.png" rel="icon">
    <link href="/FacceBeve/template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Vendor CSS Files -->
    <link href="/FacceBeve/template/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/aos/aos.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/FacceBeve/template/css/style.css" rel="stylesheet">
</head>

<body> <!--onload="setList()"-->

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/FacceBeve/Ricerca/mostraHome"><img src="/FacceBeve/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

        {if $tipo=='nouser'}
            <div class="sign">
                <a href="/FacceBeve/Accesso/formLogin">Accedi</a>
                <a href="/FacceBeve/Accesso/formRegistrazioneUtente">Registrati</a>
                <a href="/FacceBeve/Accesso/formRegistrazioneProprietario">Vuoi pubblicizzare il tuo locale?</a>
            </div>
        {elseif $tipo=='EUtente'}
            <div class="sign">
                <a href="/FacceBeve/Profilo/mostraProfilo">Area Personale Utente</a>
                <a href="/FacceBeve/Accesso/logout">Logout</a>
            </div>
        {elseif $tipo=='EProprietario'}
            <div class="sign">
                <a href="/FacceBeve/Profilo/mostraProfilo">Area Personale Proprietario</a>
                <a href="/FacceBeve/Accesso/logout">Logout</a>
            </div>
        {/if}

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex justify-content-center align-items-center">
    <div id="heroCarousel" class="container carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-item active">
            {if $tipo!='nouser'}
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine
                        e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" style="color:white">Puoi ricercare...</h4>
                    <select name="tipo" id="tipo" onchange="setList()" style="border-radius:10px;">
                        <option selected value="Locali">Locali</option>
                        <option value="Eventi">Eventi</option>
                    </select>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Locali"
                     style="display: flex;justify-content: center;">
                    <form class="Search" id="ricercaLocali1" onsubmit="return validateResearchForm(1)"
                          action="/FacceBeve/Ricerca/ricerca" method="POST">
                        <input class="homeinput" type="hidden" value="x" name="checkLocale" id="checkLocale">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta1">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome" name="nomeLocale1">
                        <select form="ricercaLocali1" name="categorie1" id="categorie1"
                                style="border-radius:7px; height: 50px  ;">
                            <option>--Scegli il tipo--</option>
                            {if !empty($categorie)}
                                {foreach $categorie as $c}
                                    <option type="radio" name="genere"
                                            value="{$c->getGenere()}"> {$c->getGenere()}</option>
                                {/foreach}
                            {/if}
                        </select>
                        <button class="input" type="submit" style="border-radius:10px;"><i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Eventi"
                     style="display: none;justify-content: center;">
                    <form class="Search" id="ricercaEventi" onsubmit="return validateResearchForm(1)"
                          action="/FacceBeve/Ricerca/ricerca" method="POST">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta2">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome del Locale"
                               name="nomeLocaleEvento">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome del Evento"
                               name="nomeEvento">
                        <input class="homeinput" type="date" placeholder="Inserisci la data del Evento"
                               name="dataEvento">
                        <button type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            {else}
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine
                        e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" style="color:white;">Trova i locali della tua città</h4>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown"
                     style="display: flex;justify-content: center;">
                    <form class="Search" name="ricercaLocali0" id="ricercaLocali0" action="/FacceBeve/Ricerca/ricerca"
                          method="POST" onsubmit="return validateResearchForm(0)">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome" name="nomeLocale">
                        <select name="categorie" id="categorie" form="ricercaLocali0"
                                style="border-radius:7px; height: 50px ">
                            <option>--Scegli il tipo--</option>
                            {if !empty($categorie)}
                                {foreach $categorie as $c}
                                    <option type="radio" name="genere"
                                            value="{$c->getGenere()}"> {$c->getGenere()}</option>
                                {/foreach}
                            {/if}
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
                {$i=0}
                {if !empty($topLocali)}
                    {$i=0}
                    {foreach $topLocali as $locale}
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                            <div class="icon-box icon-box-pink">
                                <a href="/FacceBeve/Ricerca/dettagliLocale/{$locale->getId()}"><h3
                                            style="font-weight: bold">{$locale->getNome()}</h3></a>
                                <p style="font-weight: bold;">Voto: {$valutazione[$i]}/5</p>
                                <p class="description">{$locale->getDescrizione()}</p>
                            </div>
                        </div>
                        {$i=$i+1}
                    {/foreach}
                {else}
                    <p>Non ci sono locali recensiti</p>
                {/if}
            </div>

            {if isset($eventiUtente)}
                <div class="row">
                    <h2>Ecco gli eventi in arrivo dei tuoi locali preferiti:</h2>
                    {if !empty($eventiUtente)}
                        {foreach $eventiUtente as $evento}
                            {$i=0}
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                                <div class="icon-box icon-box-pink">
                                    <a href="/FacceBeve/Ricerca/dettagliLocale/{$localiEventiUtente[{$evento@iteration-1}]}"><h3
                                                style="font-weight: bold">{$evento->getNome()}</h3></a>
                                    <p style="font-weight: bold;">{$evento->getData()}</p>
                                    <p class="description">{$evento->getDescrizione()}</p>
                                </div>
                            </div>
                        {/foreach}
                    {else}
                        <p>Non ci sono eventi tra i tuoi locali preferiti</p>
                    {/if}
                </div>
            {/if}


        </div>
    </section><!-- End Services Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" data-aos-easing="ease-in-out" data-aos-duration="500">
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
<script src="/FacceBeve/template/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="/FacceBeve/template/vendor/aos/aos.js"></script>
<script src="/FacceBeve/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/FacceBeve/template/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/FacceBeve/template/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/FacceBeve/template/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/FacceBeve/template/vendor/waypoints/noframework.waypoints.js"></script>
<script src="/FacceBeve/template/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/FacceBeve/template/js/main.js"></script>

</body>

</html>