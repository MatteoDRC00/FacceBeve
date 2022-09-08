<?php
/* Smarty version 4.2.0, created on 2022-09-08 20:27:17
  from 'C:\xampp\htdocs\FacceBeve\template\error.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_631a3405d25413_05829224',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '30df5ca2fc2aed6ba9b9c2ca893fe37b5c7fbd9e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\error.tpl',
      1 => 1662657126,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_631a3405d25413_05829224 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>FacceBeve</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/Smarty/template/assets/img/favicon.png" rel="icon">

    <!--Css-->
    <link rel="stylesheet" href="/Smarty/template/assets/css/error.css">


</head>

<section class="page_404">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="col-sm-10 col-sm-offset-1  text-center">
                    <h1>$error</h1>
                    <div class="four_zero_four_bg">
                    </div>

                    <div class="contant_box_404">
                        <h3 class="h2">
                            Look like you're lost
                        </h3>

                        <p class="p">$testo</p>
                        <a href="home.html" class="link_404">Cliccami per tornare alla home :( </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</html>
<?php }
}
