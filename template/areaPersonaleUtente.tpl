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
                <h2>Area Personale</h2>
            </div>
            <div class="gestioneutente">
                <a href="#locali">I Tuoi Locali Preferiti</a>
                <a href="/Accesso/logout">Esci <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
    </section><!-- End Contact Section -->

    <!-- ======= Contact Section ======= -->
    <section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-12 bg-white p-0 px-3 py-3 mb-3">
                            <div class="d-flex flex-column align-items-center">
                                <img class="photo" src="data:{$type};base64,{$pic64}" alt="immagine profilo">
                                <p class="fw-bold h4 mt-3">{$nome} {$cognome}</p>
                                <p class="text-muted" style="font-weight: bold">{$username}</p>
                                <p class="text-muted mb-3">{$email}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 ps-md-4">
                    <div class="row">
                        <div class="col-12 bg-white px-3 mb-3 pb-3">
                            {if !empty($tipo) && $tipo=="user"}
                                <h3 class="errore" style="font-family: Arial;color: yellow;font-size: 17px; text-align: center">{$message}</h3>
                            {/if}
                            <form action="/Profilo/modificaUsername" method="POST" class="aggiorna">
                                <p>Modifica l'username</p>
                                <div class="form-example">
                                    <label>Inserisci il nuovo username: </label><br>
                                    <input type="text" name="newusername" id="newusername" required>
                                </div>
                                <button type="submit" class="btnAggiorna">Modifica username</button>
                            </form>
                            {if !empty($tipo) && $tipo=="email"}
                                <h3 class="errore" style="font-family: Arial;color: yellow;font-size: 17px; text-align: center">{$message}</h3>
                            {/if}
                            <form action="/Profilo/modificaEmail" method="POST" class="aggiorna">
                                <p>Modifica l'email</p>
                                <div class="form-example">
                                    <label>Inserisci la nuova email: </label><br>
                                    <input type="text" name="newemail" id="newemail" required>
                                </div>
                                <button type="submit" class="btnAggiorna">Modifica email</button>
                            </form>
                            {if !empty($tipo) && $tipo=="password"}
                                <h3 class="errore" style="font-family: Arial;color: yellow;font-size: 17px; text-align: center">{$message}</h3>
                            {/if}
                            <form action="/Profilo/modificaPassword" method="POST" class="aggiorna">
                                <p>Modifica la password</p>
                                <div class="form-example">
                                    <label>Inserisci la vecchia password: </label><br>
                                    <input type="password" name="password" id="password" required>
                                </div>
                                <div class="form-example">
                                    <label>Inserisci la nuova password: </label><br>
                                    <input type="password" name="newpassword" id="newpassword" required>
                                </div>
                                <button type="submit" class="btnAggiorna">Modifica password</button>
                            </form>
                        </div>
                        <div class="col-12 bg-white px-3 pb-2">
                            <form action="/Profilo/modificaImmagineProfilo" enctype="multipart/form-data" method="POST" class="aggiorna"> <!-- aggiungin i controlli -->
                                <p>Modifica l'immagine di profilo</p>
                                <input name="newimg_profilo" class="w-50 p-2 m-2" type="file" required><br>
                                <button type="submit" class="btnAggiorna">Modifica Immagine</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->

    <section class="services">
        <div class="container">

            <div class="row">
                <h2 id="locali">Ecco i tuoi locali preferiti:</h2>
            </div>

            <div id="blog" class="blog">
                <div class="container" data-aos="fade-up">

                    <div class="row" style="color: #f0c040">

                        <div class="entries">
                            {if !empty($locali_preferiti)}
                                {foreach $locali_preferiti as $locale}
                                    <a href="/Ricerca/dettagliLocale/{$locale->getID()}">{$locale->getNome()}   <i class="fa fa-angle-right"></i></a>
                                {/foreach}
                            {else}
                                <p>Non possiedi locali preferiti</p>
                            {/if}

                        </div>
                    </div>
                </div>
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