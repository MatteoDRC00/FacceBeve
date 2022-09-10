<?php
/* Smarty version 4.2.0, created on 2022-09-10 10:57:56
  from 'C:\xampp\htdocs\FacceBeve\template\risultatiRicerca.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_631c519402cb42_98747565',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '20d71acbda86db7b277443849883e1b442d75786' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\risultatiRicerca.tpl',
      1 => 1662794105,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_631c519402cb42_98747565 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('tipo', (($tmp = $_smarty_tpl->tpl_vars['tipo']->value ?? null)===null||$tmp==='' ? 'locali' ?? null : $tmp));
$_smarty_tpl->_assignInScope('userlogged', (($tmp = $_smarty_tpl->tpl_vars['error']->value ?? null)===null||$tmp==='' ? 'nouser' ?? null : $tmp));
$_smarty_tpl->_assignInScope('citta', (($tmp = $_smarty_tpl->tpl_vars['citta']->value ?? null)===null||$tmp==='' ? 'a' ?? null : $tmp));
$_smarty_tpl->_assignInScope('nomeEvento', (($tmp = $_smarty_tpl->tpl_vars['nomeEvento']->value ?? null)===null||$tmp==='' ? 'a' ?? null : $tmp));
$_smarty_tpl->_assignInScope('categoria', (($tmp = $_smarty_tpl->tpl_vars['categoria']->value ?? null)===null||$tmp==='' ? 'a' ?? null : $tmp));
$_smarty_tpl->_assignInScope('data', (($tmp = $_smarty_tpl->tpl_vars['data']->value ?? null)===null||$tmp==='' ? 'a' ?? null : $tmp));?>
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Vendor CSS Files -->
    <link href="/template/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="/template/vendor/aos/aos.css" rel="stylesheet">
    <link href="/template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/template/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/template/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/template/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/FacceBeve/template/css/style.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Moderna - v4.9.1
    * Template URL: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>
<header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="index.html"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
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
                    <?php if ($_smarty_tpl->tpl_vars['tipo']->value == "Locali") {?>
                      <?php if ($_smarty_tpl->tpl_vars['nomeLocale']->value != "a") {?>
                         <li>$nomeLocale</li>
                      <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['citta']->value != "a") {?>
                         <li>$citta</li>
                      <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['categoria']->value != "a") {?>
                        <li>$categoria</li>
                      <?php }?>
                    <?php } else { ?>
                      <?php if ($_smarty_tpl->tpl_vars['nomeLocale']->value != "a") {?>
                        <li>$nomeLocale</li>
                      <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['nomeEvento']->value != "a") {?>
                        <li>$nomeEvento</li>
                      <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['citta']->value != "a") {?>
                        <li>$citta</li>
                      <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['data']->value != "a") {?>
                       <li>data</li>
                      <?php }?>
                    <?php }?>
                </ul>


            </div>

        </div>
    </section><!-- End Blog Section -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">

            <div class="row">

                <div class="entries">

                    <article class="entry">

                        <div class="entry-img">
                            <img src="/template/img/blog/blog-1.jpg" alt="" class="img-fluid">
                        </div>

                        <h2 class="entry-title">
                            <a href="infoLocale.html">Locale 1</a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                                        href="">$Proprietario</a></li>
                                <li class="d-flex align-items-center"><i class="fas fa-map-marker-alt"></i> <a
                                        href="">$Localizzazione</a></li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <p>
                                $descrizione
                            </p>
                            <div class="read-more">
                                <a href="infoLocale.html">Visita il locale <i class="fas fa-chevron-circle-right"></i></a>
                            </div>
                        </div>

                    </article><!-- End blog entry -->


                </div><!-- End blog entries list -->
<!--
                <div class="col-lg-4">

                    <div class="sidebar">

                        <h3 class="sidebar-title">Search</h3>
                        <div class="sidebar-item search-form">
                            <form action="">
                                <input type="text">
                                <button type="submit"><i class="bi bi-search"></i></button>
                            </form>
                        </div>

                        <h3 class="sidebar-title">Categories</h3>
                        <div class="sidebar-item categories">
                            <ul>
                                <li><a href="#">General <span>(25)</span></a></li>
                                <li><a href="#">Lifestyle <span>(12)</span></a></li>
                                <li><a href="#">Travel <span>(5)</span></a></li>
                                <li><a href="#">Design <span>(22)</span></a></li>
                                <li><a href="#">Creative <span>(8)</span></a></li>
                                <li><a href="#">Educaion <span>(14)</span></a></li>
                            </ul>
                        </div>


                    </div> -->

                </div><!-- End blog sidebar -->

            </div>

        </div>
    </section><!-- End Blog Section -->

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
