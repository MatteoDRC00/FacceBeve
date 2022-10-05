<?php
/* Smarty version 4.2.0, created on 2022-10-05 09:28:54
  from 'C:\xampp\htdocs\FacceBeve\template\registrazioneUtente.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_633d323631f091_35524372',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c20b6bf5f02e1972c0cff8ba77bb2836e646beda' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\registrazioneUtente.tpl',
      1 => 1664954932,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_633d323631f091_35524372 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<!--<?php $_smarty_tpl->_assignInScope('error', (($tmp = $_smarty_tpl->tpl_vars['error']->value ?? null)===null||$tmp==='' ? 'ok' ?? null : $tmp));?> -->
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sign in</title>
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
    <link href="/template/vendor/aos/aos.css" rel="stylesheet">
    <link href="/template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/template/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/template/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/template/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/template/css/log.css" rel="stylesheet">

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
    <div class="form">
        <form class="login-form" action="/Accesso/registrazioneUtente" enctype="multipart/form-data" method="POST" name="registrazioneUtente" onsubmit="return validateRegForm(0)">
            <h1 style="font-weight: bold; font-size: 24px">Registrati come utente</h1>
            <input type="text" class="form-control" placeholder="nome" name="nome" pattern="[a-zA-Z]+\"/>
            <input type="text" class="form-control" placeholder="cognome" name="cognome" pattern="[a-zA-Z]+\"/>
            <input type="text" placeholder="email" name="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Deve essere inclusa una chiocciola @ essendo un email"/>
            <input type="text" placeholder="username" name="username"/>
            <input type="password" placeholder="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola"/>
            <input type="password" placeholder="Ripeti password" name="password2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola"/>
            <h1>Aggiungi l'immagine di profilo</h1>
            <input name="img_profilo" class="p-2" type="file">
            <button type="submit">Registrati</button>
            <p class="message">Hai gi&agrave un account? <a href="login.html">Accedi</a></p>
        </form>
    </div>
</div>
<?php echo '<script'; ?>
 src="/template/js/main.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
