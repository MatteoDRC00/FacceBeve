<?php
/* Smarty version 4.2.0, created on 2022-09-18 17:53:48
  from 'C:\xampp\htdocs\FacceBeve\template\dashboardAdmin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_63273f0ccd1bb6_37809666',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61814e22ecca6cd2302bb05219c59cc01d7a92dc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\FacceBeve\\template\\dashboardAdmin.tpl',
      1 => 1663516427,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63273f0ccd1bb6_37809666 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('utentiAttivi', (($tmp = $_smarty_tpl->tpl_vars['utentiAttivi']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('utentiBannati', (($tmp = $_smarty_tpl->tpl_vars['utentiBannati']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('categorie', (($tmp = $_smarty_tpl->tpl_vars['categorie']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('proprietari', (($tmp = $_smarty_tpl->tpl_vars['proprietari']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));
$_smarty_tpl->_assignInScope('recensioni', (($tmp = $_smarty_tpl->tpl_vars['recensioni']->value ?? null)===null||$tmp==='' ? null ?? null : $tmp));?>
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
        <div>
            <input type="button" value="Esci">
        </div>
    </nav>
    <!--eventi registrati-->
    <div class="home-content">

         <!--Utenti Attivi-->
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="sales-details" id="utentiAttivi">
                    <table>
                        <caption>
                            <p>Utenti Attivi</p>
                        </caption>
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                            <th>Data Iscrizione</th>
                        </tr>
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
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getIscrizione();?>
</td>
                                </tr>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php }?>
                        </tbody>
                    </table>
                    <?php if (!(isset($_smarty_tpl->tpl_vars['utentiAttivi']->value))) {?>
                        <br>
                        <h2>Attualmente non ci sono utenti attivi </h2>
                    <?php }?>
                </div>
            </div>
        </div>

        <br>

        <!--Utenti Bannati-->
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="sales-details" id="utentiBannati">
                    <table>
                        <caption>
                            <p>Utenti Bannati</p>
                        </caption>
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                            <th>Data Iscrizione</th>
                        </tr>
                        </thead>
                        <!--    <tfoot>
                            <tr><td>Totale 1</td><td>Totale 2</td></tr>
                            </tfoot> -->
                        <tbody>
                        <?php if ((isset($_smarty_tpl->tpl_vars['utentiBannati']->value))) {?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['utentiBannati']->value, 'utente');
$_smarty_tpl->tpl_vars['utente']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['utente']->value) {
$_smarty_tpl->tpl_vars['utente']->do_else = false;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getIscrizione();?>
</td>
                                </tr>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
                <?php if (!(isset($_smarty_tpl->tpl_vars['utentiBannati']->value))) {?>
                    <br>
                    <h2>Attualmente non ci sono utenti bannati </h2>
                <?php }?>
            </div>
        </div>

        <br>

        <!--Proprietari-->
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="sales-details" id="proprietari">
                    <table>
                        <caption>
                            <p>Proprietari di locali</p>
                        </caption>
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <!--    <tfoot>
                            <tr><td>Totale 1</td><td>Totale 2</td></tr>
                            </tfoot> -->
                        <tbody>
                        <?php if ((isset($_smarty_tpl->tpl_vars['proprietari']->value))) {?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['proprietari']->value, 'utente');
$_smarty_tpl->tpl_vars['utente']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['utente']->value) {
$_smarty_tpl->tpl_vars['utente']->do_else = false;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['utente']->value->getIscrizione();?>
</td>
                                </tr>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
                <?php if (!(isset($_smarty_tpl->tpl_vars['proprietari']->value))) {?>
                    <br>
                    <h2>Attualmente non ci sono profili di utenti proprietari </h2>
                <?php }?>
            </div>
        </div>

        <br>

        <!--Categorie-->
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="sales-details" id="categorie">
                    <table>
                        <caption>
                            <p>Categorie</p>
                        </caption>
                        <thead>
                        <tr>
                            <th>Genere</th>
                            <th>Descrizione</th>
                        </tr>
                        </thead>
                        <!--    <tfoot>
                            <tr><td>Totale 1</td><td>Totale 2</td></tr>
                            </tfoot> -->
                        <tbody>
                        <?php if ((isset($_smarty_tpl->tpl_vars['categorie']->value))) {?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categorie']->value, 'categoria');
$_smarty_tpl->tpl_vars['categoria']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['categoria']->value) {
$_smarty_tpl->tpl_vars['categoria']->do_else = false;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['categoria']->value->getGenere();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['categoria']->value->getDescrizione();?>
</td>
                                </tr>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
                <?php if (!(isset($_smarty_tpl->tpl_vars['categorie']->value))) {?>
                    <br>
                    <h2>Attualmente non ci sono categorie di locali sul sito </h2>
                <?php }?>
            </div>
        </div>

        <br>

        <!--Recensioni Segnalate-->
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="sales-details" id="recensioni">
                    <table>
                        <caption>
                            <p>Recesioni</p>
                        </caption>
                        <thead>
                        <tr>
                            <th>Titolo</th>
                            <th>Descrizione</th>
                            <th>Autore</th>
                            <th>Locale</th>
                        </tr>
                        </thead>
                        <!--    <tfoot>
                            <tr><td>Totale 1</td><td>Totale 2</td></tr>
                            </tfoot> -->
                        <tbody>
                        <?php if ((isset($_smarty_tpl->tpl_vars['recensioni']->value))) {?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recensioni']->value, 'rece');
$_smarty_tpl->tpl_vars['rece']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['rece']->value) {
$_smarty_tpl->tpl_vars['rece']->do_else = false;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getTitolo();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getDescrizione();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getUtente()->getUsername();?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['rece']->value->getLocale()->getNome();?>
</td>
                                </tr>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
                <?php if (!(isset($_smarty_tpl->tpl_vars['recensioni']->value))) {?>
                    <br>
                    <h2>Attualmente non ci sono recensioni segnalate </h2>
                <?php }?>
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
            case 1:
                utentiRegistrati();
                break;
            case 2:
                propetariLocali();
                break;
            case 3:
                locali();
                break;
            case 4:
                recensioniSegnalate();
                break;
            case 5:
                aggiuntaCategoria()
                break;
        }
    }

    function utentiRegistrati() {
        document.getElementById('titolo').innerText = "Utenti Registrati";
        document.getElementById('dato1').innerText = "USERNAME";
        document.getElementById('dato2').innerText = "EMAIL";
        document.getElementById('dato3').innerText = "STATO";
        document.getElementById('dato4').innerText = "NOME";
        document.getElementById('dato5').innerText = "COGNOME";
        document.getElementById('bottone').innerHTML = '<a href="#">Vedi tutto</a>';

    }

    function propetariLocali() {
        document.getElementById('titolo').innerText = "Propietario dei locali";
        document.getElementById('dato1').innerText = "USERNAME";
        document.getElementById('dato2').innerText = "EMAIL";
        document.getElementById('dato3').innerText = "STATO";
        document.getElementById('dato4').innerText = "NOME";
        document.getElementById('dato5').innerText = "COGNOME";
        document.getElementById('bottone').innerHTML = '<a href="#">Vedi tutto</a>';
    }

    function locali() {
        document.getElementById('titolo').innerText = "Locali";
        document.getElementById('dato1').innerText = "ID";
        document.getElementById('dato2').innerText = "NOME";
        document.getElementById('dato3').innerText = "PROPRIETARIO";
        document.getElementById('dato4').innerText = "VISIBILITA'";
        document.getElementById('dato5').innerText = "";
        document.getElementById('bottone').innerHTML = '<a href="#">Vedi tutto</a>';
    }

    function recensioniSegnalate() {
        document.getElementById('titolo').innerText = "Recensioni segnalate";
        document.getElementById('dato1').innerText = "ID";
        document.getElementById('dato2').innerText = "UTENTE";
        document.getElementById('dato3').innerText = "LOCALE";
        document.getElementById('dato4').innerText = "DESCRIZIONE'";
        document.getElementById('dato5').innerText = "DATA";
        document.getElementById('bottone').innerHTML = '<a href="#">Vedi tutto</a>';
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
