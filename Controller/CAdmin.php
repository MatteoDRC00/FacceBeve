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
     * @var CAdmin|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CAdmin $instance = null;

    /**
     * Costruttore di classe.
     */
    private function __construct(){

    }

    /**
     * Restituisce l'istanza della classe.
     * @return CAdmin|null
     */
    public static function getInstance(): ?CAdmin {
        if(!isset(self::$instance)) {
            self::$instance = new CAdmin();
        }
        return self::$instance;
    }

    /**
     * Metodo che instanzia
     * @throws SmartyException
     */
    public function dashboardAdmin(){
        $sessione = new USession();
        $view = new VAdmin();
        if($sessione->isLogged() && ($sessione->leggi_valore("tipo_utente") == "EAdmin")){
            $pm = FPersistentManager::getInstance();

            //loadUtenti --> Separo in Utenti attivi e Bannati
            $utentiAttivi = $pm->loadUtentiByState(1);
            $utentiBannati = $pm->loadUtentiByState(0);


            //loadCategorie
            $categorie = $pm->getCategorie();

            //loadRecensioni segnalate
            $recSegnalate = $pm->load("segnalato",true,"FRecensione");

            $view->HomeAdmin($utentiAttivi, $utentiBannati, $categorie,$recSegnalate);
        }else{
            header('Location: /Accesso/login');
        }
    }


/*
    /**
     * Funzione utilizzata per visualizzare la homepage dell'amministratore, nella quale sono presenti tutti gli utenti della piattaforma.
     * Gli utenti sono divisi in due liste: bannati e attivi
     * @throws SmartyException

    public function getUtentiAttivi() {
        $sessione = new USession();
        $tipo=$sessione->leggi_valore('tipo_utente');
        $view = new VAdmin();
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo== "admin") {
            // visualizza elenco utenti attivi
            $utentiAttivi = $pm->loadUtenti(1);
            $img_attivi = static::set_immagini($utentiAttivi); //non so a cosa serve set_immagini
            $view->getUtentiAttivi($utentiAttivi,$img_attivi);
        } else {
                $view = new VError();
                $view->error(1);
        }
    }*/

    /**
     * in base vengono restituiti la lista di utenti attivi o bannati
     * @param $tipo Int 0-> utenti bannati ; 1->utenti attivi
     * @return void
     * @throws SmartyException

    public static function getUtenti($tipo){
        $sessione = new USession();
        $tipo=$sessione->leggi_valore('tipo_utente');
        $view = new VAdmin();
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo== "admin") {
            $utenti = $pm->loadUtenti($tipo);
            $view->showUtenti($utenti);
        } else {
            $view = new VError();
            $view->error(1);
        }
    }*/


    /**
     * Metodo utilizzato dal Admin per aggiungere categorie sul sito.
     * @throws SmartyException
     */
    public function aggiungiCategoria(){
        $sessione = new USession();
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            $view = new VAdmin();
            if(($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")){
                $pm = FPersistentManager::getInstance();
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
            header('Location: /FacceBeve/Ricerca/MostraHome');
        }
    }

    /**
     * Metodo utilizzato dal Admin per cancellare categorie dal sito.
     */
    public function rimuoviCategoria($id)
    {
        $sessione = new USession();
        $utente = unserialize($sessione->leggi_valore('utente'));
        if ($sessione->isLogged()) {
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
            $view = new VError();
            $view->error(1);
        }
    }


    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a false).
     * Se  si è loggati come utente (non amministratore) compare una pagina di errore 401.
     **/
    public function bannaUtente(){
    $sessione = new USession();
    if($sessione->isLogged()){
        $view = new VAdmin();
        $pm = FPersistentManager()::getIstance();
        $username = $view->getUsername();
        $utente = $pm->load("username", $username, "FUtente");
        $utente->setState(0);
        $pm->update("FUtente", "state", $utente->getState(), "username", $username);
        header('Location: /FacceBeve/Admin/homepage');
    }else{
            $view = new VError();
            $view->error(1);
        }
    }

    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a true-->riattiva l'utente).
     * Se si è loggati come utente (non amministratore) compare una pagina di errore 401.
    */
    public function attivaUtente(){
        $sessione = new USession();
        if($sessione->isLogged()) {
            $view = new VAdmin();
            $pm = FPersistentManager()::getIstance();
            $username = $view->getUsername();
            $utente = $pm->load("username", $username, "Futente");
            $utente->setState(1);
            $pm->update("FUtente", "state", $utente->getState(1), "username", $username);
            header('Location: /FacceBeve/Admin/dashboard');
        }else{
            $view = new VError();
            $view->error(1);
        }
    }

    /**
     * Funzione che permette la visualizzazione dell'elenco delle recensioni pubblicate.
     */
    public function recensioni() { //Secondo me solo quelle segnalate
        $sessione = new USession();
            if ($sessione->isLogged()){
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

    /**
     * Funzione utile per eliminare una recensione segnalata.
     *
     * @param $id
     * @throws SmartyException
     */
    public static function eliminaRec($id){
        $sessione = new USession();
        if($sessione->isLogged()) {
            $pm = FPersistentManager()::getIstance();
            $pm->delete("id", $id, "FRecensione");
            header('Location: /FacceBeve/Admin/recensioni');
        }else{
            $view = new VError();
            $view->error(1);
        }
    }

    /**
     * Funzione utilizzata per visualizzare l'elenco dei locali registrati sul sito.

    static function locali(){
        $sessione = new USession();
            if ($sessione->isLogged()) {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
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
    } */

    /**
     * Funzione utile per cambiare lo stato di visibilità di un locale (nel caso specifico porta la visibilità a false).
     * @param $id annuncio da bannare
     * @throws SmartyException

    static function bannaLocale($id){
        $sessione = new USession();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = FPersistentManager()::getIstance();
            $pm->update("visibility", 0, "id", $id, "FLocali");
            header('Location: /FacceBeve/Admin/annunci');
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
    } */

    /**
     * Funzione utile per cambiare lo stato di visibilità di un annuncio (nel caso specifico porta la visibilità a true).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento allapagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di riattivare l'annuncio selezionato
     * 	  cambiando il suo stato di visibilità a true;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id annuncio da bannare
     * @throws SmartyException

    static function ripristinaLocale($id){
        $$sessione = new USession();
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
    } */


    /**
     * Funzione utile per ricercare tutti i locali che contengano una determinata espressione nel loro campo descrizione
     * @throws SmartyException

    static function ricercaParolaLocale(){
        $sessione = new USession();
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
    }*/

    /**
     * Funzione utile per eseguire delle ricerche mirate su parole contenute nelle recensioni.
     * @throws SmartyException
     */
    static function ricercaParolaRecensione(){
        $sessione = new USession();
        if($sessione->isLogged()) {
            $pm = FPersistentManager()::getIstance();
            $view = new VAdmin();
            $parola = $view->getParola();
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
    }

    /**
     * Funzione utile per eseguire ricerche sugli utenti.
     * @throws SmartyException
     */
    static function ricercaUtente() {
        $sessione = new USession();
        if ($sessione->isLogged()) {
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
    }
}