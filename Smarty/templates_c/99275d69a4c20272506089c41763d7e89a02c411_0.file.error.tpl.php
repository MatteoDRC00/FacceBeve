<?php
/* Smarty version 4.2.0, created on 2022-09-08 17:01:48
  from 'C:\xampp\htdocs\FacceBeve\Smarty\templates\error.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_631a03dc057ad1_10920729',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '99275d69a4c20272506089c41763d7e89a02c411' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\Smarty\\templates\\error.tpl',
      1 => 1662493493,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_631a03dc057ad1_10920729 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/Faccebeve/Smarty/template/assets/img/logo.png">

    <title>Errore!</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/cover/">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="/FacceBeve/Smarty/template/assets/css/error.css" rel="stylesheet">
</head>

<body class="text-center">

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="masthead mb-auto">
        <div class="inner">

        </div>
    </header>

    <main role="main" class="inner cover">
        <img src="/FacceBeve/Smarty/template/assets/img/logo.png" width="400" height="300"/>

        <p style="font-size: 100px;">ERRORE 40<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</p>
        <h1 class="cover-heading">Qualcosa è andato storto</h1>
        <p class="lead"><?php echo $_smarty_tpl->tpl_vars['testo']->value;?>
</p>
        <p class="lead">
        </p>
    </main>

    <footer class="mastfoot mt-auto">
    </footer>
</div>


</body>

</html>
<?php }
}
