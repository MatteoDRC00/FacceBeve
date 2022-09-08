<?php
/* Smarty version 4.2.0, created on 2022-09-08 11:17:17
  from 'C:\xampp1\htdocs\FacceBeve\Smarty\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_6319b31d52e558_19257596',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c701774acbf576e9d2ce2ce083dfa03664afb139' => 
    array (
      0 => 'C:\\xampp1\\htdocs\\FacceBeve\\Smarty\\templates\\login.tpl',
      1 => 1662628280,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6319b31d52e558_19257596 (Smarty_Internal_Template $_smarty_tpl) {
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
    <link href="/Smarty/template/assets/img/favicon.png" rel="icon">
    <link href="/Smarty/template/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/Smarty/template/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <!--<link href="/Smarty/template/assets/vendor/aos/aos.css" rel="stylesheet">-->
    <link href="/Smarty/template/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/Smarty/template/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/Smarty/template/assets/css/log.css" rel="stylesheet">

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
            <h1><a href="home.html"><img src="/Smarty/template/assets/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>
    </div>

</header>

<div class="login-page">
    <div class="form">
        <form class="login-form"action="/FacceBeve/Utente/login" method="POST">
            <input type="text" placeholder="username" name="username">
            <input type="password" placeholder="password" name="password"/>
            <button  type="submit" >Login</button>
            <p class="message">Non sei ancora registrato?<a href="registrazioneUtente.html">Crea un account utente</a></p>
            <p class="message">Hai bisogno di pubblicizzare il tuo locale?<a href="registrazioneProprietario.html">Crea un account proprietario</a></p>
        </form>
        <div style="color: red;">
            <?php echo '<?php'; ?>
 if $error!='ok'
                    echo "Attenzione! Username e/o password errati!" <?php echo '?>'; ?>

        </div>
    </div>
</div>
<!--<?php echo '<script'; ?>
 src="/Smarty/template/assets/js/main.js"><?php echo '</script'; ?>
>-->
</body>
</html>
<?php }
}
