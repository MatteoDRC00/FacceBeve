<!DOCTYPE html>
<!-- {assign var='error' value=$error|default:'ok'} -->
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sign in</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Favicons -->
    <link href="/FacceBeve/template/img/favicon.png" rel="icon">
    <link href="/FacceBeve/template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
          rel="stylesheet">


    <!-- Vendor CSS Files -->
    <link href="/FacceBeve/template/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/aos/aos.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/FacceBeve/template/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/FacceBeve/template/css/style.css" rel="stylesheet">


</head>
<body>

<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/FacceBeve/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a>
            </h1>
        </div>
    </div>
</header>

<div class="login-page">
    <div class="form">
        <form class="login-form" action="/FacceBeve/Accesso/registrazioneProprietario" enctype="multipart/form-data" method="POST" id="registrazioneUser" onsubmit="return validateRegForm(1)" >
            <h1 style="font-weight: bold; font-size: 24px">Registrati come proprietario di locali</h1>
            <input type="text" class="form-control" placeholder="nome" name="nome" pattern="[a-zA-Z]+\"/>
            <input type="text" class="form-control" placeholder="cognome" name="cognome" pattern="[a-zA-Z]+\"/>
            <input type="text" placeholder="email" name="email"  {literal}pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"{/literal} title="Deve essere inclusa una chiocciola @ essendo un email"/>
            <input type="text" placeholder="username" name="username"/>
            <input type="password" placeholder="password"  name="password" {literal}pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"{/literal} title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola"/>
            <input type="password" placeholder="ripeti password" name="password2" {literal}pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"{/literal} title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola"/>
            <h1>Aggiungi l'immagine di profilo</h1>
            <input name="img_profilo" class="p-2" type="file">
            <button type="submit">Registrati</button>
            <p class="message">Hai gi&agrave un account? <a href="/FacceBeve/Accesso/formLogin">Accedi</a></p>
        </form>
        <!--  {if $errorSize!='ok'}
          <div style="color: red;">
              <p align="center">Attenzione! Formato immagine troppo grande!  </p>
          </div>
          {/if}
          {if $errorType!='ok'}
          <div style="color: red;">
              <p align="center">Attenzione! Formato immagine non supportato (provare con .png o .jpg)!  </p>
          </div>
          {/if}
          {if $errorEmail!='ok'}
          <div style="color: red;">
              <p align="center">Attenzione! Email già esistente!  </p>
          </div>
          {/if} -->
    </div>
</div>
<!-- Vendor JS Files -->
<script src="/FacceBeve/template/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="/FacceBeve/template/vendor/aos/aos.js"></script>
<script src="/FacceBeve/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/FacceBeve/template/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/FacceBeve/template/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/FacceBeve/template/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/FacceBeve/template/vendor/waypoints/noframework.waypoints.js"></script>
<script src="/FacceBeve/template/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/FacceBeve/template/js/main.js"></script>
</body>
</html>
