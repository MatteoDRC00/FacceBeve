<?php
/* Smarty version 4.2.0, created on 2022-09-16 21:27:54
  from 'C:\xampp\htdocs\FacceBeve\template\InfoLocale.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_6324ce3a0ccac6_66985334',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '172a59cd6d9d0fe4c26f91abf9bfe128c31cd594' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\InfoLocale.tpl',
      1 => 1663356472,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6324ce3a0ccac6_66985334 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<?php $_smarty_tpl->_assignInScope('locale', (($tmp = $_smarty_tpl->tpl_vars['locale']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('arrayRecensioni', (($tmp = $_smarty_tpl->tpl_vars['arrayRecensioni']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('nrece', (($tmp = $_smarty_tpl->tpl_vars['nrece']->value ?? null)===null||$tmp==='' ? 0 ?? null : $tmp));
$_smarty_tpl->_assignInScope('eventi', (($tmp = $_smarty_tpl->tpl_vars['eventi']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('proprietario', (($tmp = $_smarty_tpl->tpl_vars['proprietario']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('valutazioneLocale', (($tmp = $_smarty_tpl->tpl_vars['valutazioneLocale']->value ?? null)===null||$tmp==='' ? 5 ?? null : $tmp));
$_smarty_tpl->_assignInScope('arrayRisposte', (($tmp = $_smarty_tpl->tpl_vars['arrayRisposte']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));?>}
<?php $_smarty_tpl->_assignInScope('userlogged', (($tmp = $_smarty_tpl->tpl_vars['userlogged']->value ?? null)===null||$tmp==='' ? 'nouser' ?? null : $tmp));
echo '<script'; ?>
>
    function change(){
        var elem = document.getElementById("pref");
        if (elem.value=="Aggiungi ai preferiti") elem.value = "Aggiunto!";
        else elem.value = "Aggiungi ai preferiti";
    }
<?php echo '</script'; ?>
>

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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />

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
                        <h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
</h2>
                        <input onclick="change()" type="button" value="Aggiungi ai preferiti" id="pref" name="pref">                      <div class="stelline star-rating" data-rating="4.6">
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
                                        <img src="data:<?php echo $_smarty_tpl->tpl_vars['locale']->value->getImg()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['locale']->value->getImg()->getImmagine();?>
" alt="Immagine locale">
                                    </div>
                                </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="portfolio-info">
                        <h3>Informazioni sul locale</h3>
                        <ul>
                            <li><strong>Indirizzo</strong>:<?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getIndirizzo();?>
,<?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getNumCivico();?>
</li>
                            <li><strong>Citt&agrave</strong>:<?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCitta();?>
, CAP:<?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCAP();?>
</li>
                            <li><strong>Categorie</strong>:<?php echo $_smarty_tpl->tpl_vars['locale']->value->getCategorie();?>
</li>
                            <li><strong>Descrizione</strong>:<?php echo $_smarty_tpl->tpl_vars['locale']->value->getDescrizione();?>
 </li>
                            <li><strong>Valutazione</strong>:<?php echo $_smarty_tpl->tpl_vars['valutazioneLocale']->value;?>
/5</li>
                        </ul>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['userLogged']->value != 'nouser') {?>
                        <?php if ((isset($_smarty_tpl->tpl_vars['eventi']->value))) {?>
                            <div class="portfolio-details-slider swiper">
                                <br>
                                <h4><strong>Eventi organizzati:</strong></h4>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['eventi']->value, 'evento');
$_smarty_tpl->tpl_vars['evento']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['evento']->value) {
$_smarty_tpl->tpl_vars['evento']->do_else = false;
?>
                                    <div class="portfolio-info swiper-slide">
                                        <h3><?php echo $_smarty_tpl->tpl_vars['evento']->value->getNome();?>
</h3>
                                        <ul>
                                            <li><strong>Data</strong>: <?php echo $_smarty_tpl->tpl_vars['evento']->value->getData();?>
.</li>
                                            <li><strong>Descrizione</strong>: <?php echo $_smarty_tpl->tpl_vars['evento']->value->getDescrizione();?>
</li>
                                        </ul>
                                    </div>
                                    <img class="photo" src="data:<?php echo $_smarty_tpl->tpl_vars['evento']->value->getImg()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['evento']->value->getImg()->getImmagine();?>
" alt="Poster evento">
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php } else { ?>
                                <p>Non ci sono ancora eventi organizzati</p>
                                <!--   <div class="swiper-pagination"></div>-->
                            </div>
                        <?php }?>
                    <?php } else { ?>
                        <p>Questa sezione è dedicata agli utenti iscritti, accedi o registrati per non perderti gli eventi dei tuoi locali preferiti</p>
                    <?php }?>
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
                        <?php if (empty($_smarty_tpl->tpl_vars['arrayRecensioni']->value)) {?>
                            <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? ($_smarty_tpl->tpl_vars['nrece']->value-1)+1 - (0) : 0-(($_smarty_tpl->tpl_vars['nrece']->value-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                                <div id="comment-1" class="comment">
                                    <div class="d-flex">
                                        <div class="comment-img"><img src="data:<?php echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_smarty_tpl->tpl_vars['i']->value]->getUtente()->getImgProfilo()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_smarty_tpl->tpl_vars['i']->value]->getUtente()->getImgProfilo()->getImmagine();?>
" alt="Immagine profilo utente"></div>
                                        <div>
                                            <h5><a href=""><?php echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_smarty_tpl->tpl_vars['i']->value]->getUtente()->getUsername();?>
</a> <a href="#" class="reply"><i
                                                            class="bi bi-reply-fill"></i> Risposta</a></h5>
                                            <h5><?php echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_smarty_tpl->tpl_vars['i']->value]->getData();?>
</h5>
                                            <h2><?php echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_smarty_tpl->tpl_vars['i']->value]->getTitolo();?>
</h2>
                                            <p><?php echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_smarty_tpl->tpl_vars['i']->value]->getDescrizione();?>
</p>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['arrayRisposte']->value[$_smarty_tpl->tpl_vars['i']->value] != null) {?>
                                    <div id="comment-reply-1" class="comment comment-reply">
                                        <div class="d-flex">
                                            <div class="comment-img"><img src="data:<?php echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_smarty_tpl->tpl_vars['i']->value]->getProprietario()->getImgProfilo()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_smarty_tpl->tpl_vars['i']->value]->getProprietario()->getImgProfilo()->getImmagine();?>
" alt="Immagine profilo proprietario"></div>
                                            <div>
                                                <h5><?php echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_smarty_tpl->tpl_vars['i']->value]->getProprietario()->getUsername();?>
</h5>
                                                <h5><?php echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_smarty_tpl->tpl_vars['i']->value]->getData();?>
</h5>
                                                <p><?php echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_smarty_tpl->tpl_vars['i']->value]->getDescrizione();?>
</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?php if ($_smarty_tpl->tpl_vars['proprietario']->value == true) {?>
                                        <div class="reply-form">
                                            <h4>Scrivi una recensione</h4>
                                            <form action=CGestioneRecensione/scriviRisposta  method="POST" name="Risposta"> <!--onsubmit="return validateRisposta()"-->
                                                <input type="hidden" name="idRecensione" value="<?php echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_smarty_tpl->tpl_vars['i']->value]->getId();?>
"/>
                                                <div class="row">
                                                    <div class="col form-group">
                                                          <textarea name="descrizione" class="form-control" placeholder="Risposta" required title="Inserire del testo nella risposta"></textarea>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Rispondi</button>
                                            </form>
                                        </div>
                                    <?php }?>
                                <?php }?>
                            <?php }
}
?>
                        <?php } else { ?>
                            <p>Non ci sono ancora recensioni per questo locale</p>
                        <?php }?>


<!--/\/\//\/\//\/\//\/\//\/\//\/\///////////////////////\\\\\\\\\\\\\\\\\/\/\//\/\//\/\//\/\//\/\//\/\/////\\\\\/\/\/\/\/\/\/\/\/\//\/\/\-->
                        <?php if ($_smarty_tpl->tpl_vars['userLogged']->value != 'nouser') {?>
                        <div class="reply-form">
                            <h4>Scrivi una recensione</h4>
                            <form action=CGestioneRecensione/scriviRecensione  method="POST" name="Recensione" onsubmit="return validateRecensione()">
                                <input type="hidden" name="idLocale" value=<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
/>
                                <input type="hidden" name="nomeLocale" value=<?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
/>
                                <input type="hidden" name="localizzazione" value=<?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione();?>
/>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input name="titolo" type="text" class="form-control" placeholder="Titolo">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <select name="valutazione" style="font-family: 'FontAwesome',Arial;">
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
                                        <textarea name="descrizione" class="form-control" placeholder="Descrizione"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Aggiungi recensione</button>
                            </form>
                        </div>
                        <?php }?>
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
<?php echo '<script'; ?>
 src="/template/vendor/purecounter/purecounter_vanilla.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/template/vendor/aos/aos.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/template/vendor/bootstrap/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/template/vendor/glightbox/js/glightbox.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/template/vendor/isotope-layout/isotope.pkgd.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/template/vendor/swiper/swiper-bundle.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/template/vendor/waypoints/noframework.waypoints.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/template/vendor/php-email-form/validate.js"><?php echo '</script'; ?>
>

<!-- Template Main JS File -->
<?php echo '<script'; ?>
 src="/template/js/main.js"><?php echo '</script'; ?>
>

</body>

</html><?php }
}