<!DOCTYPE html>
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
                <h2>Dashboard ADMIN</h2>
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
                    {if !empty($utentiAttivi)}
                        {foreach $utentiAttivi as $utente}
                            <tr>
                                <td>{$utente->getUsername()}</td>
                                <td>{$utente->getNome()}</td>
                                <td>{$utente->getCognome()}</td>
                                <td>{$utente->getEmail()}</td>
                                <td>{$utente->getIscrizione()}</td>
                                <td>
                                    <form action="/Admin/sospendiUtente/{$utente->getUsername()}" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Sospendi">
                                    </form>
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    </tbody>
                </table>
            </div>
            {if empty($utentiAttivi)}
                <br>
                <p style="text-align: center">Attualmente non ci sono utenti attivi </p>
            {/if}
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
                    {if !empty($utentiBannati)}
                        {foreach $utentiBannati as $utente}
                            <tr>
                                <td>{$utente->getUsername()}</td>
                                <td>{$utente->getNome()}</td>
                                <td>{$utente->getCognome()}</td>
                                <td>{$utente->getEmail()}</td>
                                <td>{$utente->getIscrizione()}</td>
                                <td>
                                    <form action="/Admin/riattivaUtente/{$utente->getUsername()}" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Riattiva">
                                    </form>
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    </tbody>
                </table>
            </div>
            {if empty($utentiBannati)}
                <br>
                <p style="text-align: center">Attualmente non ci sono utenti bannati </p>
            {/if}
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
                    {if !empty($proprietari)}
                        {foreach $proprietari as $proprietario}
                            <tr>
                                <td>{$proprietario->getUsername()}</td>
                                <td>{$proprietario->getNome()}</td>
                                <td>{$proprietario->getCognome()}</td>
                                <td>{$proprietario->getEmail()}</td>
                            </tr>
                        {/foreach}
                    {/if}
                    </tbody>
                </table>
            </div>
            {if empty($proprietari)}
                <br>
                <p style="text-align: center">Attualmente non ci sono proprietari di locali </p>
            {/if}
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
                    {if !empty($categorie)}
                        {foreach $categorie as $categoria}
                            <tr>
                                <td>{$categoria->getGenere()}</td>
                                <td>{$categoria->getDescrizione()}</td>
                                <td>
                                    <form action="/Admin/rimuoviCategoria/{$categoria->getGenere()}" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Elimina">
                                    </form>
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    <tr>
                        <form action="/Admin/aggiungiCategoria" method="POST" id="aggiuntaCategoria" onsubmit="return validateRegForm(4)">
                            <td><input style="padding: 4px" type="text" placeholder="Genere" name="genere"></td>
                            <td><input style="padding: 4px" type="text" placeholder="Descrizione" name="descrizione"></td>
                            <td><input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Aggiungi"></td>
                        </form>
                    </tbody>
                </table>
            </div>
            {if empty($categorie)}
                <br>
                <p style="text-align: center">Attualmente non ci sono categorie di locali sul sito </p>
            {/if}
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
                    {if !empty($recensioni)}
                        {foreach $recensioni as $rece}
                            <tr>
                                <td>{$rece->getId()}</td>
                                <td>{$rece->getTitolo()}</td>
                                <td>{$rece->getDescrizione()}</td>
                                <td>{$rece->getUtente()->getUsername()}</td>
                                <td>{$rece->getLocale()->getNome()}</td>
                                <td>
                                    <form action="/Admin/eliminaRecensione/{$rece->getId()}" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Elimina">
                                    </form>
                                </td>
                                <td>
                                    <form action="/Admin/reinserisciRecensione/{$rece->getId()}" method="POST">
                                        <input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Reinserisci">
                                    </form>
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    </tbody>
                </table>
            </div>
            {if empty($recensioni)}
                <br>
                <p style="text-align: center">Attualmente non ci sono recensioni segnalate </p>
            {/if}
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
<script src="/template/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="/template/vendor/aos/aos.js"></script>
<script src="/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/template/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/template/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/template/vendor/waypoints/noframework.waypoints.js"></script>
<script src="/template/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/template/js/main.js"></script>

</body>

</html>