<?php
/* Smarty version 4.2.0, created on 2022-09-09 15:33:14
  from 'C:\xampp\htdocs\FacceBeve\template\home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_631b409ae85123_83855385',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c953834e2bd280dacf9fe734edc7529afcd03f09' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\home.tpl',
      1 => 1662730394,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_631b409ae85123_83855385 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('tipo', $_smarty_tpl->tpl_vars['tipo']->value);?>
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

    <!-- JavaScript-->
    <?php echo '<script'; ?>
 type="text/javascript">
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
        };

        /** function defaultView() {
            var x = document.getElementById("Eventi");
            x.style.display = "none";
            var y = document.getElementById("Locali");
            y.style.display = "flex";
        };**/


    <?php echo '</script'; ?>
>

</head>

<body> <!--onload="defaultView()"-->

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="index.html"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

        <?php if ($_smarty_tpl->tpl_vars['tipo']->value == 'nouser') {?>
            <div class="sign">
                <a href="login.html">Accedi</a>
                <a href="registrazioneUtente.html">Registrati</a>
                <a href="registrazioneProprietario.html">Vuoi pubblicizzare il tuo locale?</a>
            </div>
        <?php } elseif ($_smarty_tpl->tpl_vars['tipo']->value == 'EUtente') {?>
            <div class="sign">
                <a href="areaPersonaleUtente.html">Il tuo profilo personale</a>
                <a href="areaPersonaleUtente.html">I tuoi locali preferiti</a> <!--Come si fa?-->
                <a href="registrazioneProprietario.html">Logout</a> <!--Qui direi una semplice action  -->
            </div>
        <?php } elseif ($_smarty_tpl->tpl_vars['tipo']->value == 'EProprietario') {?>
            <div class="sign">
                <a href="areaPersonaleProprietario.html">Il tuo profilo personale</a>
                <a href="areaPersonaleUtente.html">I tuoi locali gestiti</a> <!--Quasi quasi ne farei solo 2 di bottoni-->
                <a href="registrazioneProprietario.html">Logout</a> <!--Qui direi una semplice action  -->
            </div>
        <?php }?>

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex justify-content-center align-items-center" >
    <div id="heroCarousel" class="container carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="carousel-item active">
            <?php if ($_smarty_tpl->tpl_vars['tipo']->value != 'nouser') {?>
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" style="color:white">Puoi ricercare...</h4>
                    <select name="tipo" id="tipo" style="border-radius:10px;" onChange="setList()">
                        <option  selected value="Locali">Locali</option>
                        <option value="Eventi">Eventi</option>
                    </select>
                </div>
                <div class="ricerca animate__animated animate__fadeInDown" id="Locali" style="display: flex;justify-content: center;">
                    <form class="Search"  action="risultatiRicerca.html">
                        <input type="text" placeholder="Inserisci la città">
                        <input type="text" placeholder="Inserisci il nome" name="nomeLocale">
                        <select  name="categorie" style="border-radius:7px; height: 50px  ;">
                            <option>--Scegli il tipo--</option>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['genere_cat']->value, 'genere');
$_smarty_tpl->tpl_vars['genere']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['genere']->value) {
$_smarty_tpl->tpl_vars['genere']->do_else = false;
?>
                                <option><input type="radio" name="genere" value="<?php echo $_smarty_tpl->tpl_vars['genere']->value;?>
"> <?php echo $_smarty_tpl->tpl_vars['genere']->value;?>
</option>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </select>
                        <button class="input" type="submit" style="border-radius:10px;"><i class="fa fa-search"></i></button>
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
            <?php } else { ?>
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Benvenuti in <span>FacceBeve</span></h2>
                    <p class="animate__animated animate__fadeInUp">È scientificamente provato che un aperitivo patatine e birretta non salveranno il mondo, ma la giornata sicuramente sì.</p>
                    <h4 class="mb-0" style="color:white;">Trova i locali della tua città</h4>
                </div>

                <div class="ricerca animate__animated animate__fadeInDown" style="display: flex;justify-content: center;">
                    <form class="Search"  action="risultatiRicerca.html">
                        <input type="text" placeholder="Inserisci la città" name="citta">
                        <input type="text" placeholder="Inserisci il nome" name="nomeLo.cale">
                        <select name="categorie" style="border-radius:7px; height: 50px ">
                            <option>--Scegli il tipo--</option>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['genere_cat']->value, 'genere');
$_smarty_tpl->tpl_vars['genere']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['genere']->value) {
$_smarty_tpl->tpl_vars['genere']->do_else = false;
?>
                                <option type="radio" name="genere" value="<?php echo $_smarty_tpl->tpl_vars['genere']->value;?>
"> <?php echo $_smarty_tpl->tpl_vars['genere']->value;?>
</option>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </select>
                        <button type="submit" style="border-radius:7px; height: 50px"><i class="fa fa-search"></i></button>
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
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locali']->value, 'locale');
$_smarty_tpl->tpl_vars['locale']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['locale']->value) {
$_smarty_tpl->tpl_vars['locale']->do_else = false;
?>
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up">
                        <div class="icon-box icon-box-pink">
                            <h4 class="title" style="font-weight: bold"><a href=""><?php echo $_smarty_tpl->tpl_vars['locale']->value['nome'];?>
</a></h4>
                            <p class="description"><?php echo $_smarty_tpl->tpl_vars['locale']->value['descrizione'];?>
</p>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

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