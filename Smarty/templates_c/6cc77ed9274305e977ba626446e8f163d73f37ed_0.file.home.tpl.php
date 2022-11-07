<?php
/* Smarty version 4.2.0, created on 2022-10-20 16:37:23
  from '/membri/faccebeve/template/home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_63515d23dd83c0_22393020',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6cc77ed9274305e977ba626446e8f163d73f37ed' => 
    array (
      0 => '/membri/faccebeve/template/home.tpl',
      1 => 1666260403,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63515d23dd83c0_22393020 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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

<body> <!--onload="setList()"-->

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

        <?php if ($_smarty_tpl->tpl_vars['tipo']->value == 'nouser') {?>
            <div class="sign">
                <a href="/Accesso/formLogin">Accedi</a>
                <a href="/Accesso/formRegistrazioneUtente">Registrati</a>
                <a href="/Accesso/formRegistrazioneProprietario">Vuoi pubblicizzare il tuo locale?</a>
            </div>
        <?php } elseif ($_smarty_tpl->tpl_vars['tipo']->value == 'EUtente') {?>
            <div class="sign">
                <a href="/Profilo/mostraProfilo">Area Personale Utente</a>
                <a href="/Accesso/logout">Logout</a>
            </div>
        <?php } elseif ($_smarty_tpl->tpl_vars['tipo']->value == 'EProprietario') {?>
            <div class="sign">
                <a href="/Profilo/mostraProfilo">Area Personale Proprietario</a>
                <a href="/Accesso/logout">Logout</a>
            </div>
        <?php }?>

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex justify-content-center align-items-center">
    <div id="heroCarousel" class="container carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-item active">
            <?php if ($_smarty_tpl->tpl_vars['tipo']->value != 'nouser') {?>
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
                          action="/Ricerca/ricerca" method="POST">
                        <input class="homeinput" type="hidden" value="x" name="checkLocale" id="checkLocale">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta1">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome" name="nomeLocale1">
                        <select form="ricercaLocali1" name="categorie1" id="categorie1"
                                style="border-radius:7px; height: 50px  ;">
                            <option>--Scegli il tipo--</option>
                            <?php if (!empty($_smarty_tpl->tpl_vars['categorie']->value)) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categorie']->value, 'c');
$_smarty_tpl->tpl_vars['c']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->do_else = false;
?>
                                    <option type="radio" name="genere"
                                            value="<?php echo $_smarty_tpl->tpl_vars['c']->value->getGenere();?>
"> <?php echo $_smarty_tpl->tpl_vars['c']->value->getGenere();?>
</option>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php }?>
                        </select>
                        <button class="input" type="submit" style="border-radius:10px;"><i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Eventi"
                     style="display: none;justify-content: center;">
                    <form class="Search" id="ricercaEventi" onsubmit="return validateResearchForm(1)"
                          action="/Ricerca/ricerca" method="POST">
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
            <?php } else { ?>
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine
                        e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" style="color:white;">Trova i locali della tua città</h4>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown"
                     style="display: flex;justify-content: center;">
                    <form class="Search" name="ricercaLocali0" id="ricercaLocali0" action="/Ricerca/ricerca"
                          method="POST" onsubmit="return validateResearchForm(0)">
                        <input class="homeinput" type="text" placeholder="Inserisci la città" name="citta">
                        <input class="homeinput" type="text" placeholder="Inserisci il nome" name="nomeLocale">
                        <select name="categorie" id="categorie" form="ricercaLocali0"
                                style="border-radius:7px; height: 50px ">
                            <option>--Scegli il tipo--</option>
                            <?php if (!empty($_smarty_tpl->tpl_vars['categorie']->value)) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categorie']->value, 'c');
$_smarty_tpl->tpl_vars['c']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->do_else = false;
?>
                                    <option type="radio" name="genere"
                                            value="<?php echo $_smarty_tpl->tpl_vars['c']->value->getGenere();?>
"> <?php echo $_smarty_tpl->tpl_vars['c']->value->getGenere();?>
</option>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php }?>
                        </select>
                        <button type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            <?php }?>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= Services Section ======= -->
    <section class="services">
        <div class="container">

            <div class="row">
                <h2>Ecco i TOP 4 locali in Italia:</h2>
                <?php $_smarty_tpl->_assignInScope('i', 0);?>
                <?php if (!empty($_smarty_tpl->tpl_vars['topLocali']->value)) {?>
                    <?php $_smarty_tpl->_assignInScope('i', 0);?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['topLocali']->value, 'locale');
$_smarty_tpl->tpl_vars['locale']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['locale']->value) {
$_smarty_tpl->tpl_vars['locale']->do_else = false;
?>
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                            <div class="icon-box icon-box-pink">
                                <a href="/Ricerca/dettagliLocale/<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
"><h3
                                            style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
</h3></a>
                                <p style="font-weight: bold;">Voto: <?php echo $_smarty_tpl->tpl_vars['valutazione']->value[$_smarty_tpl->tpl_vars['i']->value];?>
/5</p>
                                <p class="description"><?php echo $_smarty_tpl->tpl_vars['locale']->value->getDescrizione();?>
</p>
                            </div>
                        </div>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php } else { ?>
                    <p>Non ci sono locali recensiti</p>
                <?php }?>
            </div>

            <?php if ((isset($_smarty_tpl->tpl_vars['eventiUtente']->value))) {?>
                <div class="row">
                    <h2>Ecco gli eventi in arrivo dei tuoi locali preferiti:</h2>
                    <?php if (!empty($_smarty_tpl->tpl_vars['eventiUtente']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['eventiUtente']->value, 'evento');
$_smarty_tpl->tpl_vars['evento']->iteration = 0;
$_smarty_tpl->tpl_vars['evento']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['evento']->value) {
$_smarty_tpl->tpl_vars['evento']->do_else = false;
$_smarty_tpl->tpl_vars['evento']->iteration++;
$__foreach_evento_3_saved = $_smarty_tpl->tpl_vars['evento'];
?>
                            <?php $_smarty_tpl->_assignInScope('i', 0);?>
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                                <div class="icon-box icon-box-pink">
                                    <a href="/Ricerca/dettagliLocale/<?php ob_start();
echo $_smarty_tpl->tpl_vars['evento']->iteration-1;
$_prefixVariable1 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['localiEventiUtente']->value[$_prefixVariable1];?>
"><h3
                                                style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['evento']->value->getNome();?>
</h3></a>
                                    <p style="font-weight: bold;"><?php echo $_smarty_tpl->tpl_vars['evento']->value->getData();?>
</p>
                                    <p class="description"><?php echo $_smarty_tpl->tpl_vars['evento']->value->getDescrizione();?>
</p>
                                </div>
                            </div>
                        <?php
$_smarty_tpl->tpl_vars['evento'] = $__foreach_evento_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        <p>Non ci sono eventi tra i tuoi locali preferiti</p>
                    <?php }?>
                </div>
            <?php }?>


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
 type="text/javascript" src="/template/js/main.js"><?php echo '</script'; ?>
>

</body>

</html><?php }
}
