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
            <h1><a href="/Ricerca/mostraHome"><img src="/template/img/logo.png" alt=""><span>FacceBeve</span></a>
            </h1>
        </div>
    </div>
</header>

<div class="login-page">
    <div class="form">
        <form class="login-form" action="/Accesso/registrazioneProprietario" enctype="multipart/form-data" method="POST" name="registrazioneProprietario" onsubmit="return validateRegForm(1)" >
            <h1 style="font-weight: bold">Registrati come proprietario di locali</h1>
            <input type="text" class="form-control" placeholder="nome" name="nome" pattern="[a-zA-Z]+\"/>
            <input type="text" class="form-control" placeholder="cognome" name="cognome" pattern="[a-zA-Z]+\"/>
            <input type="text" placeholder="email" name="email"  {literal}pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"{/literal} title="Deve essere inclusa una chiocciola @ essendo un email"/>
            <input type="text" placeholder="username" name="username"/>
            <input type="password" placeholder="password"  name="password" {literal}pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"{/literal} title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola"/>
            <input type="password" placeholder="Ripeti password" name="password2" {literal}pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"{/literal} title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola"/>
            <h1>Aggiungi l'immagine di profilo</h1>
            <input name="img_profilo" class="p-2" type="file">
            <button type="submit">Registrati</button>
            <p class="message">Hai gi&agrave un account? <a href="login.html">Accedi</a></p>
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
<script src="/template/js/main.js"></script>
</body>
</html>
