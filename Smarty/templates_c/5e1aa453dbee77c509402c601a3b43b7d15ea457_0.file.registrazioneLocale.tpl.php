<?php
/* Smarty version 4.2.0, created on 2022-09-17 08:46:42
  from 'C:\xampp\htdocs\FacceBeve\template\registrazioneLocale.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_63256d52c8a434_53683525',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e1aa453dbee77c509402c601a3b43b7d15ea457' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\registrazioneLocale.tpl',
      1 => 1663355896,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63256d52c8a434_53683525 (Smarty_Internal_Template $_smarty_tpl) {
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
            <h1><a href="/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>

    </div>
</header>

<main id="main">

    <!-- ======= Contact Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Crea un nuovo locale</h2>
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
                    <form action="/GestioneLocale/creaLocale" enctype="multipart/form-data" method="POST" class="aggiorna" name="registrazioneLocale" onsubmit="return validateRegForm(2)">
                        <p>INSERISCI LE INFORMAZIONI DEL LOCALE</p>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci il nome: </label><br>
                            <input type="text" name="nomeLocale" required>
                        </div>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci la descrizione: </label><br>
                            <textarea type="text" name="descrizioneLocale" required></textarea>
                        </div>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci il numero di telefono: </label><br>
                            <input type="text" name="numeroLocale" required>
                        </div>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci la localizzazione: </label><br>
                            <input type="text" name="indirizzoLocale" placeholder="Inserisci l'indirizzo" required>
                            <input type="text" name="civicoLocale" placeholder="Inserisci il numero civico" title="Attenzione, inserire un numero." required>
                            <input type="text" name="cittaLocale" placeholder="Inserisci città" required>
                            <input type="text" name="CAPLocale" placeholder="Inserisci il CAP" title="Attenzione il CAP è un codice numerico." required>
                        </div>
                        <div class="form-example">
                            <label style="font-weight: bold">Inserisci le categorie: </label><br>
                            <?php if (!empty($_smarty_tpl->tpl_vars['categorie']->value)) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categorie']->value, 'genere');
$_smarty_tpl->tpl_vars['genere']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['genere']->value) {
$_smarty_tpl->tpl_vars['genere']->do_else = false;
?>
                                    <input type="checkbox" name="genereLocale[]" value="<?php echo $_smarty_tpl->tpl_vars['genere']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['genere']->value;?>

                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                                <p>Non ci sono categorie</p>
                            <?php }?>
                        </div>
                        <div class="form-example">
                            <label style="font-weight: bold">Lunedi: </label><input type="time" name="orarioapertura[]"> <input type="time" name="orariochiusura[]">
                                <input type="checkbox" id="close" name="close[]" value="0">
                                <label for="close"> Chiuso</label><br>
                            <label style="font-weight: bold">Martedi: </label><input type="time" name="orarioapertura[]"> <input type="time" name="orariochiusura[]">
                                <input type="checkbox" name="close[]" value="1">
                                <label for="close"> Chiuso</label><br>
                            <label style="font-weight: bold">Mercoledi: </label><input type="time" name="orarioapertura[]"> <input type="time" name="orariochiusura[]">
                                <input type="checkbox" name="close[]" value="2">
                                <label for="close"> Chiuso</label><br>
                            <label style="font-weight: bold">Giovedi: </label><input type="time" name="orarioapertura[]"> <input type="time" name="orariochiusura[]">
                                <input type="checkbox" name="close[]" value="3">
                                <label for="close"> Chiuso</label><br>
                            <label style="font-weight: bold">Venerdi: </label><input type="time" name="orarioapertura[]"> <input type="time" name="orariochiusura[]">
                                <input type="checkbox" name="close[]" value="4">
                                <label for="close"> Chiuso</label><br>
                            <label style="font-weight: bold">Sabato: </label><input type="time" name="orarioapertura[]"> <input type="time" name="orariochiusura[]">
                                <input type="checkbox" name="close[]" value="5">
                                <label for="close"> Chiuso</label><br>
                            <label style="font-weight: bold">Domenica: </label><input type="time" name="orarioapertura[]"> <input type="time" name="orariochiusura[]">
                                <input type="checkbox" name="close[]" value="6">
                                <label for="close"> Chiuso</label><br>
                        </div>
                        <div class="form-example">
                            <p>AGGIUNGI LE IMMAGINI</p>
                            <input name="img_locale" class="w-50 p-2 m-2" type="file" required><br>
                        </div>
                        <button type="submit" class="btnAggiorna">CREA IL LOCALE</button>
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
