<!DOCTYPE html>
{assign var='utentiAttivi' value=$utentiAttivi|default:null}
{assign var='utentiBannati' value=$utentiBannati|default:null}
{assign var='categorie' value=$categorie|default:null}
{assign var='proprietari' value=$proprietari|default:null}
{assign var='recensioni' value=$recensioni|default:null}
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <!--<title> Responsive Admin Dashboard | CodingLab </title>-->
    <link rel="stylesheet" href="/template/css/aadmin.css">
    <link href="/template/img/favicon.png" rel="icon">
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
            <a href="#utentiAttivi"><span class="links_name">Utenti Attivi</span></a>
        </li>
        <li>
            <a href="#utentiBannati"><span class="links_name">Utenti Bannati</span></a>
        </li>
        <li>
            <a href="#recensioni"><span class="links_name">Recensioni segnalate</span></a>
        </li>
        <li>
            <a href="#categorie"><span class="links_name">Categorie</span></a>
        </li>
        <li>
            <a href="/Accesso/logout"><span class="links_name">Esci</span></a>
        </li>
    </ul>

</div>
<section class="home-section">
    <!--eventi registrati-->
    <div class="home-content">

         <!--Utenti Attivi-->
        <div class="sales-boxes" id="utentiAttivi">
            <div class="recent-sales box">
                <div class="sales-details">
                    <table id="customers">
                        <caption>
                            <p style="font-weight: bold">Utenti Attivi</p>
                        </caption>
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
                        {if isset($utentiAttivi)}
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
                {if !isset($utentiAttivi)}
                    <br>
                    <p style="text-align: center">Attualmente non ci sono utenti attivi </p>
                {/if}
            </div>
        </div>

        <br>

        <!--Utenti Bannati-->
        <div class="sales-boxes" id="utentiBannati">
            <div class="recent-sales box">
                <div class="sales-details">
                    <table id="customers">
                        <caption>
                            <p style="font-weight: bold">Utenti Bannati</p>
                        </caption>
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
                        {if isset($utentiBannati)}
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
                {if !isset($utentiBannati)}
                    <br>
                    <p style="text-align: center">Attualmente non ci sono utenti bannati </p>
                {/if}
            </div>
        </div>

        <br>

        <!--Categorie-->
        <div class="sales-boxes" id="categorie">
            <div class="recent-sales box">
                <div class="sales-details">
                    <table id="customers">
                        <caption>
                            <p style="font-weight: bold">Categorie</p>
                        </caption>
                        <thead>
                        <tr>
                            <th>Genere</th>
                            <th>Descrizione</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        {if isset($categorie)}
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
                            <form action="/Admin/aggiungiCategoria" method="POST">
                                <td><input style="padding: 4px" type="text" placeholder="Genere" name="genere"></td>
                                <td><input style="padding: 4px" type="text" placeholder="Descrizione" name="descrizione"></td>
                                <td><input style="border-radius: 9px; padding: 3px; border-color: #0dcaf0" type="submit" value="Aggiungi"></td>
                            </form>
                        </tbody>
                    </table>
                </div>
                {if !isset($categorie)}
                    <br>
                    <p style="text-align: center">Attualmente non ci sono categorie di locali sul sito </p>
                {/if}
            </div>
        </div>

        <br>

        <!--Recensioni Segnalate-->
        <div class="sales-boxes" id="recensioni">
            <div class="recent-sales box">
                <div class="sales-details">
                    <table id="customers">
                        <caption>
                            <p style="font-weight: bold">Recensioni</p>
                        </caption>
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
                        {if isset($recensioni)}
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
                {if !isset($recensioni)}
                    <br>
                    <p style="text-align: center">Attualmente non ci sono recensioni segnalate </p>
                {/if}
            </div>
        </div>
    </div>
</section>
</body>
</html>

