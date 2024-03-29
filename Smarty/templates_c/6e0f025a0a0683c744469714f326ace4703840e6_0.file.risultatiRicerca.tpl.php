<?php
/* Smarty version 4.2.0, created on 2022-10-20 17:41:44
  from '/membri/faccebeve/template/risultatiRicerca.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_63516c38ab8c98_40294810',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6e0f025a0a0683c744469714f326ace4703840e6' => 
    array (
      0 => '/membri/faccebeve/template/risultatiRicerca.tpl',
      1 => 1666260411,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63516c38ab8c98_40294810 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('tipo', (($tmp = $_smarty_tpl->tpl_vars['tipo']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('userlogged', (($tmp = $_smarty_tpl->tpl_vars['error']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('citta', (($tmp = $_smarty_tpl->tpl_vars['citta']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('nomeEvento', (($tmp = $_smarty_tpl->tpl_vars['nomeEvento']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('nomeLocale', (($tmp = $_smarty_tpl->tpl_vars['nomeLocale']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('locali', (($tmp = $_smarty_tpl->tpl_vars['locali']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('categoria', (($tmp = $_smarty_tpl->tpl_vars['categoria']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('data', (($tmp = $_smarty_tpl->tpl_vars['data']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('array', (($tmp = $_smarty_tpl->tpl_vars['array']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));?>
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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

    <!-- ======= Blog Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex">
                <div>
                    <h2 style="font-weight: bold">Risultati per:</h2>
                </div>
                <div>
                    <ul>
                        <?php if ($_smarty_tpl->tpl_vars['tipo']->value == "Locali") {?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['nomeLocale']->value))) {?>
                                <li style="font-size: 20px"><strong>Nome locale: </strong><?php echo $_smarty_tpl->tpl_vars['nomeLocale']->value;?>
</li>
                            <?php }?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['citta']->value))) {?>
                                <li style="font-size: 20px"><strong>Citt&agrave locale: </strong><?php echo $_smarty_tpl->tpl_vars['citta']->value;?>
</li>
                            <?php }?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['categoria']->value))) {?>
                                <li style="font-size: 20px"><strong>Categoria locale: </strong><?php echo $_smarty_tpl->tpl_vars['categoria']->value;?>
</li>
                            <?php }?>
                        <?php } else { ?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['citta']->value))) {?>
                                <li style="font-size: 20px"><strong>Citt&agrave evento: </strong><?php echo $_smarty_tpl->tpl_vars['citta']->value;?>
</li>
                            <?php }?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['nomeLocale']->value))) {?>
                                <li style="font-size: 20px"><strong>Nome locale: </strong><?php echo $_smarty_tpl->tpl_vars['nomeLocale']->value;?>
</li>
                            <?php }?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['nomeEvento']->value))) {?>
                                <li style="font-size: 20px"><strong>Nome evento: </strong><?php echo $_smarty_tpl->tpl_vars['nomeEvento']->value;?>
</li>
                            <?php }?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['dataEvento']->value))) {?>
                                <li style="font-size: 20px"><strong>Data evento: </strong><?php echo $_smarty_tpl->tpl_vars['dataEvento']->value;?>
</li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>

            </div>
        </div>
    </section>
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <?php if (!empty($_smarty_tpl->tpl_vars['array']->value)) {?>
                    <article class="entry">
                    <?php if ($_smarty_tpl->tpl_vars['tipo']->value == "Locali") {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['array']->value, 'locale');
$_smarty_tpl->tpl_vars['locale']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['locale']->value) {
$_smarty_tpl->tpl_vars['locale']->do_else = false;
?>
                            <div class="entry-img">
                                <?php if (is_null($_smarty_tpl->tpl_vars['locale']->value->getPrimaImg())) {?>
                                    <img class="photo" src="/template/img/no_foto.jpg" alt="immagine locale" width="200px" height="100px" style="border-radius:5px">
                                    <?php } else { ?>
                                    <img class="photo" src="data:<?php echo $_smarty_tpl->tpl_vars['locale']->value->getPrimaImg()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['locale']->value->getPrimaImg()->getImmagine();?>
" alt="immagine locale" width="200px" height="100px" style="border-radius:5px">
                                <?php }?>
                            </div>
                            <h2 class="entry-title" style="width: 400px">
                                <a href="/Ricerca/dettagliLocale/<?php echo $_smarty_tpl->tpl_vars['locale']->value->getId();?>
"><?php echo $_smarty_tpl->tpl_vars['locale']->value->getNome();?>
</a>
                            </h2>
                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i>
                                        <?php echo $_smarty_tpl->tpl_vars['locale']->value->getProprietario()->getUsername();?>
</li>
                                    <li class="d-flex align-items-center"><i class="fas fa-map-marker-alt"></i>
                                        <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getIndirizzo();?>

                                        ,<?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getNumCivico();?>

                                        , <?php echo $_smarty_tpl->tpl_vars['locale']->value->getLocalizzazione()->getCitta();?>

                                    </li>
                                </ul>
                            </div>
                            <div class="entry-content">
                                <p>
                                    <?php echo $_smarty_tpl->tpl_vars['locale']->value->getDescrizione();?>

                                </p>
                            </div>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['array']->value, 'evento');
$_smarty_tpl->tpl_vars['evento']->iteration = 0;
$_smarty_tpl->tpl_vars['evento']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['evento']->value) {
$_smarty_tpl->tpl_vars['evento']->do_else = false;
$_smarty_tpl->tpl_vars['evento']->iteration++;
$__foreach_evento_1_saved = $_smarty_tpl->tpl_vars['evento'];
?>
                            <div class="entry-img">
                                <img class="photo"
                                     src="data:<?php echo $_smarty_tpl->tpl_vars['evento']->value->getImg()->getType();?>
;base64,<?php echo $_smarty_tpl->tpl_vars['evento']->value->getImg()->getImmagine();?>
"
                                     alt="immagine evento" width="200px" height="100px" style="border-radius:5px">
                            </div>
                            <h2 class="entry-title" style="width: 400px">
                                <?php echo $_smarty_tpl->tpl_vars['evento']->value->getNome();?>

                            </h2>
                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i>
                                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['evento']->iteration-1;
$_prefixVariable1 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['locali']->value[$_prefixVariable1]->getNome();?>
</li>
                                    <li class="d-flex align-items-center"><i class="fas fa-map-marker-alt"></i>
                                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['evento']->iteration-1;
$_prefixVariable2 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['locali']->value[$_prefixVariable2]->getLocalizzazione()->getIndirizzo();?>

                                        ,<?php ob_start();
echo $_smarty_tpl->tpl_vars['evento']->iteration-1;
$_prefixVariable3 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['locali']->value[$_prefixVariable3]->getLocalizzazione()->getNumCivico();?>

                                        , <?php ob_start();
echo $_smarty_tpl->tpl_vars['evento']->iteration-1;
$_prefixVariable4 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['locali']->value[$_prefixVariable4]->getLocalizzazione()->getCitta();?>

                                    </li>
                                    <li class="d-flex align-items-center"><i class="bi bi-pin"></i>
                                        <?php echo $_smarty_tpl->tpl_vars['evento']->value->getData();?>
</li>
                                </ul>
                            </div>
                            <div class="entry-content">
                                <p>
                                    <?php echo $_smarty_tpl->tpl_vars['evento']->value->getDescrizione();?>

                                </p>
                                <div class="read-more">
                                    <a href="/Ricerca/dettagliLocale/<?php ob_start();
echo $_smarty_tpl->tpl_vars['evento']->iteration-1;
$_prefixVariable5 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['locali']->value[$_prefixVariable5]->getId();?>
">
                                        Visita la pagina del Locale <i class="fas fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                            <br>
                        <?php
$_smarty_tpl->tpl_vars['evento'] = $__foreach_evento_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                    </article>
                <?php }?>
                <?php if (empty($_smarty_tpl->tpl_vars['array']->value)) {?>
                    <h2>La ricerca non ha prodotto alcun risultato. Riprova.</h2>
                <?php }?>
            </div>
        </div>
    </section>
</main>
<!-- End Footer
<footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>Moderna</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>

</footer>-->

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
