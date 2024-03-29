<!DOCTYPE html>
<html lang="en">
{assign var='locale' value=$locale|default:null}
{assign var='arrayRecensioni' value=$arrayRecensioni|default:empty}
{assign var='nrece' value=$nrece|default:0}
{assign var='eventi' value=$eventi|default:null}
{assign var='proprietario' value=$proprietario|default:null}
{assign var='valutazioneLocale' value=$valutazioneLocale|default:null}
{assign var='arrayRisposte' value=$arrayRisposte|default:null}
{assign var='utente' value=$utente|default:null}
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
    <link href="/FacceBeve/template/img/favicon.png" rel="icon">
    <link href="/FacceBeve/template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="https://bootswatch.com/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>

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

<!-- <body onLoad="document.forms[0].submit()">  -->
<body>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/FacceBeve/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
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
                        {if $tipo == "EUtente"}
                            {if $presente == true}
                                <form action="/FacceBeve/Ricerca/aggiungiAPreferiti/{$locale->getId()}" method="POST">
                                    <input class="stelline" onclick="change()" type="submit" value="Aggiunto!" id="pref"
                                           name="pref">
                                </form>
                            {else}
                                <form action="/FacceBeve/Ricerca/aggiungiAPreferiti/{$locale->getId()}" method="POST">
                                    <input class="stelline" onclick="change()" type="submit"
                                           value="Aggiungi ai preferiti" id="pref" name="pref">
                                </form>
                            {/if}
                        {/if}
                        <div class="swiper-wrapper">
                            {if !empty($locale->getImg())}
                                {foreach $locale->getImg() as $img}
                                    <div class="swiper-slide" style="text-align: center">
                                        <img style="height: 90%; width: 90%; border-radius: 15%" src="data:{$img->getType()};base64,{$img->getImmagine()}"
                                             alt="Immagine localeeee">
                                    </div>
                                {/foreach}
                            {else}
                                <div class="swiper-slide" style="text-align: center">
                                    <img src="/FacceBeve/template/img/no_foto.jpg" alt="Immagine locale"
                                         style="height: 90%; width: 90%; border-radius: 15%">
                                </div>
                            {/if}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <br>
                    <div class="portfolio-details-slider swiper">
                        <h4 style="display: list-item; font-weight: bold">Eventi organizzati:</h4>
                        <div class="swiper-wrapper align-items-center">
                            {if ($tipo == "EUtente" || $tipo == "EProprietario")}
                                {if !empty($eventi)}
                                    {foreach $eventi as $evento}
                                        <div class="portfolio-info swiper-slide">
                                            <h3>{$evento->getNome()}</h3>
                                            <img src="data:{$evento->getImg()->getType()};base64,{$evento->getImg()->getImmagine()}"
                                                 alt="Poster evento"
                                                 style="max-width: 250px; max-height: 250px; float:right; display: block; border-radius:30px;">
                                            <ul>
                                                <li><strong>Data</strong>: {$evento->getData()}</li>
                                                <li><strong>Descrizione</strong>: {$evento->getDescrizione()}</li>
                                            </ul>
                                        </div>
                                    {/foreach}
                                {else}
                                    <p>Non ci sono ancora eventi organizzati</p>
                                {/if}
                            {else}
                                <div class="portfolio-info">
                                    <p>Questa sezione è dedicata agli utenti iscritti, accedi o registrati per non
                                        perderti gli
                                        eventi
                                        dei tuoi locali preferiti </p>
                                </div>
                            {/if}
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
                            <li><strong>Citt&agrave:</strong> {$locale->getLocalizzazione()->getCitta()}
                                <strong>CAP:</strong> {$locale->getLocalizzazione()->getCAP()}</li>
                            <li style="font-weight: bold;"><a
                                        href="https://maps.google.com/?q= {$locale->getLocalizzazione()->getIndirizzo()}, {$locale->getLocalizzazione()->getNumCivico()}, {$locale->getLocalizzazione()->getCitta()}, {$locale->getLocalizzazione()->getCAP()}, {$locale->getNome()}"
                                        target="_blank"><i class="fas fa-map-marker-alt"></i> Come
                                    raggiungerci...</a>
                            </li>
                            <li><strong>Categorie:</strong>
                                <ul>
                                    {foreach $locale->getCategoria() as $categoria}
                                        <li>{$categoria->getGenere()}</li>
                                    {/foreach}
                                </ul>
                            </li>
                            <li><strong>Descrizione:</strong> {$locale->getDescrizione()}</li>
                            {if ($valutazioneLocale != 0)}
                                <li><strong>Valutazione:</strong> {$valutazioneLocale}/5</li>
                            {/if}
                        </ul>
                    </div>
                    <div class="portfolio-info">
                        <h3>Orario settimanale del locale</h3>
                        <table id="customers">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Apertura</th>
                                <th>Chiusura</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $locale->getOrario() as $orario}
                                <tr>
                                    <td><strong>{$orario->getGiornoSettimana()}</strong></td>
                                    <td>{$orario->getOrarioApertura()}</td>
                                    <td>{$orario->getOrarioChiusura()} </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8 entries">
                    <div class="blog-comments">
                        <h4 class="comments-count">Area Recensioni:</h4>
                        {if !empty($arrayRecensioni)}
                        {foreach $arrayRecensioni as $recensione}
                        <div id="comment-1" class="comment">
                            <div class="d-flex">
                                {if (!is_null($recensione->getUtente()->getImgProfilo()))}
                                    <div class="comment-img"><img
                                                src="data:{$recensione->getUtente()->getImgProfilo()->getType()};base64,{$recensione->getUtente()->getImgProfilo()->getImmagine()}"
                                                alt="Immagine profilo utente" style="border-radius: 35px;">
                                    </div>
                                {else}
                                    <div class="comment-img"><img
                                                src="/FacceBeve/template/img/utente.jpg" alt="immagine profiloooo"
                                                style="border-radius: 35px;">
                                    </div>
                                {/if}

                                <div>
                                    <h5>{$recensione->getUtente()->getUsername()}</h5>

                                    <h5>{$recensione->getData()} | <strong>Voto: {$recensione->getVoto()}
                                            / 5</strong>
                                        {if $recensione->getUtente()->getUsername() eq $utente}
                                            <form action="/FacceBeve/GestioneRecensione/cancellaRecensione/{$recensione->getId()}"
                                                  method="POST">
                                                <input type="hidden" value="{$locale->getId()}" name="idLocale">
                                                <button type="submit"
                                                        style="border-radius:9px; height: 40px; color: #bb2d3b; font-weight: bold; border-color: #bb2d3b">
                                                    <i class="align-items-xxl-end"></i>Elimina la tua Recensione
                                                </button>
                                            </form>
                                        {/if}
                                        {if isset($proprietario) && ($recensione->isSegnalata() == 0)}
                                            <form action="/FacceBeve/GestioneRecensione/segnalaRecensione/{$recensione->getId()}"
                                                  method="POST">
                                                <input type="hidden" value="{$locale->getId()}" name="idLocale">
                                                <button type="submit" id="segnala"
                                                        style="border-radius:9px; height: 40px; color: #bb2d3b; font-weight: bold; border-color: #bb2d3b">
                                                    <i class="align-items-xxl-end"></i>Segnala la Recensione
                                                </button>
                                            </form>
                                        {/if}
                                        {if isset($proprietario) && ($recensione->isSegnalata() == 1)}
                                            <h5><i> Recensione Segnalata </i></h5>
                                        {/if}
                                    </h5>

                                    <h4 style="font-weight:bold;">{$recensione->getTitolo()} </h4>
                                    <p>{$recensione->getDescrizione()}</p>


                                </div>
                            </div>
                        </div>
                        {if isset($arrayRisposte[{$recensione@iteration-1}])}
                        <div id="comment-reply-1" class="comment comment-reply">
                            <div class="d-flex"><h6><i class="bi-arrow-right-short">Re:</i></h6>
                                {if !(is_null($arrayRisposte[{$recensione@iteration-1}]->getProprietario()->getImgProfilo()))}
                                <div class="comment-img"><img
                                            src="data:{$arrayRisposte[{$recensione@iteration-1}]->getProprietario()->getImgProfilo()->getType()};base64,{$arrayRisposte[{$recensione@iteration-1}]->getProprietario()->getImgProfilo()->getImmagine()}"
                                            alt="Immagine profilo proprietario"
                                            style="border-radius: 35px;"></div>
                                <div>
                                    {else}
                                    <div class="comment-img"><img
                                                src="/FacceBeve/template/img/utente.jpg"
                                                alt="Immagine profilo proprietario"
                                                style="border-radius: 35px;"></div>
                                    <div>
                                        {/if}
                                        <h5>{$arrayRisposte[{$recensione@iteration-1}]->getProprietario()->getUsername()}</h5>
                                        <p>{$arrayRisposte[{$recensione@iteration-1}]->getDescrizione()}</p>

                                        {if $arrayRisposte[{$recensione@iteration-1}]->getProprietario()->getUsername() eq $utente}
                                            <form action="/FacceBeve/GestioneRecensione/cancellaRisposta/{$arrayRisposte[{$recensione@iteration-1}]->getId()}"
                                                  method="POST">
                                                <input type="hidden" value="{$locale->getId()}" name="idLocale">
                                                <button type="submit"
                                                        style="border-radius:9px; height: 40px; color: #bb2d3b; font-weight: bold; border-color: #bb2d3b">
                                                    <i class="align-items-xxl-end"></i>Elimina la tua Risposta
                                                </button>
                                            </form>
                                        {/if}

                                    </div>
                                </div>
                            </div>
                            {else}
                            {if isset($proprietario)}
                                <div class="reply-form" name="formRisposta">
                                    <h4>Rispondi</h4>
                                    <form action="/FacceBeve/GestioneRecensione/rispondi/{$arrayRecensioni[{$recensione@iteration-1}]->getId()}"
                                          method="POST"
                                          name="Risposta"> <!--onsubmit="return validateRisposta()"-->
                                        <input type="hidden" name="idLocale"
                                               value="{$locale->getId()}"/>
                                        <div class="row">
                                            <div class="col form-group">
                                                        <textarea name="descrizioneRisposta" class="form-control"
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

                            <!--onsubmit="return validateRecensione()"  -->
                            <!--/\/\//\/\//\/\//\/\//\/\//\/\///////////////////////\\\\\\\\\\\\\\\\\/\/\//\/\//\/\//\/\//\/\//\/\/////\\\\\/\/\/\/\/\/\/\/\/\//\/\/\-->
                            {if ($tipo == "EUtente" & $stato == "1")}
                                <div class="reply-form">
                                    <h4>Scrivi una recensione</h4>
                                    <form action="/FacceBeve/GestioneRecensione/scriviRecensione/{$locale->getId()}" method="POST"
                                          id="Recensione" onsubmit="return validateRecensione()">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <input name="titolo" type="text" class="form-control">
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