<!DOCTYPE html>
{assign var='utentiAttivi' value=$utentiAttivi|default:null}
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
                            {if isset($utentiAttivi)}
                                {foreach $utentiAttivi as $utente}
                                    <tr><td>{$utente->getUsername()}</td><td>{$utente->getNome()}</td><td>{$utente->getCognome()}</td><td>{$utente->getEmail()}</td><td>{$utente->getIscrizione()}</td></tr>
                                {/foreach}
                            {/if}
                            </tbody>
                        </table>
                            {if !isset($utentiAttivi)}
                                <h2>DIRUSSOCICCARELLI</h2>
                            {/if}

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

<script>
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


</script>

</body>
</html>

