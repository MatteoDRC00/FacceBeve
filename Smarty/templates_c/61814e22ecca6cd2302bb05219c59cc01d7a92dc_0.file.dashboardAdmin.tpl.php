<?php
/* Smarty version 4.2.0, created on 2022-11-08 15:26:14
  from 'C:\xampp\htdocs\FacceBeve\template\dashboardAdmin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_636a6706898587_95843861',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61814e22ecca6cd2302bb05219c59cc01d7a92dc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\dashboardAdmin.tpl',
      1 => 1667835705,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_636a6706898587_95843861 (Smarty_Internal_Template $_smarty_tpl) {
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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

<!-- ======= Header ======= -->
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
                <h2 style="font-weight: bold">Dashboard ADMIN</h2>
            </div>
            <div class="gestioneutente">
                <a href="/Accesso/logout">Esci <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
    </section><!-- End Contact Section -->

    <!-- ======= Contact Section ======= -->
    <section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
        <div class="container">
            <div class="row">
                <table id="customers">
                    <p style="padding: 3px; font-weight: bold; font-size: 20px; text-align: center; color: #17455e;">Utenti Attivi</p>
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Data Iscrizione</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_smarty_tpl->tpl_vars['utentiAttivi']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['utentiAttivi']->value, 'utente');
$_smarty_tpl->tpl_vars['utente']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['utente']->value) {
$_smarty_tpl->tpl_vars['utente']->do_else = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getIscrizione();?>
</td>
                                <td>
                                    <form action="/Admin/sospendiUtente/<?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Sospendi">
                                    </form>
                                </td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($_smarty_tpl->tpl_vars['utentiAttivi']->value)) {?>
                <br>
                <p style="text-align: center">Attualmente non ci sono utenti attivi </p>
            <?php }?>
        </div>

        <div class="container">
            <div class="row">
                <table id="customers">
                    <p style="padding: 3px; font-weight: bold; font-size: 20px; text-align: center; color: #17455e;">Utenti Bannati</p>
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Data Iscrizione</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_smarty_tpl->tpl_vars['utentiBannati']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['utentiBannati']->value, 'utente');
$_smarty_tpl->tpl_vars['utente']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['utente']->value) {
$_smarty_tpl->tpl_vars['utente']->do_else = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getIscrizione();?>
</td>
                                <td>
                                    <form action="/Admin/riattivaUtente/<?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Riattiva">
                                    </form>
                                </td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($_smarty_tpl->tpl_vars['utentiBannati']->value)) {?>
                <br>
                <p style="text-align: center">Attualmente non ci sono utenti bannati </p>
            <?php }?>
        </div>

        <div class="container">
            <div class="row">
                <table id="customers">
                    <p style="padding: 3px; font-weight: bold; font-size: 20px; text-align: center; color: #17455e;">Proprietari di Locali</p>
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_smarty_tpl->tpl_vars['proprietari']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['proprietari']->value, 'proprietario');
$_smarty_tpl->tpl_vars['proprietario']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['proprietario']->value) {
$_smarty_tpl->tpl_vars['proprietario']->do_else = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['proprietario']->value->getUsername();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['proprietario']->value->getNome();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['proprietario']->value->getCognome();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['proprietario']->value->getEmail();?>
</td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($_smarty_tpl->tpl_vars['proprietari']->value)) {?>
                <br>
                <p style="text-align: center">Attualmente non ci sono proprietari di locali </p>
            <?php }?>
        </div>

        <div class="container">
            <div class="row">
                <table id="customers">
                    <p style="padding: 3px; font-weight: bold; font-size: 20px; text-align: center; color: #17455e;">Locali</p>
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Descrizione</th>
                        <th>Localizzazione</th>
                        <th>Proprietario</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_smarty_tpl->tpl_vars['locali']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locali']->value, 'locale');
$_smarty_tpl->tpl_vars['locale']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['locale']->value) {
$_smarty_tpl->tpl_vars['locale']->do_else = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['locale']->value->getDescrizione();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getIndirizzo();?>
, <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getNumCivico();?>
 <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCitta();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['locale']->value->getProprietario()->getUsername();?>
</td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($_smarty_tpl->tpl_vars['locali']->value)) {?>
                <br>
                <p style="text-align: center">Attualmente non ci sono locali </p>
            <?php }?>
        </div>

        <div class="container">
            <div class="row">
                <table id="customers">
                    <p style="padding: 3px; font-weight: bold; font-size: 20px; text-align: center; color: #17455e;">Categorie</p>
                    <thead>
                    <tr>
                        <th>Genere</th>
                        <th>Descrizione</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_smarty_tpl->tpl_vars['categorie']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categorie']->value, 'categoria');
$_smarty_tpl->tpl_vars['categoria']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['categoria']->value) {
$_smarty_tpl->tpl_vars['categoria']->do_else = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['categoria']->value->getGenere();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['categoria']->value->getDescrizione();?>
</td>
                                <td>
                                    <form action="/Admin/rimuoviCategoria/<?php echo $_smarty_tpl->tpl_vars['categoria']->value->getGenere();?>
" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Elimina">
                                    </form>
                                </td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                    <tr>
                        <form action="/Admin/aggiungiCategoria" method="POST" id="aggiuntaCategoria" onsubmit="return validateRegForm(4)">
                            <td><input style="padding: 4px" type="text" placeholder="Genere" name="genere"></td>
                            <td><input style="width: 98%; padding: 4px" type="text" placeholder="Descrizione" name="descrizione"></td>
                            <td><input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Aggiungi"></td>
                        </form>
                    </tbody>
                </table>
            </div>
            <?php if (empty($_smarty_tpl->tpl_vars['categorie']->value)) {?>
                <br>
                <p style="text-align: center">Attualmente non ci sono categorie di locali sul sito </p>
            <?php }?>
        </div>

        <div class="container">
            <div class="row">
                <table id="customers">
                    <p style="padding: 3px; font-weight: bold; font-size: 20px; text-align: center; color: #17455e;">Recensioni Segnalate</p>
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Titolo</th>
                        <th>Descrizione</th>
                        <th>Autore</th>
                        <th>Locale</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_smarty_tpl->tpl_vars['recensioni']->value)) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recensioni']->value, 'rece');
$_smarty_tpl->tpl_vars['rece']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['rece']->value) {
$_smarty_tpl->tpl_vars['rece']->do_else = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getId();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getTitolo();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getDescrizione();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getUtente()->getUsername();?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getLocale()->getNome();?>
</td>
                                <td>
                                    <form action="/Admin/eliminaRecensione/<?php echo $_smarty_tpl->tpl_vars['rece']->value->getId();?>
" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Elimina">
                                    </form>
                                </td>
                                <td>
                                    <form action="/Admin/reinserisciRecensione/<?php echo $_smarty_tpl->tpl_vars['rece']->value->getId();?>
" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Reinserisci">
                                    </form>
                                </td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($_smarty_tpl->tpl_vars['recensioni']->value)) {?>
                <br>
                <p style="text-align: center">Attualmente non ci sono recensioni segnalate </p>
            <?php }?>
        </div>
    </section>

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
