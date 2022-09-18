<!DOCTYPE html>
{assign var='tipo' value=$tipo|default:null}
{assign var='userlogged' value=$error|default:null}
{assign var='citta' value=$citta|default:null}
{assign var='nomeEvento' value=$nomeEvento|default:null}
{assign var='nomeLocale' value=$nomeLocale|default:null}
{assign var='locali' value=$locali|default:null}
{assign var='categoria' value=$categoria|default:null}
{assign var='data' value=$data|default:null}
{assign var='array' value=$array|default:null}
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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

<body>
<header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

    </div>
</header>

<main id="main">

    <!-- ======= Blog Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-weight: bold">Risultati per:</h2>
                <ul>
                    {if $tipo=="Locali"}
                        {if isset($nomeLocale)}
                            <li>{$nomeLocale}</li>
                        {/if}
                        {if isset($citta)}
                            <li>{$citta}</li>
                        {/if}
                        {if isset($categoria)}
                            <li>{$categoria}</li>
                        {/if}
                    {else}
                        {if isset($citta)}
                            <li>{$citta}</li>
                        {/if}
                        {if isset($nomeLocale)}
                            <li>{$nomeLocale}</li>
                        {/if}
                        {if isset($nomeEvento)}
                            <li>{$nomeEvento}</li>
                        {/if}
                        {if isset($data)}
                            <li>{$data}</li>
                        {/if}
                    {/if}
                </ul>
            </div>
        </div>
    </section>
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <article class="entry">
                    {if isset($array)}
                        {if $tipo eq "Locali"}
                            {foreach $array as $locale}
                                <div class="entry-img">
                                    <img class="photo"
                                         src="data:{$locale->getImg()->getType()};base64,{$locale->getImg()->getImmagine()}"
                                         alt="immagine locale" width="200px" height="100px" style="border-radius:5px">
                                </div>
                                <h2 class="entry-title">
                                    <a href="/Ricerca/dettagliLocale/{$locale->getId()}">{$locale->getNome()}</a>
                                </h2>
                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-person"></i>
                                            {$locale->getProprietario()->getUsername()}</li>
                                        <li class="d-flex align-items-center"><i class="fas fa-map-marker-alt"></i>
                                            {$locale->getLocalizzazione()->getIndirizzo()}
                                            ,{$locale->getLocalizzazione()->getNumCivico()}
                                            , {$locale->getLocalizzazione()->getCitta()}
                                        </li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <p>
                                        {$locale->getDescrizione()}
                                    </p>
                                </div>
                            {/foreach}
                        {else}
                            {foreach $array as $evento}
                                <div class="entry-img">
                                    <img class="photo"
                                         src="data:{$evento->getImg()->getType()};base64,{$evento->getImg()->getImmagine()}"
                                         alt="immagine evento" width="200px" height="100px" style="border-radius:5px">
                                </div>
                                <h2 class="entry-title">
                                    {$evento->getNome()}
                                </h2>
                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-person"></i>
                                            {$locali[{$evento@iteration-1}]->getNome()}</li>
                                        <li class="d-flex align-items-center"><i class="fas fa-map-marker-alt"></i>
                                            {$locali[{$evento@iteration-1}]->getLocalizzazione()->getIndirizzo()}
                                            ,{$locali[{$evento@iteration-1}]->getLocalizzazione()->getNumCivico()}
                                            , {$locali[{$evento@iteration-1}]->getLocalizzazione()->getCitta()}
                                        </li>
                                        <li class="d-flex align-items-center"><i class="bi bi-pin"></i>
                                            {$evento->getData()}</li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <p>
                                        {$evento->getDescrizione()}
                                    </p>
                                    <div class="read-more">
                                        <a href="/Ricerca/dettagliLocale/{$locali[{$evento@iteration-1}]->getId()}">
                                            Visita la pagina del Locale <i class="fas fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                                <br>
                            {/foreach}
                        {/if}
                    {/if}
                    {if !isset($array)}
                        <h2 class="accordion-body">La ricerca non ha prodotto alcun risultato. Riprova.</h2>
                    {/if}
                </article>
            </div>
        </div>
    </section>
</main>

<footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>Moderna</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
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
<script src="/template/js/main.js"></script>

</body>

</html>