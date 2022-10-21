<?php
/* Smarty version 4.2.0, created on 2022-10-20 18:18:24
  from '/membri/faccebeve/template/registrazioneEvento.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_635174d0f1a583_16921099',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '755fa71a16d22d57f2eaddccd378663413578e7c' => 
    array (
      0 => '/membri/faccebeve/template/registrazioneEvento.tpl',
      1 => 1666260406,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_635174d0f1a583_16921099 (Smarty_Internal_Template $_smarty_tpl) {
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

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

    <!-- ======= Contact Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-weight: bold">Crea un nuovo evento per: <a href="/GestioneLocale/mostraInfoLocale/<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
"><?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
</a></h2>
            </div>

            <div class="gestioneutente">
                <a href="/Profilo/mostraProfilo">Torna all'Area Personale <i class="fa fa-sign-out"></i></a>
            </div>

        </div>
    </section><!-- End Contact Section -->

    <!-- ======= Contact Section ======= -->
    <section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
        <div class="container">
            <div class="row">
                <div class="col-12 bg-white px-3 mb-3 pb-3">
                    <form action="/GestioneEvento/creaEvento/<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
"  enctype="multipart/form-data" method="POST" class="aggiorna" id="registrazioneEvento" onsubmit="return validateRegForm(3)">
                        <p>Inserisci informazioni sull'evento</p>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci il nome: </label><br>
                            <input type="text" name="nomeEvento" required>
                        </div>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci la descrizione: </label><br>
                            <textarea type="text" name="descrizioneEvento"></textarea>
                        </div>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci la data: </label><br>
                            <input type="date" name="dataEvento" required>
                        </div>
                        <div class="form-example">
                            <p>AGGIUNGI LA LOCANDINA</p>
                            <input name="img_evento" class="w-50 p-2 m-2" type="file" required><br>
                        </div>
                        <button type="submit" class="btnAggiorna">INSERISCI</button>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->

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

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
