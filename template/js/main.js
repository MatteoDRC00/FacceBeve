function validateRegForm(id){
    if(id===1){
        let password1 = document.forms.registrazioneProprietario.elements.password1.value;
        let password2 = document.forms.registrazioneProprietario.elements.password2.value;
        let nome = document.forms.registrazioneProprietario.elements.nome.value;
        let cognome = document.forms.registrazioneProprietario.elements.cognome.value;
        let username = document.forms.registrazioneProprietario.elements.username.value;
        let email = document.forms.registrazioneProprietario.elements.email.value;
        let img = document.forms.registrazioneProprietario.elements.img_profilo.value;

        if(nome==="" || cognome==="" || email==="" || username==="" || password1==="" || password2==="" || img===""){
            alert("Inserire i campi mancanti");
            return false;
        }
        if(password1 !== password2){
            alert("Le password inserite non corrispondono!");
            return false;
        }
        var allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i; //Controllo sul Type del img inserita

        if (!allowedExtensions.exec(img)) {
            alert('Tipo di file non valido');
            img.value = '';
            return false;
        }
    }else{
        let password1 = document.forms.registrazioneUtente.elements.password1.value;
        let password2 = document.forms.registrazioneUtente.elements.password2.value;
        let nome = document.forms.registrazioneUtente.elements.nome.value;
        let cognome = document.forms.registrazioneUtente.elements.cognome.value;
        let username = document.forms.registrazioneUtente.elements.username.value;
        let email = document.forms.registrazioneUtente.elements.email.value;
        let img = document.forms.registrazioneUtente.elements.img_profilo.value;

        if(nome==="" || cognome==="" || email==="" || username==="" || password1==="" || password2==="" || img===""){
            alert("Inserire i campi mancanti");
            return false;
        }
        if(password1 !== password2){
            alert("Le password inserite non corrispondono!");
            return false;
        }
        var allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i; //Controllo sul Type del img inserita

        if (!allowedExtensions.exec(img)) {
            alert('Tipo di file non valido');
            img.value = '';
            return false;
        }
    }
}



/**
 *Funzione utilizzata per controllare che venga inserito almeno un valore nei campi del form di ricerca
 */
function validateResearchForm(id) {
    if(id===1){
        let x = document.getElementById("tipo");
        let y = x.value;
        if (y === "Locali") {
            let citta = document.forms.ricercaLocali1.elements.citta1.value;
            let nome = document.forms.ricercaLocali1.elements.nomeLocale1.value;
            var k = document.forms.ricercaLocali1.elements.categorie1;
            var categoria = "";
            if(k.checked){
                var categoria = document.forms.ricercaLocali1.elements.categorie1.value;
            }
            if (citta === "" && nome === "" && categoria === "" ) {
                window.alert("Inserire almeno un campo per effettuare la ricerca ");
                return false;
            }
        } else {
            let citta = document.forms.ricercaEventi.elements.citta.value;
            let nomeLocale = document.forms.ricercaEventi.elements.nomeLocale.value;
            let nomeEvento = document.forms.ricercaEventi.elements.nomeEvento.value;
            let dataEvento = document.forms.ricercaEventi.elements.dataEvento.value;

            let DataEvento = new Date(dataEvento);
            let Oggi = new Date();

            if (citta === "" && nomeLocale === "" && nomeEvento === "" && dataEvento === "") {
                window.alert("Inserire almeno un campo per effettuare la ricerca");
                return false;
            }

            if (DataEvento.getTime() < Oggi.getTime()) {
                alert('La data del evento è precedente ad adesso, effettuare ricerche potrebbe piegare lo spazio-tempo')
                return false;
            }
        }
    }
    else{
            let citta = document.forms.ricercaLocali0.elements.citta.value;
            let nome = document.forms.ricercaLocali0.elements.nomeLocale.value;
            var k = document.forms.ricercaLocali0.elements.categorie;
            var categoria = "";
            if(k.checked){
               var categoria = document.forms.ricercaLocali0.elements.categorie.value;
            }
            if (citta === "" && nome === "" && categoria === "" ) {
              window.alert("Inserire almeno un campo per effettuare la ricerca ");
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

            } else {
                q.style.display = "inline-block";
                z = document.getElementById("Locali");
                z.style.display = "none";
            }
        }







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