<!DOCTYPE html>
<html lang="en">
{assign var='locale' value=$locale|default:null}
{assign var='arrayRecensioni' value=$arrayRecensioni|default:null}
{assign var='nrece' value=$nrece|default:0}
{assign var='eventi' value=$eventi|default:null}
{assign var='proprietario' value=$proprietario|default:null}
{assign var='valutazioneLocale' value=$valutazioneLocale|default:5}
{assign var='arrayRisposte' value=$arrayRisposte|default:null}
{assign var='userlogged' value=$userlogged|default:'nouser'}
<script>
    function change() {
        var elem = document.getElementById("pref");
        if (elem.value == "Aggiungi ai preferiti") elem.value = "Aggiunto!";
        else elem.value = "Aggiungi ai preferiti";
    }
</script>

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
    <link rel="stylesheet" type="text/css"
          href="https://bootswatch.com/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>

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

<!-- <body onLoad="document.forms[0].submit()">  -->
<body>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

    </div>
</header>

<main id="main">

    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="portfolio-details-slider swiper">
                        <h2>{$locale->getNome()}</h2>
                        <input onclick="change()" type="button" value="Aggiungi ai preferiti" id="pref" name="pref">
                        <div class="stelline star-rating" data-rating="4.6">
                            <div class="empty-stars">
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                        <div class="swiper-wrapper align-items-center">
                            <div class="swiper-slide">
                                <img src="data:{$locale->getImg()->getType()};base64,{$locale->getImg()->getImmagine()}"
                                     alt="Immagine locale">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="portfolio-info">
                        <h3>Informazioni sul locale</h3>
                        <ul>
                            <li><strong>Indirizzo:</strong> {$locale->getLocalizzazione()->getIndirizzo()}
                                , {$locale->getLocalizzazione()->getNumCivico()}</li>
                            <li><strong>Citt&agrave:</strong> {$locale->getLocalizzazione()->getCitta()},
                                <strong>CAP:</strong> {$locale->getLocalizzazione()->getCAP()}</li>
                            <li><strong>Categorie:</strong>
                                <ul>
                                    {foreach $locale->getCategoria() as $categoria}
                                        <li>{$categoria->getGenere()}</li>
                                    {/foreach}
                                </ul>
                            </li>
                            <li><strong>Descrizione:</strong> {$locale->getDescrizione()}</li>
                            <li><strong>Valutazione:</strong> {$valutazioneLocale}/5</li>
                        </ul>
                    </div>
                    {if !($userlogged eq 'nouser')}
                        {if isset($eventi)}
                            <div class="portfolio-details-slider swiper">
                                <br>
                                <h4><strong>Eventi organizzati:</strong></h4>
                                {foreach $eventi as $evento}
                                    <div class="portfolio-info swiper-slide">
                                        <h3>{$evento->getNome()}</h3>
                                        <ul>
                                            <li><strong>Data</strong>: {$evento->getData()}.</li>
                                            <li><strong>Descrizione</strong>: {$evento->getDescrizione()}</li>
                                             <br>
                                            <li><img class="photo"
                                                     src="data:{$evento->getImg()->getType()};base64,{$evento->getImg()->getImmagine()}"
                                                     alt="Poster evento" width="410px" height="155px"></li>
                                        </ul>
                                    </div>
                                {/foreach}
                            </div>
                        {else}
                            <div class="portfolio-details-slider swiper">
                                <p>Non ci sono ancora eventi organizzati</p>
                            </div>
                        {/if}
                    {else}
                        <div class="portfolio-info">
                            <p>Questa sezione è dedicata agli utenti iscritti, accedi o registrati per non perderti gli
                                eventi
                                dei tuoi locali preferiti </p>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </section>


    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8 entries">
                    <div class="blog-comments">
                        <h4 class="comments-count">Area Recensioni:</h4>
                        {if isset($arrayRecensioni)}
                            {if !is_array($arrayRecensioni)}
                                <div id="comment-1" class="comment">
                                    <div class="d-flex">
                                        <div class="comment-img"><img
                                                    src="data:{$arrayRecensioni->getUtente()->getImgProfilo()->getType()};base64,{$arrayRecensioni->getUtente()->getImgProfilo()->getImmagine()}"
                                                    alt="Immagine profilo utente"></div>
                                        <div>
                                            <h5>{$arrayRecensioni->getUtente()->getUsername()}<a
                                                        href="#" class="reply"><i
                                                            class="bi bi-reply-fill"></i> Risposta</a></h5>
                                            <h5>{$arrayRecensioni->getData()}</h5>
                                            <h4 style="font-weight:bold;">{$arrayRecensioni->getTitolo()}</h4>
                                            <p>{$arrayRecensioni->getDescrizione()}</p>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {foreach $arrayRecensioni as $recensione}
                                <div id="comment-1" class="comment">
                                    <div class="d-flex">
                                        <div class="comment-img"><img
                                                    src="data:{$recensione->getUtente()->getImgProfilo()->getType()};base64,{$recensione->getUtente()->getImgProfilo()->getImmagine()}"
                                                    alt="Immagine profilo utente"></div>
                                        <div>
                                            <h5>{$recensione->getUtente()->getUsername()}<a
                                                        href="#" class="reply"><i
                                                            class="bi bi-reply-fill"></i> Risposta</a></h5>
                                            <h5>{$recensione->getData()}</h5>
                                            <h2>{$recensione->getTitolo()}</h2>
                                            <p>{$recensione->getDescrizione()}</p>
                                        </div>
                                    </div>
                                </div>
                                {if isset($arrayRisposte[{$recensione@iteration - 1}])}
                                    <div id="comment-reply-1" class="comment comment-reply">
                                        <div class="d-flex">
                                            <div class="comment-img"><img
                                                        src="data:{$arrayRisposte[$i]->getProprietario()->getImgProfilo()->getType()};base64,{$arrayRisposte[$i]->getProprietario()->getImgProfilo()->getImmagine()}"
                                                        alt="Immagine profilo proprietario"></div>
                                            <div>
                                                <h5>{$arrayRisposte[{$recensione@iteration - 1}]->getProprietario()->getUsername()}</h5>
                                                <h5>{$arrayRisposte[{$recensione@iteration - 1}]->getData()}</h5>
                                                <p>{$arrayRisposte[{$recensione@iteration - 1}]->getDescrizione()}</p>
                                            </div>
                                        </div>
                                    </div>
                                {else}
                                    {if $proprietario == true}
                                        <div class="reply-form">
                                            <h4>Scrivi una recensione</h4>
                                            <form action=CGestioneRecensione/scriviRisposta method="POST"
                                                  name="Risposta"> <!--onsubmit="return validateRisposta()"-->
                                                <input type="hidden" name="idRecensione"
                                                       value="{$arrayRecensioni[$i]->getId()}"/>
                                                <div class="row">
                                                    <div class="col form-group">
                                                        <textarea name="descrizione" class="form-control"
                                                                  placeholder="Risposta" required
                                                                  title="Inserire del testo nella risposta"></textarea>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Rispondi</button>
                                            </form>
                                        </div>
                                    {/if}
                                {/if}
                            {/foreach}
                        {else}
                            <p>Non ci sono ancora recensioni per questo locale</p>
                        {/if}


                        <!--/\/\//\/\//\/\//\/\//\/\//\/\///////////////////////\\\\\\\\\\\\\\\\\/\/\//\/\//\/\//\/\//\/\//\/\/////\\\\\/\/\/\/\/\/\/\/\/\//\/\/\-->
                        {if !($userlogged eq 'nouser')}
                            <div class="reply-form">
                                <h4>Scrivi una recensione</h4>
                                <form action=CGestioneRecensione/scriviRecensione method="POST" name="Recensione"
                                      onsubmit="return validateRecensione()">
                                    <input type="hidden" name="idLocale" value={$locale->getId()}/>
                                    <input type="hidden" name="nomeLocale" value={$locale->getNome()}/>
                                    <input type="hidden" name="localizzazione" value={$locale->getLocalizzazione()}/>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input name="titolo" type="text" class="form-control" placeholder="Titolo">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <select name="valutazione"
                                                    style="font-family: 'FontAwesome',Arial,sans-serif;">
                                                <option>-- Voto --</option>
                                                <option value="1">&#xf005;</option>
                                                <option value="2">&#xf005;&#xf005;</option>
                                                <option value="3">&#xf005;&#xf005;&#xf005;</option>
                                                <option value="4">&#xf005;&#xf005;&#xf005;&#xf005;</option>
                                                <option value="5">&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group">
                                            <textarea name="descrizione" class="form-control"
                                                      placeholder="Descrizione"></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Aggiungi recensione</button>
                                </form>
                            </div>
                        {/if}
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>

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
<script src="/template/js/main.js"></script>

</body>

</html>