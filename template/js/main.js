/**
 * Funzione per controllare che vengano inseriti tutti i campi necessari per la recensione
 */
function validateRecensione() {
    let titolo = document.forms["Recensione"]["titolo"].value;
    let descrizione = document.forms["Recensione"]["descrizione"].value;
    let valutazione = document.forms["Recensione"]["valutazione"].value;

    if (titolo === "" || valutazione === "-- Voto --") {
        alert("Inserire i campi necessari");
        return false;
    }
}

/**
 *Funzione utilizzata per controllare che vengano inseriti tutti i campi
 */
function validateRegForm(id) {
    if (id === 0) { //Form registrazione Utente
        let nome = document.forms["registrazioneUtente"]["nome"].value;
        let cognome = document.forms["registrazioneUtente"]["cognome"].value;
        let username = document.forms["registrazioneUtente"]["username"].value;
        let email = document["registrazioneUtente"]["email"].value;
        let password1 = document.forms["registrazioneUtente"]["password"].value;
        let password2 = document.forms["registrazioneUtente"]["password2"].value;
        let img = document.forms["registrazioneUtente"]["img_profilo"].value;

        alert(nome);
        return false;

        if (nome === "" || cognome === "" || email === "" || username === "" || password1 === "" || password2 === "") {
            alert("Inserire i campi mancanti");
            return false;
        }

        if (password1 !== password2) {
            alert("Le password inserite non corrispondono!");
            return false;
        }
        let allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i; //Controllo sul Type del img inserita

        if (img !== ""){
            if (!allowedExtensions.exec(img)) {
                alert('Tipo di file non valido, sono accettati, prova con  \n-jpg\n-jpeg\n-gif\n-png');
                img.value = '';
                return false;
            }
        }

    } else if (id === 1) { //Form registrazione Proprietario
        let nome = document.forms["registrazioneProprietario"]["nome"].value;
        let cognome = document.forms["registrazioneProprietario"]["cognome"].value;
        let username = document.forms["registrazioneProprietario"]["username"].value;
        let email = document["registrazioneProprietario"]["email"].value;
        let password1 = document.forms["registrazioneProprietario"]["password"].value;
        let password2 = document.forms["registrazioneProprietario"]["password2"].value;
        let img = document.forms["registrazioneProprietario"]["img_profilo"].value;

        alert(nome);
        return false;

        if (nome === "" || cognome === "" || email === "" || username === "" || password1 === "" || password2 === "") {
            alert("Inserire i campi mancanti");
            return false;
        }

        if (password1 !== password2) {
            alert("Le password inserite non corrispondono!");
            return false;
        }
        let allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i; //Controllo sul Type del img inserita

        if (img !== ""){
            if (!allowedExtensions.exec(img)) {
                alert('Tipo di file non valido, sono accettati, prova con  \n-jpg\n-jpeg\n-gif\n-png');
                img.value = '';
                return false;
            }
        }

    } else if (id === 2) {  //Form registrazione Locale

        let nomeLocale = document.forms["registrazioneLocale"]["nomeLocale"].value;
        let descrizioneLocale = document.forms["registrazioneLocale"]["descrizioneLocale"].value;
        var values = document.forms["registrazioneLocale"]["genereLocale[]"];
        var generi = [];
        for (var i = 0; i < values.length; i++) {
            if(values[i].checked)
                generi.push(values[i].value);
        }
        let numeroLocale = document.forms["registrazioneLocale"]["numeroLocale"].value;
        //Localizzazione
        let indirizzoLocale = document.forms["registrazioneLocale"]["indirizzoLocale"].value;
        let civicoLocale = document.forms["registrazioneLocale"]["civicoLocale"].value;
        let cittaLocale = document.forms["registrazioneLocale"]["cittaLocale"].value;
        let CAPLocale = document.forms["registrazioneLocale"]["CAPLocale"].value;

        if(CAPLocale.length !== 5){
            alert("Inserire Il CAP giusto");
            return false;
        }

        //Orario
        let orario1 = document.forms["registrazioneLocale"]["orarioapertura[]"];
        let orario2 = document.forms["registrazioneLocale"]["orariochiusura[]"];
        let chiuso = document.forms["registrazioneLocale"]["close[]"];

        for (let i = 0; i < 7; i++) {

            if ((orario1[i].value !== "") && (orario2[i].value !== "") && (chiuso[i].checked)) {
                alert("Valori inconsistenti, il locale è aperto o chiuso?");
                return false;
            }
            if ((orario1[i].value === "") && (orario2[i].value === "") && !(chiuso[i].checked)) {
                alert("Scegliere o una coppia di orari (apertura/chiusura) o chiuso");
                return false;
            }
            if ((orario1[i].value === "") && (orario2[i].value !== "")) {
                alert("Scegliere o una coppia di orari (apertura/chiusura) o chiuso");
                return false;
            }
            if ((orario1[i].value !== "") && (orario2[i].value === "")) {
                alert("Scegliere o una coppia di orari (apertura/chiusura) o chiuso");
                return false;
            }

        }
        let imgLocale = document.forms["registrazioneLocale"]["img_locale"].value;
        let allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i; //Controllo sul Type del img inserita

        if (imgLocale !== ""){
            if (!allowedExtensions.exec(imgLocale)) {
                alert('Tipo di file non valido, sono accettati, prova con  \n-jpg\n-jpeg\n-gif\n-png');
                imgLocale.value = '';
                return false;
            }
        }

        if (nomeLocale === "" || descrizioneLocale === "" || numeroLocale === "" || indirizzoLocale === "" || civicoLocale === "" || cittaLocale === "" || CAPLocale === "") {
            alert("Inserire i campi mancanti");
            return false;
        }

        if(generi.length === 0){
            alert("Scegliere almeno una categoria");
            return false;
        }

    } else if (id === 3) { //Form registrazione Evento
        let nomeEvento = document.forms["registrazioneEvento"]["nomeEvento"].value;
        let descrizioneEvento = document.forms["registrazioneEvento"]["descrizioneEvento"].value;
        let dataEvento = document.forms["registrazioneEvento"]["dataEvento"].value;
        let imgEvento = document.forms["registrazioneEvento"]["img_evento"].value;

        let DataEvento = new Date(dataEvento);
        let Oggi = new Date();

        if (nomeEvento === "" || descrizioneEvento === "" || dataEvento === "") {
            alert("Inserire i campi mancanti");
            return false;
        }

        if (DataEvento.getTime() <= Oggi.getTime()) {
            alert('La data del evento è precedente ad adesso, viaggiare nel tempo è pericoloso');
            return false;
        }

        let allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i; //Controllo sul Type del img inserita

        if (imgEvento !== ""){
            if (!allowedExtensions.exec(imgEvento)) {
                alert('Tipo di file non valido, sono accettati, prova con  \n-jpg\n-jpeg\n-gif\n-png');
                imgEvento.value = '';
                return false;
            }
        }

    } else if (id === 4) {
        let genere = document.forms["aggiuntaCategoria"]["genere"].value;
        let descrizione = document.forms["aggiuntaCategoria"]["descrizione"].value;

        if(genere === "" || descrizione === ""){
            alert('Inserire entrambi i campi per proseguire');
            return false;
        }
    }
}

function validateModificaOrarioForm(){
    let orario1 = document.forms["modificaOrario"]["orarioapertura[]"];
    let orario2 = document.forms["modificaOrario"]["orariochiusura[]"];
    let chiuso = document.forms["modificaOrario"]["close[]"];

    for (let i = 0; i < 7; i++) {

        if ((orario1[i].value !== "") && (orario2[i].value !== "") && (chiuso[i].checked)) {
            alert("Valori inconsistenti, il locale è aperto o chiuso?");
            return false;
        }
        if ((orario1[i].value === "") && (orario2[i].value === "") && !(chiuso[i].checked)) {
            alert("Scegliere o una coppia di orari (apertura/chiusura) o chiuso");
            return false;
        }
        if ((orario1[i].value === "") && (orario2[i].value !== "")) {
            alert("Scegliere o una coppia di orari (apertura/chiusura) o chiuso");
            return false;
        }
        if ((orario1[i].value !== "") && (orario2[i].value === "")) {
            alert("Scegliere o una coppia di orari (apertura/chiusura) o chiuso");
            return false;
        }

    }
}

function validatemodificaGeneriForm(){
    var values = document.forms["modificaGenere"]["genereLocale[]"];
    var generi = [];
    for (var i = 0; i < values.length; i++) {
        if(values[i].checked)
            generi.push(values[i].value);
    }

    if(generi.length === 0){
        alert("Scegliere almeno una categoria");
        return false;
    }
}

function validatemodificaDataForm(){
    let dataEvento = document.forms["modificaData"]["dataEvento"].value;

    let DataEvento = new Date(dataEvento);
    let Oggi = new Date();

    if (DataEvento.getTime() <= Oggi.getTime()) {
        alert('La data del evento è precedente ad adesso, viaggiare nel tempo è pericoloso');
        return false;
    }
}


function validateImg(){
    let img = document.forms.modificaImg.elements.newimg_profilo.value;

    let allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i; //Controllo sul Type del img inserita

    if (img !== ""){
        if (!allowedExtensions.exec(img)) {
            alert('Tipo di file non valido, sono accettati, prova con  \n-jpg\n-jpeg\n-gif\n-png');
            img.value = '';
            return false;
        }
    }
}

/**
 *Funzione utilizzata per controllare che venga inserito almeno un valore nei campi del form di ricerca
 */
function validateResearchForm(id) {
    if (id === 1) {
        let x = document.getElementById("tipo");
        if (x.value === "Locali") {
            //Gestione form ricerca locali utenti collegati
            let citta = document.forms["ricercaLocali1"]["citta1"].value;
            let nome = document.forms["ricercaLocali1"]["nomeLocale1"].value;
            let categoria = document.forms["ricercaLocali1"]["categorie1"].value;

            if (citta === "" && nome === "" && categoria === "--Scegli il tipo--") {
                window.alert("Inserire almeno un campo per effettuare la ricerca ");
                return false;
            }
        } else if(x.value === "Eventi") {
            //Gestione form ricerca eventi utenti collegati
            let citta = document.forms["ricercaEventi"]["citta2"].value;
            let nomeLocale = document.forms["ricercaEventi"]["nomeLocaleEvento"].value;
            let nomeEvento = document.forms["ricercaEventi"]["nomeEvento"].value;
            let dataEvento = document.forms["ricercaEventi"]["dataEvento"].value;

            let DataEvento = new Date(dataEvento);
            let Oggi = new Date();

            if (citta === "" && nomeLocale === "" && nomeEvento === "" && dataEvento === "") {
                alert("Inserire almeno un campo per effettuare la ricerca");
                return false;
            }

            if (DataEvento.getTime() <= Oggi.getTime()) {
                alert('La data del evento è precedente ad adesso, viaggiare nel tempo è pericoloso');
                return false;
            }
        }
    } else if(id === 0){
        //Gestione form ricerca locali utenti non collegati
        let citta = document.forms["ricercaLocali0"]["citta"].value;
        let nome = document.forms["ricercaLocali0"]["nomeLocale"].value;
        let categoria = document.forms["ricercaLocali0"]["categorie"].value;
        if (citta === "" && nome === "" && categoria === "--Scegli il tipo--") {
            alert("Inserire almeno un campo per effettuare la ricerca ");
            return false;
        }
    }

}

function setList() {
    let x = document.getElementById("tipo");
    let y = x.value;
    let z, q;
    q = document.getElementById(y);
    if (y === 'Locali') {
        q.style.display = "flex";
        z = document.getElementById("Eventi");
        z.style.display = "none";

    } else if (y === 'Eventi') {
        q.style.display = "inline-block";
        z = document.getElementById("Locali");
        z.style.display = "none";
    }
}

///////////////////////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


(function () {
    "use strict";
    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all)
        if (selectEl) {
            if (all) {
                selectEl.forEach(e => e.addEventListener(type, listener))
            } else {
                selectEl.addEventListener(type, listener)
            }
        }
    }

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
    }

    /**
     * Scrolls to an element with header offset
     */
    const scrollto = (el) => {
        let header = select('#header')
        let offset = header.offsetHeight

        if (!header.classList.contains('header-scrolled')) {
            offset -= 20
        }

        let elementPos = select(el).offsetTop
        window.scrollTo({
            top: elementPos - offset,
            behavior: 'smooth'
        })
    }

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select('#header')
    if (selectHeader) {
        const headerScrolled = () => {
            if (window.scrollY > 100) {
                selectHeader.classList.add('header-scrolled')
            } else {
                selectHeader.classList.remove('header-scrolled')
            }
        }
        window.addEventListener('load', headerScrolled)
        onscroll(document, headerScrolled)
    }

    /**
     * Back to top button
     */
    let backtotop = select('.back-to-top')
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add('active')
            } else {
                backtotop.classList.remove('active')
            }
        }
        window.addEventListener('load', toggleBacktotop)
        onscroll(document, toggleBacktotop)
    }

    /**
     * Mobile nav toggle
     */
    on('click', '.mobile-nav-toggle', function (e) {
        select('#navbar').classList.toggle('navbar-mobile')
        this.classList.toggle('bi-list')
        this.classList.toggle('bi-x')
    })

    /**
     * Mobile nav dropdowns activate
     */
    on('click', '.navbar .dropdown > a', function (e) {
        if (select('#navbar').classList.contains('navbar-mobile')) {
            e.preventDefault()
            this.nextElementSibling.classList.toggle('dropdown-active')
        }
    }, true)

    /**
     * Scrool with ofset on links with a class name .scrollto
     */
    on('click', '.scrollto', function (e) {
        if (select(this.hash)) {
            e.preventDefault()

            let navbar = select('#navbar')
            if (navbar.classList.contains('navbar-mobile')) {
                navbar.classList.remove('navbar-mobile')
                let navbarToggle = select('.mobile-nav-toggle')
                navbarToggle.classList.toggle('bi-list')
                navbarToggle.classList.toggle('bi-x')
            }
            scrollto(this.hash)
        }
    }, true)

    /**
     * Skills animation
     */
    let skilsContent = select('.skills-content');
    if (skilsContent) {
        new Waypoint({
            element: skilsContent,
            offset: '80%',
            handler: function (direction) {
                let progress = select('.progress .progress-bar', true);
                progress.forEach((el) => {
                    el.style.width = el.getAttribute('aria-valuenow') + '%'
                });
            }
        })
    }

    /**
     * Testimonials slider
     */
    new Swiper('.testimonials-carousel', {
        speed: 400,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        }
    });

    /**
     * Porfolio isotope and filter
     */
    window.addEventListener('load', () => {
        let portfolioContainer = select('.portfolio-container');
        if (portfolioContainer) {
            let portfolioIsotope = new Isotope(portfolioContainer, {
                itemSelector: '.portfolio-wrap',
                layoutMode: 'fitRows'
            });

            let portfolioFilters = select('#portfolio-flters li', true);

            on('click', '#portfolio-flters li', function (e) {
                e.preventDefault();
                portfolioFilters.forEach(function (el) {
                    el.classList.remove('filter-active');
                });
                this.classList.add('filter-active');

                portfolioIsotope.arrange({
                    filter: this.getAttribute('data-filter')
                });
                portfolioIsotope.on('arrangeComplete', function () {
                    AOS.refresh()
                });
            }, true);
        }

    });

    /**
     * Initiate portfolio lightbox
     */
    const portfolioLightbox = GLightbox({
        selector: '.portfolio-lightbox'
    });

    /**
     * Portfolio details slider
     */
    new Swiper('.portfolio-details-slider', {
        speed: 400,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        }
    });

    /**
     * Animation on scroll
     */
    window.addEventListener('load', () => {
        AOS.init({
            duration: 1000,
            easing: "ease-in-out",
            once: true,
            mirror: false
        });
    });

    /**
     * Initiate Pure Counter
     */
    new PureCounter();

})()