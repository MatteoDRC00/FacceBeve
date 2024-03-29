<?php
/* Smarty version 4.2.0, created on 2022-10-15 12:03:08
  from 'C:\xampp\htdocs\FacceBeve\template\InfoLocale.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_634a855c784813_95575733',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '172a59cd6d9d0fe4c26f91abf9bfe128c31cd594' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\InfoLocale.tpl',
      1 => 1665827936,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634a855c784813_95575733 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<?php $_smarty_tpl->_assignInScope('locale', (($tmp = $_smarty_tpl->tpl_vars['locale']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('arrayRecensioni', (($tmp = $_smarty_tpl->tpl_vars['arrayRecensioni']->value ?? null)===null||$tmp==='' ? 'empty' ?? null : $tmp));
$_smarty_tpl->_assignInScope('nrece', (($tmp = $_smarty_tpl->tpl_vars['nrece']->value ?? null)===null||$tmp==='' ? 0 ?? null : $tmp));
$_smarty_tpl->_assignInScope('eventi', (($tmp = $_smarty_tpl->tpl_vars['eventi']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('proprietario', (($tmp = $_smarty_tpl->tpl_vars['proprietario']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('valutazioneLocale', (($tmp = $_smarty_tpl->tpl_vars['valutazioneLocale']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('arrayRisposte', (($tmp = $_smarty_tpl->tpl_vars['arrayRisposte']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('utente', (($tmp = $_smarty_tpl->tpl_vars['utente']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('userlogged', (($tmp = $_smarty_tpl->tpl_vars['userlogged']->value ?? null)===null||$tmp==='' ? 'nouser' ?? null : $tmp));
echo '<script'; ?>
>
    function change() {
        var elem = document.getElementById("pref");
        if (elem.value == "Aggiungi ai preferiti") elem.value = "Aggiunto!";
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
                        <h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
</h2>
                        <?php if ($_smarty_tpl->tpl_vars['tipo']->value == "EUtente") {?>
                            <?php if ($_smarty_tpl->tpl_vars['presente']->value == true) {?>
                                <form action="/Ricerca/aggiungiAPreferiti/<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
" method="POST">
                                    <input class="stelline" onclick="change()" type="submit" value="Aggiunto!" id="pref"
                                           name="pref">
                                </form>
                            <?php } else { ?>
                                <form action="/Ricerca/aggiungiAPreferiti/<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
" method="POST">
                                    <input class="stelline" onclick="change()" type="submit"
                                           value="Aggiungi ai preferiti" id="pref" name="pref">
                                </form>
                            <?php }?>
                        <?php }?>
                        <div class="swiper-wrapper">
                            <?php if (!empty($_smarty_tpl->tpl_vars['locale']->value->getImg())) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locale']->value->getImg(), 'img');
$_smarty_tpl->tpl_vars['img']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->do_else = false;
?>
                                    <div class="swiper-slide" style="text-align: center">
                                        <img style="height: 90%; width: 90%; border-radius: 15%" src="data:<?php echo $_smarty_tpl->tpl_vars['img']->value->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['img']->value->getImmagine();?>
"
                                             alt="Immagine localeeee">
                                    </div>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                                <div class="swiper-slide" style="text-align: center">
                                    <img src="/template/img/no_foto.jpg" alt="Immagine locale"
                                         style="height: 90%; width: 90%; border-radius: 15%">
                                </div>
                            <?php }?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <br>
                    <div class="portfolio-details-slider swiper">
                        <h4 style="display: list-item; font-weight: bold">Eventi organizzati:</h4>
                        <div class="swiper-wrapper align-items-center">
                            <?php if (($_smarty_tpl->tpl_vars['tipo']->value == "EUtente" || $_smarty_tpl->tpl_vars['tipo']->value == "EProprietario")) {?>
                                <?php if (!empty($_smarty_tpl->tpl_vars['eventi']->value)) {?>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['eventi']->value, 'evento');
$_smarty_tpl->tpl_vars['evento']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['evento']->value) {
$_smarty_tpl->tpl_vars['evento']->do_else = false;
?>
                                        <div class="portfolio-info swiper-slide">
                                            <h3><?php echo $_smarty_tpl->tpl_vars['evento']->value->getNome();?>
</h3>
                                            <img src="data:<?php echo $_smarty_tpl->tpl_vars['evento']->value->getImg()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['evento']->value->getImg()->getImmagine();?>
"
                                                 alt="Poster evento"
                                                 style="max-width: 250px; max-height: 250px; float:right; display: block; border-radius:30px;">
                                            <ul>
                                                <li><strong>Data</strong>: <?php echo $_smarty_tpl->tpl_vars['evento']->value->getData();?>
</li>
                                                <li><strong>Descrizione</strong>: <?php echo $_smarty_tpl->tpl_vars['evento']->value->getDescrizione();?>
</li>
                                            </ul>
                                        </div>
                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php } else { ?>
                                    <p>Non ci sono ancora eventi organizzati</p>
                                <?php }?>
                            <?php } else { ?>
                                <div class="portfolio-info">
                                    <p>Questa sezione è dedicata agli utenti iscritti, accedi o registrati per non
                                        perderti gli
                                        eventi
                                        dei tuoi locali preferiti </p>
                                </div>
                            <?php }?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="portfolio-info">
                        <h3>Informazioni sul locale</h3>
                        <ul>
                            <li><strong>Indirizzo:</strong> <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getIndirizzo();?>

                                , <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getNumCivico();?>
</li>
                            <li><strong>Citt&agrave:</strong> <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCitta();?>

                                <strong>CAP:</strong> <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCAP();?>
</li>
                            <li style="font-weight: bold;"><a
                                        href="https://maps.google.com/?q= <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getIndirizzo();?>
, <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getNumCivico();?>
, <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCitta();?>
, <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCAP();?>
, <?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
"
                                        target="_blank"><i class="fas fa-map-marker-alt"></i> Come
                                    raggiungerci...</a>
                            </li>
                            <li><strong>Categorie:</strong>
                                <ul>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locale']->value->getCategoria(), 'categoria');
$_smarty_tpl->tpl_vars['categoria']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['categoria']->value) {
$_smarty_tpl->tpl_vars['categoria']->do_else = false;
?>
                                        <li><?php echo $_smarty_tpl->tpl_vars['categoria']->value->getGenere();?>
</li>
                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                </ul>
                            </li>
                            <li><strong>Descrizione:</strong> <?php echo $_smarty_tpl->tpl_vars['locale']->value->getDescrizione();?>
</li>
                            <?php if (($_smarty_tpl->tpl_vars['valutazioneLocale']->value != 0)) {?>
                                <li><strong>Valutazione:</strong> <?php echo $_smarty_tpl->tpl_vars['valutazioneLocale']->value;?>
/5</li>
                            <?php }?>
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
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locale']->value->getOrario(), 'orario');
$_smarty_tpl->tpl_vars['orario']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['orario']->value) {
$_smarty_tpl->tpl_vars['orario']->do_else = false;
?>
                                <tr>
                                    <td><strong><?php echo $_smarty_tpl->tpl_vars['orario']->value->getGiornoSettimana();?>
</strong></td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['orario']->value->getOrarioApertura();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['orario']->value->getOrarioChiusura();?>
 </td>
                                </tr>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
                        <?php if (!empty($_smarty_tpl->tpl_vars['arrayRecensioni']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrayRecensioni']->value, 'recensione');
$_smarty_tpl->tpl_vars['recensione']->iteration = 0;
$_smarty_tpl->tpl_vars['recensione']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['recensione']->value) {
$_smarty_tpl->tpl_vars['recensione']->do_else = false;
$_smarty_tpl->tpl_vars['recensione']->iteration++;
$__foreach_recensione_4_saved = $_smarty_tpl->tpl_vars['recensione'];
?>
                        <div id="comment-1" class="comment">
                            <div class="d-flex">
                                <?php if ((!is_null($_smarty_tpl->tpl_vars['recensione']->value->getUtente()->getImgProfilo()))) {?>
                                    <div class="comment-img"><img
                                                src="data:<?php echo $_smarty_tpl->tpl_vars['recensione']->value->getUtente()->getImgProfilo()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['recensione']->value->getUtente()->getImgProfilo()->getImmagine();?>
"
                                                alt="Immagine profilo utente" style="border-radius: 35px;">
                                    </div>
                                <?php } else { ?>
                                    <div class="comment-img"><img
                                                src="/template/img/utente.jpg" alt="immagine profiloooo"
                                                style="border-radius: 35px;">
                                    </div>
                                <?php }?>

                                <div>
                                    <h5><?php echo $_smarty_tpl->tpl_vars['recensione']->value->getUtente()->getUsername();?>
</h5>

                                    <h5><?php echo $_smarty_tpl->tpl_vars['recensione']->value->getData();?>
 | <strong>Voto: <?php echo $_smarty_tpl->tpl_vars['recensione']->value->getVoto();?>

                                            / 5</strong>
                                        <?php if ($_smarty_tpl->tpl_vars['recensione']->value->getUtente()->getUsername() == $_smarty_tpl->tpl_vars['utente']->value) {?>
                                            <form action="/GestioneRecensione/cancellaRecensione/<?php echo $_smarty_tpl->tpl_vars['recensione']->value->getId();?>
"
                                                  method="POST">
                                                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
" name="idLocale">
                                                <button type="submit"
                                                        style="border-radius:9px; height: 40px; color: #bb2d3b; font-weight: bold; border-color: #bb2d3b">
                                                    <i class="align-items-xxl-end"></i>Elimina la tua Recensione
                                                </button>
                                            </form>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['proprietario']->value)) && ($_smarty_tpl->tpl_vars['recensione']->value->isSegnalata() == 0)) {?>
                                            <form action="/GestioneRecensione/segnalaRecensione/<?php echo $_smarty_tpl->tpl_vars['recensione']->value->getId();?>
"
                                                  method="POST">
                                                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
" name="idLocale">
                                                <button type="submit" id="segnala"
                                                        style="border-radius:9px; height: 40px; color: #bb2d3b; font-weight: bold; border-color: #bb2d3b">
                                                    <i class="align-items-xxl-end"></i>Segnala la Recensione
                                                </button>
                                            </form>
                                        <?php }?>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['proprietario']->value)) && ($_smarty_tpl->tpl_vars['recensione']->value->isSegnalata() == 1)) {?>
                                            <h5><i> Recensione Segnalata </i></h5>
                                        <?php }?>
                                    </h5>

                                    <h4 style="font-weight:bold;"><?php echo $_smarty_tpl->tpl_vars['recensione']->value->getTitolo();?>
 </h4>
                                    <p><?php echo $_smarty_tpl->tpl_vars['recensione']->value->getDescrizione();?>
</p>


                                </div>
                            </div>
                        </div>
                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable1 = ob_get_clean();
if ((isset($_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable1]))) {?>
                        <div id="comment-reply-1" class="comment comment-reply">
                            <div class="d-flex"><h6><i class="bi-arrow-right-short">Re:</i></h6>
                                <?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable2 = ob_get_clean();
if (!(is_null($_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable2]->getProprietario()->getImgProfilo()))) {?>
                                <div class="comment-img"><img
                                            src="data:<?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable3 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable3]->getProprietario()->getImgProfilo()->getType();?>
;base64,<?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable4 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable4]->getProprietario()->getImgProfilo()->getImmagine();?>
"
                                            alt="Immagine profilo proprietario"
                                            style="border-radius: 35px;"></div>
                                <div>
                                    <?php } else { ?>
                                    <div class="comment-img"><img
                                                src="/template/img/utente.jpg"
                                                alt="Immagine profilo proprietario"
                                                style="border-radius: 35px;"></div>
                                    <div>
                                        <?php }?>
                                        <h5><?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable5 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable5]->getProprietario()->getUsername();?>
</h5>
                                        <p><?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable6 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable6]->getDescrizione();?>
</p>

                                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable7 = ob_get_clean();
if ($_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable7]->getProprietario()->getUsername() == $_smarty_tpl->tpl_vars['utente']->value) {?>
                                            <form action="/GestioneRecensione/cancellaRisposta/<?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable8 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['arrayRisposte']->value[$_prefixVariable8]->getId();?>
"
                                                  method="POST">
                                                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
" name="idLocale">
                                                <button type="submit"
                                                        style="border-radius:9px; height: 40px; color: #bb2d3b; font-weight: bold; border-color: #bb2d3b">
                                                    <i class="align-items-xxl-end"></i>Elimina la tua Risposta
                                                </button>
                                            </form>
                                        <?php }?>

                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['proprietario']->value))) {?>
                                <div class="reply-form" name="formRisposta">
                                    <h4>Rispondi</h4>
                                    <form action="/GestioneRecensione/rispondi/<?php ob_start();
echo $_smarty_tpl->tpl_vars['recensione']->iteration-1;
$_prefixVariable9 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['arrayRecensioni']->value[$_prefixVariable9]->getId();?>
"
                                          method="POST"
                                          name="Risposta"> <!--onsubmit="return validateRisposta()"-->
                                        <input type="hidden" name="idLocale"
                                               value="<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
"/>
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
                            <?php }?>
                            <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['recensione'] = $__foreach_recensione_4_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                            <p>Non ci sono ancora recensioni per questo locale</p>
                            <?php }?>

                            <!--onsubmit="return validateRecensione()"  -->
                            <!--/\/\//\/\//\/\//\/\//\/\//\/\///////////////////////\\\\\\\\\\\\\\\\\/\/\//\/\//\/\//\/\//\/\//\/\/////\\\\\/\/\/\/\/\/\/\/\/\//\/\/\-->
                            <?php if (($_smarty_tpl->tpl_vars['tipo']->value == "EUtente"&$_smarty_tpl->tpl_vars['stato']->value == "1")) {?>
                                <div class="reply-form">
                                    <h4>Scrivi una recensione</h4>
                                    <form action="/GestioneRecensione/scriviRecensione/<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
" method="POST"
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
