<!DOCTYPE html>
{assign var='utentiAttivi' value=$utentiAttivi|default:null}
{assign var='utentiBannati' value=$utentiBannati|default:null}
{assign var='categorie' value=$categorie|default:null}
{assign var='proprietari' value=$proprietari|default:null}
{assign var='recensioni' value=$recensioni|default:null}
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <!--<title> Responsive Admin Dashboard | CodingLab </title>-->
    <link rel="stylesheet" href="/template/css/aadmin.css">
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
            <a href="#proprietari"><span class="links_name">Proprietari di locali</span></a>
        </li>
        <li>
            <a href="#"><span class="links_name">Locali</span></a>
        </li>
        <li>
            <a href="#recensioni"><span class="links_name">Recensioni segnalate</span></a>
        </li>
        <li>
            <a href="#categorie"><span class="links_name">Categorie</span></a>
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
                        {if isset($utentiAttivi)}
                            {foreach $utentiAttivi as $utente}
                                <tr>
                                    <td>{$utente->getUsername()}</td>
                                    <td>{$utente->getNome()}</td>
                                    <td>{$utente->getCognome()}</td>
                                    <td>{$utente->getEmail()}</td>
                                    <td>{$utente->getIscrizione()}</td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                    {if !isset($utentiAttivi)}
                        <br>
                        <h2>Attualmente non ci sono utenti attivi </h2>
                    {/if}
                </div>
            </div>
        </div>

        <br>

        <!--Utenti Bannati-->
        <div class="sales-boxes" id="utentiBannati">
            <div class="recent-sales box">
                <div class="sales-details">
                    <table id="customers">
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
                        {if isset($utentiBannati)}
                            {foreach $utentiBannati as $utente}
                                <tr>
                                    <td>{$utente->getUsername()}</td>
                                    <td>{$utente->getNome()}</td>
                                    <td>{$utente->getCognome()}</td>
                                    <td>{$utente->getEmail()}</td>
                                    <td>{$utente->getIscrizione()}</td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </div>
                {if !isset($utentiBannati)}
                    <br>
                    <h2>Attualmente non ci sono utenti bannati </h2>
                {/if}
            </div>
        </div>

        <br>

        <!--Proprietari-->
        <div class="sales-boxes" id="proprietari">
            <div class="recent-sales box">
                <div class="sales-details">
                    <table id="customers">
                        <caption>
                            <p>Proprietari di locali</p>
                        </caption>
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <!--    <tfoot>
                            <tr><td>Totale 1</td><td>Totale 2</td></tr>
                            </tfoot> -->
                        <tbody>
                        {if isset($proprietari)}
                            {foreach $proprietari as $utente}
                                <tr>
                                    <td>{$utente->getUsername()}</td>
                                    <td>{$utente->getNome()}</td>
                                    <td>{$utente->getCognome()}</td>
                                    <td>{$utente->getEmail()}</td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </div>
                {if !isset($proprietari)}
                    <br>
                    <h2>Attualmente non ci sono profili di utenti proprietari </h2>
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
                        {if isset($categorie)}
                            {foreach $categorie as $categoria}
                                <tr>
                                    <td>{$categoria->getGenere()}</td>
                                    <td>{$categoria->getDescrizione()}</td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </div>
                {if !isset($categorie)}
                    <br>
                    <h2>Attualmente non ci sono categorie di locali sul sito </h2>
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
                        {if isset($recensioni)}
                            {foreach $recensioni as $rece}
                                <tr>
                                    <td>{$rece->getTitolo()}</td>
                                    <td>{$rece->getDescrizione()}</td>
                                    <td>{$rece->getUtente()->getUsername()}</td>
                                    <td>{$rece->getLocale()->getNome()}</td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </div>
                {if !isset($recensioni)}
                    <br>
                    <h2>Attualmente non ci sono recensioni segnalate </h2>
                {/if}
            </div>
        </div>



    </div>


</section>
</body>
</html>

