<?php
/* Smarty version 4.2.0, created on 2022-09-18 16:36:04
  from 'C:\xampp\htdocs\FacceBeve\template\dashboardAdmin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_63272cd498e804_36663858',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61814e22ecca6cd2302bb05219c59cc01d7a92dc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\dashboardAdmin.tpl',
      1 => 1663511760,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63272cd498e804_36663858 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('utentiAttivi', (($tmp = $_smarty_tpl->tpl_vars['utentiAttivi']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));?>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <!--<title> Responsive Admin Dashboard | CodingLab </title>-->
    <link rel="stylesheet" href="/template/css/admin.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar">
    <div class="logo-details">
        <img src="/template/img/logo.png" alt=""><span class="logo_name"> FacceBeve</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/Admin/getUtenti/1" onclick="sidebarBtn.onclick(1)">
                <span class="links_name">Utenti Attivi</span>
            </a>
        </li>
        <li>
            <a href="/Admin/getUtenti/0" onclick="sidebarBtn.onclick(1)">
                <span class="links_name">Utenti Bannati</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(2)">
                <span class="links_name">Proprietari di locali</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(3)">
                <span class="links_name">Locali</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(4)">
                <span class="links_name">Recensioni segnalate</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(5)">
                <span class="links_name">Categorie</span>
            </a>
        </li>
    </ul>

</div>
<section class="home-section">
    <nav>
        <div class="search-box">
            <input type="text" placeholder="Search...">
            <i class='bx bx-search'></i>
        </div>
        <div>
            <input type="button" value="Esci">
        </div>
    </nav>
<!--eventi registrati-->
    <div class="home-content">

        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="title" id="titolo">Benvenuto</div>
                <div class="sales-details" id="dettagli">
                    <ul class="details" id="dato1">
                        <table>
                            <caption>
                                <p>Utenti Attivi</p>
                            </caption>
                            <thead>
                            <tr><th>Username</th><th>Nome</th><th>Cognome</th><th>Email</th><th>Data Iscrizione</th></tr>
                            </thead>
                        <!--    <tfoot>
                            <tr><td>Totale 1</td><td>Totale 2</td></tr>
                            </tfoot> -->
                            <tbody>
                            <?php if ((isset($_smarty_tpl->tpl_vars['utentiAttivi']->value))) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['utentiAttivi']->value, 'utente');
$_smarty_tpl->tpl_vars['utente']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['utente']->value) {
$_smarty_tpl->tpl_vars['utente']->do_else = false;
?>
                                    <tr><td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
</td><td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
</td><td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
</td><td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
</td><td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getIscrizione();?>
</td></tr>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php }?>
                            </tbody>
                        </table>
                            <?php if (!(isset($_smarty_tpl->tpl_vars['utentiAttivi']->value))) {?>
                                <h2>DIRUSSOCICCARELLI</h2>
                            <?php }?>

                    </ul>
                    <ul class="details" id="dato2">
                    </ul>
                    <ul class="details" id="dato3">
                    </ul>
                    <ul class="details" id="dato4">
                    </ul>
                    <ul class="details" id="dato5">
                    </ul>
                </div>

            </div>

        </div>
    </div>
</section>

<?php echo '<script'; ?>
>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".nav-links");
    sidebarBtn.onclick = function (i) {

        switch (i) {
            case 1: utentiRegistrati();
                break;
            case 2: propetariLocali();
                break;
            case 3: locali();
                break;
            case 4: recensioniSegnalate();
                break;
            case 5: aggiuntaCategoria()
                break;
        }
    }

    function utentiRegistrati(){
        document.getElementById('titolo').innerText="Utenti Registrati";
        document.getElementById('dato1').innerText="USERNAME";
        document.getElementById('dato2').innerText="EMAIL";
        document.getElementById('dato3').innerText="STATO";
        document.getElementById('dato4').innerText="NOME";
        document.getElementById('dato5').innerText="COGNOME";
        document.getElementById('bottone').innerHTML='<a href="#">Vedi tutto</a>';

    }
    function propetariLocali(){
        document.getElementById('titolo').innerText="Propietario dei locali";
        document.getElementById('dato1').innerText="USERNAME";
        document.getElementById('dato2').innerText="EMAIL";
        document.getElementById('dato3').innerText="STATO";
        document.getElementById('dato4').innerText="NOME";
        document.getElementById('dato5').innerText="COGNOME";
        document.getElementById('bottone').innerHTML='<a href="#">Vedi tutto</a>';
    }
    function locali(){
        document.getElementById('titolo').innerText="Locali";
        document.getElementById('dato1').innerText="ID";
        document.getElementById('dato2').innerText="NOME";
        document.getElementById('dato3').innerText="PROPRIETARIO";
        document.getElementById('dato4').innerText="VISIBILITA'";
        document.getElementById('dato5').innerText="";
        document.getElementById('bottone').innerHTML='<a href="#">Vedi tutto</a>';
    }
    function recensioniSegnalate(){
        document.getElementById('titolo').innerText="Recensioni segnalate";
        document.getElementById('dato1').innerText="ID";
        document.getElementById('dato2').innerText="UTENTE";
        document.getElementById('dato3').innerText="LOCALE";
        document.getElementById('dato4').innerText="DESCRIZIONE'";
        document.getElementById('dato5').innerText="DATA";
        document.getElementById('bottone').innerHTML='<a href="#">Vedi tutto</a>';
    }
    function aggiuntaCategoria() {
        document.getElementById('titolo').innerText = "Aggiungi categoria";
        document.getElementById('dato1').innerHTML = "<label>Nome categoria:  </label> <input type='text'>";
        document.getElementById('bottone').innerHTML = '<a href="#">Salva</a>';
    }


<?php echo '</script'; ?>
>

</body>
</html>

<?php }
}
