<?php


/**
 * La classe CAdmin implementa funzionalità per l'admin della piattaforma, al quale è consentito
 * bannare/attivare utenti, eliminare recensioni, bannare/ripristinare annunci e cercare annunci, recensioni e utenti
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
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    $view = new VAdmin();
                    $pm = new FPersistentManager();
                    //visualizza elenco utenti attivi e bannati
                    $utentiAttivi = $pm->loadUtenti(1);
                    $utentiBannati = $pm->loadUtenti(0);
                    $img_attivi = static::set_immagini($utentiAttivi);
                    $img_bann = static::set_immagini($utentiBannati);
                    $view->HomeAdmin($utentiAttivi, $utentiBannati,$img_attivi,$img_bann);
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
     * Funzione di supporto per le altre.
     * Questo ha il compito di restituire:
     * 1) array di oggetti EMediaUtente, se il paramtero in ingressto è un array di EUtenteloggato;
     * 2) un oggetto EMediaUtente, se il parametro in ingresso è un EUtenteloggato;
     * 3) null, se la variabile in ingresso non è definita.
     * @param $utenti
     * @return array|null|object
     */
    static function set_immagini($utenti){
        $pm = new FPersistentManager();
        $img = null;
        if (isset($utenti)) {
            if (is_array($utenti)) {
                foreach ($utenti as $item) {
                    $img[] = $pm->load("emailutente", $item->getEmail(), "FMediaUtente");
                }
            } else
                $img = $pm->load("emailutente", $utenti->getEmail(), "FMediaUtente");
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
     */
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
    }

    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a true).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di riattivare l'utente
     * 	  cambiando il suo stato di visibilità a true con conseguente attivazione degli annunci (prima in stato di blocco) da lui pubblicati;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     */
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
    }

    /**
     * Funzione che permette la visulaizzazione dell'elenco delle recensioni pubblicate.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, viene visualizzata la pagina con tutte le recensioni;
     * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
     * 3) altrimenti, reindirizza alla pagina di login.
     */
    static function recensioni() {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    $view = new VAdmin();
                    $pm = new FPersistentManager();
                    $recensione = $pm->loadAllRec();
                    $img = null;
                    if (is_array($recensione)) {
                        foreach ($recensione as $rec) {
                            $ute = $pm->load("email", $rec->getEmailClient(), "FUtenteloggato");
                            $img[] = $pm->load("emailutente",$rec->getEmailClient(),"FMediaUtente");
                            $rec->setEmailClient($ute);
                        }
                    } elseif ($recensione != null) {
                        $ute = $pm->load("email", $recensione->getEmailClient(), "FUtenteloggato");
                        $img = $pm->load("emailutente",$recensione->getEmailClient(),"FMediaUtente");
                        $recensione->setEmailClient($ute);
                    }
                    $view->showRevPage($recensione,$img);
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
     * Funzione utile per eliminare una recensione.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenente tutte le recensioni;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di eliminare una recensione;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id
     * @throws SmartyException
     */
    static function eliminaRec($id){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = new FPersistentManager();
            $pm->delete("id", $id, "FRecensione");
            header('Location: /FillSpaceWEB/Admin/recensioni');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/recensioni');
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
     * Funzione utilizzata per visualizzare l'elenco degli annunci.
     * Gli anunci sono divisi in due liste: bannati e attivi.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati con le credenziali dell'amministratore viene visualizzata la pagina con l'elenco di tutti gli annunci;
     * 2) se il metodo di richiesta HTTP è GET e si è loggati ma non come amministratore, viene visualizzata una pagina di errore 401;
     * 3) altrimenti, reindirizza alla pagina di login.
     */
    static function annunci(){
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    $view = new VAdmin();
                    $pm = new FPersistentManager();
                    $annunciAttivi = $pm->load("visibility", 1, "FAnnuncio");
                    $utentiAttivi = null;
                    if (is_array($annunciAttivi)) {
                        foreach ($annunciAttivi as $item)
                            $utentiAttivi[] = $item->getEmailWriter();
                    }

                    elseif (isset($annunciAttivi))
                        $utentiAttivi = $annunciAttivi->getEmailWriter();
                    $img_attivi = static::set_immagini($utentiAttivi);
                    $annunciBannati = $pm->load("visibility", 0, "FAnnuncio");
                    $utentiBannati = null;
                    if (is_array($annunciBannati)) {
                        foreach ($annunciBannati as $item)
                            $utentiBannati[] = $item->getEmailWriter();
                    }
                    elseif (isset($annunciBannati))
                        $utentiBannati = $annunciBannati->getEmailWriter();
                    $img_bann = static::set_immagini($utentiBannati);
                    $view->showAdsPage($annunciAttivi, $annunciBannati,$img_attivi,$img_bann);
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
     * Funzione utile per cambiare lo stato di visibilità di un annuncio (nel caso specifico porta la visibilità a false).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento allapagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di bannare l'annuncio selezionato
     * 	  cambiando il suo stato di visibilità a false;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id annuncio da bannare
     * @throws SmartyException
     */
    static function bannaAnnuncio($id){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = new FPersistentManager();
            //$annuncio = $pm->load("idAd", $id, "FAnnuncio");
            $pm->update("visibility", 0, "idAd", $id, "FAnnuncio");
            header('Location: /FillSpaceWEB/Admin/annunci');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/annunci');
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
    static function ripristinaAnnuncio($id){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = new FPersistentManager();
            //$annuncio = $pm->load("idAd", $id, "FAnnuncio");
            $pm->update("visibility", 1, "idAd", $id, "FAnnuncio");
            header('Location: /FillSpaceWEB/Admin/annunci');
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/annunci');
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
     * Funzione utile per ricercare tutti gli annunci che contengano una determinata espressione nel loro campo descrizione
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla pagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione della ricerca degli annunci;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id annuncio da bannare
     * @throws SmartyException
     */
    static function ricercaParolaAnnuncio(){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $view = new VAdmin();
            $pm = new FPersistentManager();
            $parola = $_POST['parola'];
            $result = $pm->loadByParola($parola, "FAnnuncio");
            $utentiAttivi = null;
            $annunciAttivi = null;
            $annunciBannati = null;
            $utentiBannati = null;
            if (is_object($result)){
                if ($result->getVisibility()) {
                    $annunciAttivi = $result;
                    $utentiAttivi = $annunciAttivi->getEmailWriter();
                }
                else {
                    $annunciBannati = $result;
                    $utentiBannati = $annunciBannati->getEmailWriter();
                }
            }
            elseif (is_array($result)){
                $a = 0;
                $b = 0;
                for ($i = 0; $i<count($result); $i++){
                    if ($result[$i]->getVisibility()) {
                        $annunciAttivi[$a] = $result[$i];
                        $utentiAttivi[$a] = $result[$i]->getEmailWriter();
                        $i++;
                        $a++;
                    }
                    else {
                        $annunciBannati[$b] = $result[$i];
                        $utentiBannati[$b] = $result[$i]->getEmailWriter();
                        $i++;
                        $b++;
                    }
                }
            }
            $img_attivi = static::set_immagini($utentiAttivi);
            $img_bannati = static::set_immagini($utentiBannati);
            $view->showAdsPage($annunciAttivi, $annunciBannati, $img_attivi, $img_bannati);
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/annunci');
                }
                else {
                    //header('Location: /FillSpaceWEB/Utente/error');
                    $view = new VError();
                    $view->error('1');
                }
            }
            else
                header('Location: /FillSpaceWEB/Utente/login');
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
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = new FPersistentManager();
            $view = new VAdmin();
            $parola = $_POST['parola'];
            $recensione = $pm->loadByParola($parola, "FRecensione");
            $img = null;
            if (is_array($recensione)) {
                foreach ($recensione as $rec) {
                    $ute = $pm->load("email", $rec->getEmailClient(), "FUtenteloggato");
                    $img[] = $pm->load("emailutente",$rec->getEmailClient(),"FMediaUtente");
                    $rec->setEmailClient($ute);
                }
            } elseif ($recensione != null) {
                $ute = $pm->load("email", $recensione->getEmailClient(), "FUtenteloggato");
                $img = $pm->load("emailutente",$recensione->getEmailClient(),"FMediaUtente");
                $recensione->setEmailClient($ute);
            }
            $view->showRevPage($recensione,$img);
        }
        elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged()) {
                $utente = unserialize($_SESSION['utente']);
                if ($utente->getEmail() == "admin@admin.com") {
                    header('Location: /FillSpaceWEB/Admin/recensioni');
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
     * Funzione utile per eseguire delle ricerche mirate sul nome/cognome degli utenti.
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento alla homepage dell'amministratore;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di ricerca della parola tra i nomi/cognomi degli utenti;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     */
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
    }
}