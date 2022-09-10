<!DOCTYPE html>
<!--{assign var='error' value=$error|default:'ok'}-->
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
            <h1><a href="Ricerca/Home"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a></h1>
        </div>
    </div>

</header>

<div class="login-page">
    <div class="form">
        <form class="login-form" action="/Accesso/login" method="POST">
            <input type="text" placeholder="username" name="username">
            <input type="password" placeholder="password" name="password"/>
            <button  type="submit" >Login</button>
            <p class="message">Non sei ancora registrato?<a href="registrazioneUtente.html">Crea un account utente</a></p>
            <p class="message">Hai bisogno di pubblicizzare il tuo locale?<a href="registrazioneProprietario.html">Crea un account proprietario</a></p>
        </form>
        <div style="color: red;">
            <?php if $error!='ok'
                    echo "Attenzione! Username e/o password errati!" ?>
        </div>
    </div>
</div>
<!--<script src="/Smarty/template/assets/js/main.js"></script>-->
</body>
</html>
