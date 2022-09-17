<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <!--<title> Responsiive Admin Dashboard | CodingLab </title>-->
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
                <span class="links_name"   >Utenti Attivi</span>
            </a>
        </li>
        <li>
            <a href="/Admin/getUtenti/0" onclick="sidebarBtn.onclick(1)">
                <span class="links_name"   >Utenti Bannati</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(2)">
                <span class="links_name"  >Proprietari di locali</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(3)">
                <span class="links_name"  >Locali</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(4)">
                <span class="links_name"  >Recensioni segnalate</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="sidebarBtn.onclick(5)">
                <span class="links_name"  >Aggiungi categoria</span>
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
       <!--<form method="post">
            <div class="items-body">
                    {if !empty($utenti)}
                        {foreach $utenti as $utente}
                        <div class="items-body-content row-cols-3">
                            <p>Utenti Attivi</p>
                            <a href="/Admin/getUtenti/1">

                        </div>
                        {/foreach}
                    {else}
                        <p>Non ci sono utenti attivi</p>
                    {/if}
            </div>
        </form>-->
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="title" id="titolo">Benvenuto</div>
                <div class="sales-details" id="dettagli">
                    <ul class="details" id="dato1">
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
                <div class="button" id="bottone">

                </div>

            </div>

    <!--        <div class="top-sales box">
                <div class="title">Top Seling Product</div>
                <ul class="top-sales-details">
                    <li>
                        <a href="#">
                            <img src="images/sunglasses.jpg" alt="">
                            <span class="product">Vuitton Sunglasses</span>
                        </a>
                        <span class="price">$1107</span>
                    </li>
                    <li>
                        <a href="#">
                            <img src="images/jeans.jpg" alt="">
                            <span class="product">Hourglass Jeans </span>
                        </a>
                        <span class="price">$1567</span>
                    </li>
                    <li>
                        <a href="#">
                            <img src="images/nike.jpg" alt="">
                            <span class="product">Nike Sport Shoe</span>
                        </a>
                        <span class="price">$1234</span>
                    </li>
                    <li>
                        <a href="#">
                            <img src="images/scarves.jpg" alt="">
                            <span class="product">Hermes Silk Scarves.</span>
                        </a>
                        <span class="price">$2312</span>
                    </li>

                </ul>
            </div>-->
        </div>
    </div>
</section>

<script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".nav-links");
    sidebarBtn.onclick = function (i) {

        switch (i) {
            case 1: utentiRegistragti();
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

    function utentiRegistragti(){
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

