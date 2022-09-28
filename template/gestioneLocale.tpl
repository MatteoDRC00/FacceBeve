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
                <h2 style="font-weight: bold">Gestisci locale: <a href="/Ricerca/dettagliLocale/{$locale->getId()}">{$locale->getNome()}</a></h2>
            </div>

            <div class="gestioneutente">
                <a href="/GestioneEvento/mostraFormCreaEvento/{$locale->getId()}">Aggiungi evento</a>
                <a href="#eventi">Eventi organizzati</a>
                <a href="/Profilo/mostraProfilo">Torna all'Area Personale <i class="fa fa-sign-out"></i></a>
            </div>

        </div>
    </section><!-- End Contact Section -->

    <!-- ======= Contact Section ======= -->
    <section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
        <div class="container">
            <div class="row">
                <div class="col-6 bg-white px-3 mb-3 pb-3">
                    <form action="/GestioneLocale/modificaNomeLocale/{$locale->getId()}" method="POST" class="aggiorna">
                        <p>MODIFICA LE INFORMAZIONI DEL LOCALE</p>
                        <div class="form-example">
                            <label style="font-weight: bold">Aggiorna il nome: </label><br>
                            <input type="text" name="nomeLocale" required>
                        </div>
                        <button type="submit" class="btnAggiorna">AGGIORNA NOME <i class="fa fa-refresh"></i></button>
                    </form>
                    <form action="/GestioneLocale/modificaDescrizioneLocale/{$locale->getId()}" method="POST" class="aggiorna">
                        <div class="form-example">
                            <label style="font-weight: bold">Aggiorna la descrizione: </label><br>
                            <textarea type="text" name="descrizioneLocale" required></textarea>
                        </div>
                        <button type="submit" class="btnAggiorna">AGGIORNA DESCRIZIONE <i class="fa fa-refresh"></i></button>
                    </form>
                    <form action="/GestioneLocale/modificaCategorieLocale/{$locale->getId()}" method="POST" class="aggiorna">
                        <div class="form-example">
                            <label style="font-weight: bold">Aggiorna la categoria: </label><br>
                            {if !empty($categorie)}
                                {foreach $categorie as $c}
                                    <input type="checkbox" name="genereLocale[]" value="{$c->getGenere()}">{$c->getGenere()}
                                {/foreach}
                            {else}
                                <p>Non ci sono categorie</p>
                            {/if}
                        </div>
                        <button type="submit" class="btnAggiorna">AGGIORNA CATEGORIA <i class="fa fa-refresh"></i></button>
                    </form>
                    <form action="/GestioneLocale/modificaNumTelefonoLocale/{$locale->getId()}" method="POST" class="aggiorna">
                        <div class="form-example">
                            <label style="font-weight: bold">Aggiorna il numero di telefono: </label><br>
                            <input type="tel" name="numeroLocale" required>
                        </div>
                        <button type="submit" class="btnAggiorna">AGGIORNA NUMERO DI TELEFONO <i class="fa fa-refresh"></i></button>
                    </form>
                    <form action="/GestioneLocale/modificaLocalizzazioneLocale/{$locale->getId()}" method="POST" class="aggiorna">
                        <div class="form-example">
                            <label style="font-weight: bold">Aggiorna la localizzazione: </label><br>
                            <input type="text" name="indirizzoLocale" placeholder="Nuovo indirizzo">
                            <input type="text" name="civicoLocale" placeholder="Nuovo numero civico">
                            <input type="text" name="cittaLocale" placeholder="Nuova città">
                            <input type="text" name="CAPLocale" placeholder="Nuovo CAP">
                        </div>
                        <button type="submit" class="btnAggiorna">AGGIORNA LOCALIZZAZIONE <i class="fa fa-refresh"></i></button>
                    </form>
                    <form action="/GestioneLocale/modificaOrarioLocale/{$locale->getId()}" method="POST" class="aggiorna">
                        <div class="form-example">
                            <label style="font-weight: bold">Aggiorna l'orario di apertura e chiusura: </label><br>
                            <div class="">
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
                        </div>
                        <button type="submit" class="btnAggiorna">AGGIORNA ORARIO SETTIMANALE <i class="fa fa-refresh"></i></button>
                    </form>
                </div>
                <div class="col-6 bg-white px-3 mb-3 pb-3">
                    <form action="/GestioneLocale/addImmagineLocale/{$locale->getId()}" enctype="multipart/form-data" method="POST" class="aggiorna"> <!-- aggiungin i controlli -->
                        <p>AGGIUNGI LE IMMAGINI</p>
                        <input name="img_locale" class="w-50 p-2 m-2" type="file" required><br>
                        <button type="submit" class="btnAggiorna">AGGIUNGI IMMAGINE</button>
                    </form>
                    <p style="font-weight: bold; font-size: 20px; color: #0d2735; text-align: center">ELIMINA LE IMMAGINI</p>
                    {if !empty(($immagini))}
                        {foreach $immagini as $img}
                            <form action="/GestioneLocale/eliminaImmagineLocale/{$img->getId()}" method="POST" class="aggiorna"> <!-- aggiungin i controlli -->
                                <img style="height: 120px; width: 120px; border-radius: 25%" src="data:{$img->getType()};base64,{$img->getImmagine()}" alt="immagine profilo">
                                <button type="submit" class="btnAggiorna">ELIMINA IMMAGINE</button>
                            </form>
                            <br>
                        {/foreach}
                    {else}
                        <p style="text-align: center">Non sono presenti immagini per il locale</p>
                    {/if}
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->

    <section class="services">
        <div class="container">

            <div class="row">
                <h2 id="eventi">Eventi organizzati:</h2>
            </div>
            <div class="items-body">
                {if !empty($eventi)}
                    <ul>
                        {foreach $eventi as $evento}
                            <li style="padding: 3px;">
                                <div class="items-body-content row-cols-3">
                                    <p>{$evento->getNome()}</p>
                                    <a href="/GestioneEvento/mostraFormGestioneEvento/{$evento->getId()}"><input type="button" value="Gestisci evento"></a>
                                    <a href="/GestioneEvento/eliminaEvento/{$evento->getId()}"><input type="button" value="Elimina evento"></a>
                                </div>
                            </li>
                        {/foreach}
                    </ul>
                {else}
                    <p>Non ci sono eventi in programma</p>
                {/if}
            </div>
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

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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