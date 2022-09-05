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
     */
    static function homepage () {
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if ($utente->getEmail() == "admin@admin.com") {
                    $view = new VAdmin();
                    $pm = new FPersistentManager();
                    /**visualizza elenco utenti attivi e bannati
                    $utentiAttivi = $pm->loadUtenti(1);
                    $utentiBannati = $pm->loadUtenti(0);
                    $img_attivi = static::set_immagini($utentiAttivi);
                    $img_bann = static::set_immagini($utentiBannati);
                    $view->HomeAdmin($utentiAttivi, $utentiBannati,$img_attivi,$img_bann);*/
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
     * Funzione di supporto per le altre.
     * Questo ha il compito di restituire:
     * 1) array di oggetti EImmagine, se il parametro in ingresso è un array di EUtente;
     * 2) un oggetto EImmagine, se il parametro in ingresso è un EUtente;
     * 3) null, se la variabile in ingresso non è definita.
     * @param $utenti
     * @param $tipo se FUtente o FProprietario
     * @return array|null|object
     */
    static function set_immagini($utenti, $tipo){
        $pm = new FPersistentManager();
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
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a false).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di bannare l'utente
     * 	  cambiando il suo stato di visibilità a false con conseguente blocco degli annunci da lui pubblicati;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.

    static function bannaUtente(){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = new FPersistentManager();
            $email = $view->getEmail();
            $utente = $pm->load("email", $email, "FUtenteloggato");
            $pm->update("state", $utente->setHid(), "email", $email, "FUtenteloggato");
            $pm->update("visibility",false,"emailWriter",$email,"FAnnuncio");
            header('Location: /FillSpaceWEB/Admin/homepage');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/homepage');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FillSpaceWEB/Utente/login');
        }
    } */

    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a true).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di riattivare l'utente
     * 	  cambiando il suo stato di visibilità a true con conseguente attivazione degli annunci (prima in stato di blocco) da lui pubblicati;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.

    static function attivaUtente(){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = new FPersistentManager();
            $email = $view->getEmail();
            //$utente = $pm->load("email", $email, "FUtenteloggato");
            $pm->update("state", 1, "email", $email, "FUtenteloggato");
            $pm->update("visibility",true,"emailWriter",$email,"FAnnuncio");
            header('Location: /FillSpaceWEB/Admin/homepage');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/homepage');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FillSpaceWEB/Utente/login');
        }
    } */

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
                if ($utente->getEmail() == "admin@admin.com") {
                    $view = new VAdmin();
                    $pm = new FPersistentManager();
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
                    $view->error('1');
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
            $pm = new FPersistentManager();
            $pm->delete("id", $id, "FRecensione");
            header('Location: /FacceBeve/Admin/recensioni');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if ($utente->getEmail() == "admin@admin.com") {
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
                    $pm = new FPersistentManager();
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
            $pm = new FPersistentManager();
            //$annuncio = $pm->load("idAd", $id, "FAnnuncio");
            $pm->update("visibility", 0, "id", $id, "FLocali");
            header('Location: /FillSpaceWEB/Admin/annunci');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if ($utente->getEmail() == "admin@admin.com") {
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
            $pm = new FPersistentManager();
            //$annuncio = $pm->load("idAd", $id, "FAnnuncio");
            $pm->update("visibility", 1, "id", $id, "FLocale");
            header('Location: /FillSpaceWEB/Admin/annunci');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($sessione->leggi_valore('utente')) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if ($utente->getEmail() == "admin@admin.com") {
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
     * Funzione utile per ricercare tutti gli annunci che contengano una determinata espressione nel loro campo descrizione
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione della ricerca degli annunci;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id annuncio da bannare
     * @throws SmartyException
     */
    static function ricercaParolaLocale(){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = new FPersistentManager();
            $parola = $view->getParola();
            $result = $pm->loadByParola($parola, "FLocale");
            $utentiAttivi = null;
            $localiAttivi = null;
            $localiBannati = null;
            $utentiBannati = null;
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
                        $localiAttivi[$a] = $result[$i]->getProprietario();
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
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FacceBeve/Admin/annunci');
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
     */
    static function ricercaParolaRecensione(){
        $sessione = USession::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = new FPersistentManager();
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
                if ($utente->getEmail() == "admin@admin.com") {
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
     * Funzione utile per eseguire delle ricerche mirate sul nome/cognome degli utenti.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di ricerca della parola tra i nomi/cognomi degli utenti;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.

    static function ricercaUtente() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = new FPersistentManager();
            $stringa = $_POST['parola'];
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
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/homepage');
                }
                else {
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FillSpaceWEB/Utente/login');
        }
    }*/
}