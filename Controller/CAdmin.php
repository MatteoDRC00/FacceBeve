<?php


/**
 * La classe CAdmin implementa funzionalità per l'admin della piattaforma, al quale è consentito
 * bannare/attivare utenti, eliminare recensioni, bannare/ripristinare locali e cercare annunci, recensioni e utenti
 * filtrando i dati del database attraverso un campo di ricerca.
 * @author Gruppo8
 * @package Controller
 */
class CAdmin{
    /**
     * Funzione utilizzata per visualizzare la homepage dell'amministratore, nella quale sono presenti tutti gli utenti della piattaforma.
     * Gli utenti sono divisi in due liste: bannati e attivi.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati con le credenziali dell'amministratore viene visualizzata la homepage con l'elenco di tutti gli utenti;
     * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
     * 3) altrimenti, reindirizza alla pagina di login.
     * @throws SmartyException
     */
    public function homepage() {
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                    $view = new VAdmin();
                    $pm = FPersistentManager()::getIstance();
                   // visualizza elenco utenti attivi e bannati
                    $utentiAttivi = $pm->loadUtenti(1);
                    $utentiBannati = $pm->loadUtenti(0);
                    $img_attivi = static::set_immagini($utentiAttivi);
                    $img_bann = static::set_immagini($utentiBannati);
                    $categorie = $pm->loadAll("FCategoria");
                    $view->HomeAdmin($utentiAttivi, $utentiBannati,$img_attivi,$img_bann,$categorie);
                }
                else {
                    $view = new VError();
                    $view->error(1);
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione di supporto per le altre.
     * Questo ha il compito di restituire:
     * 1) array di oggetti EImmagine, se il parametro in ingresso è un array di EUtente;
     * 2) un oggetto EImmagine, se il parametro in ingresso è un EUtente;
     * 3) null, se la variabile in ingresso non è definita.
     * @param $utenti
     * @param $tipo se FUtente o FProprietario
     * @return array|null|object
     */
    public function set_immagini($utenti, $tipo){
        $pm = FPersistentManager()::getIstance();
        $img = null;
        if (isset($utenti)) {
            if (is_array($utenti)) {
                foreach ($utenti as $item) {
                    $x = $pm->load("username", $item->getUsername(), $tipo);
                    $img[] = $pm->load("id",$x->getImgProfilo(),"FImmagine");
                }
            } else
                $x = $pm->load("username", $utenti->getUsername(), $tipo);
                $img[] = $pm->load("id",$x->getImgProfilo(),"FImmagine");
        }
        return $img;
    }

    /**
     * Metodo utilizzato dal Admin per aggiungere categorie sul sito.
     * @throws SmartyException
     */
    public function aggiungiCategoria(){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if($sessione->leggi_valore('utente')){
                $utente = unserialize($sessione->leggi_valore('utente'));
                $view = new VAdmin();
                if(($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")){
                    $pm = FPersistentManager()::getIstance();
                    $genere = $view->getGenere();
                    $descrizione = $view->getDescrizione();
                    $categoria = $pm->exist("FCategoria", genere,$genere );
                    if(!$categoria){
                        $Categoria = new ECategoria($genere,$descrizione);
                        $pm->store($Categoria);
                        $error = null;
                    }else{
                        $error = "wrongCategory";
                    }
                    $view->showFormCategoria($utente,$error);
                }else{
                    $view = new VError();
                    $view->error(1);
                }
            }else{
                header('Location: /FacceBeve/');
            }

        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                $view = new VAdmin();
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin"))  {
                    //header('Location: /FacceBeve/Admin/homepage');
                    $view->showFormCategoria($sessione->leggi_valore('utente'), null);
                }
                else {
                    $view = new VError();
                    $view->error(1);
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Metodo utilizzato dal Admin per cancellare categorie dal sito.
     */
    public function rimuoviCategoria($id)
    {
        $sessione = USession::getInstance();
        $utente = unserialize($sessione->leggi_valore('utente'));
        if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
            $pm = FPersistentManager::getIstance();
            $x = $pm->loadAll("FCategoria");
            if (is_array($x)) {
                foreach ($x as $y) {
                    if ($id == $y->getGenere()) {
                        $pm->delete("genere", $id, "FCategoria");
                        header('Location: /FacceBeve/Admin/homepage');
                    }
                }
            } elseif (isset($x)) {
                if ($id == $x->getGenere()) {
                    $pm->delete("genere", $id, "FCategoria");
                    header('Location: /FacceBeve/Admin/homepage');
                }
            } else {
                header('Location: /FacceBeve/Admin/homepage');
            }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }


    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a false).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di bannare l'utente
     * 	  cambiando il suo stato di visibilità a false con conseguente bannamento delle sue recensioni;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     **/
    public function bannaUtente(){
    $sessione = USession::getInstance();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $view = new VAdmin();
        $pm = FPersistentManager()::getIstance();
        $username = $view->getUsername();
        $utente = $pm->load("username", $username, "FUtente");
        $utente->setState(0);
        $pm->update("FUtente", "state", $utente->getState(), "username", $username);
        header('Location: /FacceBeve/Admin/homepage');
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        if ($sessione->leggi_valore('utente')) {
            $utente = unserialize($sessione->leggi_valore('utente'));
            if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                header('Location: /FacceBeve/Admin/homepage');
            } else {
                $view = new VError();
                $view->error(1);
            }
        } else
            header('Location: /FacceBeve/Utente/login');
    }
    }

    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a true).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di riattivare l'utente
     * 	  cambiando il suo stato di visibilità a true con conseguente attivazione degli annunci (prima in stato di blocco) da lui pubblicati;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
    */
    public function attivaUtente(){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = FPersistentManager()::getIstance();
            $username = $view->getUsername();
            $utente = $pm->load("username", $username, "Futente");
            $utente->setState(1);
            $pm->update("FUtente", "state", $utente->getState(1), "username", $username);
           // $pm->update("visibility",true,"emailWriter",$email,"FAnnuncio");
            header('Location: /FacceBeve/Admin/homepage');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                    header('Location: /FacceBeve/Admin/homepage');
                }
                else {
                    $view = new VError();
                    $view->error(1);
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione che permette la visualizzazione dell'elenco delle recensioni pubblicate.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, viene visualizzata la pagina con tutte le recensioni;
     * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
     * 3) altrimenti, reindirizza alla pagina di login.
     */
    static function recensioni() { //Secondo me solo quelle segnalate
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                    $view = new VAdmin();
                    $pm = FPersistentManager()::getIstance();
                    $recensione = $pm->loadAllRec();
                    $img = null;
                    if (is_array($recensione)) {
                        foreach ($recensione as $rec) {
                           // $ute = $pm->load("username", $rec->getUtente()->getUsername(), "FUtente");
                            $img[] = $pm->load("id",$rec->getUtente()->getImgProfilo(),"FImmagine");
                        }
                    } elseif ($recensione != null) {
                        //$ute = $pm->load("email", $recensione->getEmailClient(), "FUtente");
                        $img = $pm->load("id",$recensione->getUtente()->getImgProfilo(),"FImmagine");
                    }
                    $view->showRevPage($recensione,$img); //vai sulla view
                }
                else {
                    $view = new VError();
                    $view->error(1);
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }

    }

    /**
     * Funzione utile per eliminare una recensione segnalata.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenente tutte le recensioni;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di eliminare una recensione;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id
     * @throws SmartyException
     */
    static function eliminaRec($id){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = FPersistentManager()::getIstance();
            $pm->delete("id", $id, "FRecensione");
            header('Location: /FacceBeve/Admin/recensioni');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                    header('Location: /FacceBeve/Admin/recensioni');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione utilizzata per visualizzare l'elenco dei locali registrati sul sito.
     * I locali sono divisi in due liste: bannati e attivi.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati con le credenziali dell'amministratore viene visualizzata la pagina con l'elenco di tutti gli annunci;
     * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
     * 3) altrimenti, reindirizza alla pagina di login.
     */
    static function locali(){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if ($utente->getEmail() == "admin@admin.com") {
                    $view = new VAdmin();
                    $pm = FPersistentManager()::getIstance();
                    $localiAttivi = $pm->load("visibility", 1, "FLocale");
                    $Proprietari = null;
                    if (is_array($localiAttivi)) {
                        foreach ($localiAttivi as $item)
                            $Proprietari[] = $item->getProprietario();
                    }
                    elseif (isset($localiAttivi))
                        $Proprietari = $localiAttivi->getProprietario();
                    $img_attivi = static::set_immagini(Proprietari,"FProprietario");
                    $localiBannati = $pm->load("visibility", 0, "FLocale");
                    $ProprietariB = null;
                    if (is_array($localiBannati)) {
                        foreach ($localiBannati as $item)
                            $ProprietariB[] = $item->getProprietario();
                    }
                    elseif (isset($localiBannati))
                        $ProprietariB = $localiAttivi->getProprietario();
                    $img_bann = static::set_immagini($ProprietariB,"FProprietario");
                    $view->showLocalPage($localiAttivi, $localiBannati,$img_attivi,$img_bann); //Ipoteticamente aggiugni anche i proprietari
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione utile per cambiare lo stato di visibilità di un locale (nel caso specifico porta la visibilità a false).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di bannare l'annuncio selezionato
     * 	  cambiando il suo stato di visibilità a false;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id annuncio da bannare
     * @throws SmartyException
     */
    static function bannaLocale($id){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = FPersistentManager()::getIstance();
            $pm->update("visibility", 0, "id", $id, "FLocali");
            header('Location: /FillSpaceWEB/Admin/annunci');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                    header('Location: /FacceBeve/Admin/locali');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FillSpaceWEB/Utente/login');
        }
    }

    /**
     * Funzione utile per cambiare lo stato di visibilità di un annuncio (nel caso specifico porta la visibilità a true).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento allapagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di riattivare l'annuncio selezionato
     * 	  cambiando il suo stato di visibilità a true;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id annuncio da bannare
     * @throws SmartyException
     */
    static function ripristinaLocale($id){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = FPersistentManager()::getIstance();
            $pm->update("visibility", 1, "id", $id, "FLocale");
            header('Location: /FillSpaceWEB/Admin/annunci');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                    header('Location: /FacceBeve/Admin/locali');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }


    /**
     * Funzione utile per ricercare tutti i locali che contengano una determinata espressione nel loro campo descrizione
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione della ricerca degli annunci;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @throws SmartyException
     */
    static function ricercaParolaLocale(){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = FPersistentManager()::getIstance();
            $parola = $view->getParola();
            $result = $pm->loadByParola($parola, "FLocale");
            $utentiAttivi = null;
            $localiAttivi = null;
            $localiBannati = null;
            $utentiBannati = null; //Proprietari di locali bannati, cosa ci facciamo???????
            if (is_object($result)){
                if ($result->getVisibility()) {
                    $localiAttivi = $result;
                    $utentiAttivi = $localiAttivi->getProprietario();
                }
                else {
                    $localiBannati = $result;
                    $utentiBannati = $localiBannati->getProprietario();
                }
            }
            elseif (is_array($result)){
                $a = 0;
                $b = 0;
                for ($i = 0; $i<count($result); $i++){
                    if ($result[$i]->getVisibility()) {
                        $localiAttivi[$a] = $result[$i];
                        $utentiAttivi[$a] = $result[$i]->getProprietario();
                        $i++;
                        $a++;
                    }
                    else {
                        $localiBannati[$b] = $result[$i];
                        $utentiBannati[$b] = $result[$i]->getProprietario();
                        $i++;
                        $b++;
                    }
                }
            }
            $img_attivi = static::set_immagini($utentiAttivi);
            $img_bannati = static::set_immagini($utentiBannati);
            $view->showAdsPage($localiAttivi, $localiBannati, $img_attivi, $img_bannati);
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")){
                    header('Location: /FacceBeve/Admin/locali');
                }
                else {
                    //header('Location: /FillSpaceWEB/Utente/error');
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione utile per eseguire delle ricerche mirate su parole contenute nelle recensioni.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenente l'elenco delle recensioni;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di ricerca della parola nel testo della recensione;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @throws SmartyException
     */
    static function ricercaParolaRecensione(){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = FPersistentManager()::getIstance();
            $view = new VAdmin();
            $parola = $_POST['parola'];
            $recensione = $pm->loadByParola($parola, "FRecensione");
            $img = null;
            if (is_array($recensione)) {
                foreach ($recensione as $rec) {
                    // $ute = $pm->load("username", $rec->getUtente()->getUsername(), "FUtente");
                    $img[] = $pm->load("id",$rec->getUtente()->getImgProfilo(),"FImmagine");
                }
            } elseif ($recensione != null) {
                //$ute = $pm->load("email", $recensione->getEmailClient(), "FUtente");
                $img = $pm->load("id",$recensione->getUtente()->getImgProfilo(),"FImmagine");
            }
            $view->showRevPage($recensione,$img);
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                    header('Location: /FacceBeve/Admin/recensioni');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione utile per eseguire ricerche degli utenti.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di ricerca della parola tra i nomi/cognomi degli utenti;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @throws SmartyException
     */
    static function ricercaUtente() {
        $sessione = USession::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = FPersistentManager()::getIstance();
            $stringa = $view->getParola();
            $result = $pm->loadUtentiByString($stringa);
            $utentiBan = array();
            $utentiAttivi = array();
            if (is_object($result)) {
                if ($result->getState())
                    $utentiAttivi[] = $result;
                else
                    $utentiBan[] = $result;
            } elseif (is_array($result)) {
                foreach ($result as $item) {
                    if ($item->getState())
                        $utentiAttivi[] = $item;
                    else
                        $utentiBan[] = $item;
                }
            }
            $img_attivi = static::set_immagini($utentiAttivi);
            $img_bann = static::set_immagini($utentiBan);
            $view->HomeAdmin($utentiAttivi, $utentiBan,$img_attivi,$img_bann);
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")){
                    header('Location: /FacceBeve/Admin/homepage');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FacceBeve/Utente/login');
        }
    }
}