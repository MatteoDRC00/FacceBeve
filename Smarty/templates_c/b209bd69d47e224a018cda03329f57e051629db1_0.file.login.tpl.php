<?php
/* Smarty version 4.2.0, created on 2022-10-20 18:08:47
  from '/membri/faccebeve/template/login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_6351728f64b9c1_56121229',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b209bd69d47e224a018cda03329f57e051629db1' => 
    array (
      0 => '/membri/faccebeve/template/login.tpl',
      1 => 1666260406,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6351728f64b9c1_56121229 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<!--<?php $_smarty_tpl->_assignInScope('error', (($tmp = $_smarty_tpl->tpl_vars['error']->value ?? null)===null||$tmp==='' ? 'ok' ?? null : $tmp));?>-->
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Favicons -->
    <link href="/template/img/favicon.png" rel="icon">
    <link href="/template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/template/vendor/animate.css/animate.min.css" rel="stylesheet">
    <!--<link href="/Smarty/template/assets/vendor/aos/aos.css" rel="stylesheet">-->
    <link href="/template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/template/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/template/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/template/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/template/css/log.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Moderna - v4.9.1
    * Template URL: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->

</head>
<body>
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>
    </div>

</header>

<div class="login-page">
    <?php if (!empty($_smarty_tpl->tpl_vars['errore']->value)) {?>
        <h3 class="errore" style="font-family: Arial;color: yellow;font-size: 17px; text-align: center"><?php echo $_smarty_tpl->tpl_vars['errore']->value;?>
</h3>
    <?php }?>

    <div class="form">
        <form class="login-form" action="/Accesso/login" method="POST">
            <input type="text" placeholder="username" name="username">
            <input type="password" placeholder="password" name="password"/>
            <button  type="submit" >Login</button>
            <p class="message">Non sei ancora registrato?</p>
            <a href="/Accesso/formRegistrazioneUtente" style="font-size: 12px">Crea un account utente</a>

            <p class="message">Hai bisogno di pubblicizzare il tuo locale?</p>
            <a href="/Accesso/formRegistrazioneProprietario" style="font-size: 12px">Crea un account proprietario</a>
        </form>
    </div>
</div>
<!--<?php echo '<script'; ?>
 src="/Smarty/template/assets/js/main.js"><?php echo '</script'; ?>
>-->
</body>
</html>
<?php }
}
