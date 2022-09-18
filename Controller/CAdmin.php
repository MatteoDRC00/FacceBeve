<?php
require_once "autoload.php";
require_once "utility/USession.php";
require_once "utility/UCheck.php";

/**
 * La classe CAdmin implementa funzionalità per l'admin della piattaforma, al quale è consentito
 * bannare/attivare utenti, eliminare recensioni, bannare/ripristinare locali e cercare annunci, recensioni e utenti
 * filtrando i dati del database attraverso un campo di ricerca.
 * @author Gruppo8
 * @package Controller
 */
class CAdmin
{


    /**
     * @var CAdmin|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CAdmin $instance = null;

    /**
     * Costruttore di classe.
     */
    private function __construct()
    {

    }

    /**
     * Restituisce l'istanza della classe.
     * @return CAdmin|null
     */
    public static function getInstance(): ?CAdmin
    {
        if (!isset(self::$instance)) {
            self::$instance = new CAdmin();
        }
        return self::$instance;
    }

    /**
     * Metodo che instanzia
     * @throws SmartyException
     */
    public function dashboardAdmin()
    {
        $sessione = new USession();
        $view = new VAdmin();
        if ($sessione->isLogged() && ($sessione->leggi_valore("tipo_utente") == "EAdmin")) {
            $pm = FPersistentManager::getInstance();
            $check = UCheck::getInstance();

            //loadUtenti --> Separo in Utenti attivi e Bannati
            $utentiAttivi = $check->check($pm->loadUtentiByState(1));
            $utentiBannati = $check->check($pm->loadUtentiByState(0));

            //loadCategorie
            $categorie = $check->check($pm->loadAll("FCategoria"));

            //loadRecensioni segnalate
            $recSegnalate = $check->check($pm->load("segnalato", true, "FRecensione"));

            //loadProprietari
            $proprietari = $check->check($pm->loadAll("FProprietario"));

            $view->HomeAdmin($utentiAttivi, $utentiBannati, $categorie, $recSegnalate, $proprietari);
        } else {
            header('Location: /Accesso/login');
        }
    }


    /**
     * Metodo utilizzato dal Admin per aggiungere categorie sul sito.
     * @throws SmartyException
     */
    public function aggiungiCategoria()
    {
        $sessione = new USession();
        if ($sessione->leggi_valore('utente')) {
            $utente = unserialize($sessione->leggi_valore('utente'));
            $view = new VAdmin();
            if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
                $pm = FPersistentManager::getInstance();
                $genere = $view->getGenere();
                $descrizione = $view->getDescrizione();
                $categoria = $pm->exist("FCategoria", genere, $genere);
                if (!$categoria) {
                    $Categoria = new ECategoria($genere, $descrizione);
                    $pm->store($Categoria);
                    $error = null;
                } else {
                    $error = "wrongCategory";
                }
                $view->showFormCategoria($utente, $error);
            } else {
                $view = new VError();
                $view->error(1);
            }
        } else {
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
        } else {
            $view = new VError();
            $view->error(1);
        }
    }


    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a false).
     **/
    public function bannaUtente($username)
    {
        $sessione = new USession();
        if ($sessione->isLogged() && ($sessione->leggi_valore('tipo_utente') == "EAdmin")) {
            $pm = FPersistentManager::getInstance();
            $pm->update("FUtente", "state", 0, "username", $username);
            header('Location: /Admin/dashboardAdmin');
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione utile per cancellare un utente già bannato.
     **/
    public function cancellaUtente($username)
    {
        $sessione = new USession();
        if ($sessione->isLogged() && ($sessione->leggi_valore('tipo_utente') == "EAdmin")) {
            $view = new VAdmin();
            $pm = FPersistentManager::getInstance();
            $utente = $pm->load("username", $username, "FUtente");
            if ($utente->getState() == 0) {
                $pm->delete("username", $username, "FUtente");
            }
            header('Location: /Admin/dashboardAdmin');

        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a true-->riattiva l'utente).
     */
    public function attivaUtente($username)
    {
        $sessione = new USession();
        if ($sessione->isLogged() && ($sessione->leggi_valore('tipo_utente') == "EAdmin")) {
            $pm = FPersistentManager::getInstance();
            $pm->update("FUtente", "state", 1, "username", $username);
            header('Location: /Admin/dashboardAdmin');
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione utile per eliminare una recensione segnalata.

     * @param $id
     * @throws SmartyException
     */
    public static function eliminaRecensione($id)
    {
        $sessione = new USession();
        if ($sessione->isLogged() && ($sessione->leggi_valore('tipo_utente') == "EAdmin")) {
            $pm = FPersistentManager::getInstance();
            $pm->delete("id", $id, "FRecensione");
            header('Location: /Admin/dashboardAdmin');
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione utilizzata per visualizzare l'elenco dei locali registrati sul sito.
     *
     * static function locali(){
     * $sessione = new USession();
     * if ($sessione->isLogged()) {
     * $utente = unserialize($sessione->leggi_valore('utente'));
     * if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
     * $view = new VAdmin();
     * $pm = FPersistentManager()::getIstance();
     * $localiAttivi = $pm->load("visibility", 1, "FLocale");
     * $Proprietari = null;
     * if (is_array($localiAttivi)) {
     * foreach ($localiAttivi as $item)
     * $Proprietari[] = $item->getProprietario();
     * }
     * elseif (isset($localiAttivi))
     * $Proprietari = $localiAttivi->getProprietario();
     * $img_attivi = static::set_immagini(Proprietari,"FProprietario");
     * $localiBannati = $pm->load("visibility", 0, "FLocale");
     * $ProprietariB = null;
     * if (is_array($localiBannati)) {
     * foreach ($localiBannati as $item)
     * $ProprietariB[] = $item->getProprietario();
     * }
     * elseif (isset($localiBannati))
     * $ProprietariB = $localiAttivi->getProprietario();
     * $img_bann = static::set_immagini($ProprietariB,"FProprietario");
     * $view->showLocalPage($localiAttivi, $localiBannati,$img_attivi,$img_bann); //Ipoteticamente aggiugni anche i proprietari
     * }
     * else {
     * $view = new VError();
     * $view->error('1');
     * }
     * }
     * } */

    /**
     * Funzione utile per cambiare lo stato di visibilità di un locale (nel caso specifico porta la visibilità a false).
     * @param $id annuncio da bannare
     * @throws SmartyException
     *
     * static function bannaLocale($id){
     * $sessione = new USession();
     * if($_SERVER['REQUEST_METHOD'] == "POST") {
     * $pm = FPersistentManager()::getIstance();
     * $pm->update("visibility", 0, "id", $id, "FLocali");
     * header('Location: /FacceBeve/Admin/annunci');
     * }
     * elseif($_SERVER['REQUEST_METHOD'] == "GET") {
     * if ($sessione->leggi_valore('utente')) {
     * $utente = unserialize($sessione->leggi_valore('utente'));
     * if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
     * header('Location: /FacceBeve/Admin/locali');
     * }
     * else {
     * $view = new VError();
     * $view->error('1');
     * }
     * }
     * else
     * header('Location: /FacceBeve/Utente/login');
     * }
     * } */

    /**
     * Funzione utile per cambiare lo stato di visibilità di un annuncio (nel caso specifico porta la visibilità a true).
     * 1) se il metodo di richiesta HTTP è GET e si è loggati come amministratore, avviene il reindirizzamento allapagina contenente l'elenco degli annunci;
     * 2) se il metodo di richiesta HTTP è POST (ovviamente per fare ciò bisogna già essere loggati come amminstratore), avviene l'azione vera e propria di riattivare l'annuncio selezionato
     *      cambiando il suo stato di visibilità a true;
     * 3) se il metodo di richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento verso la pagina di login;
     * 4) se il metodo di richiesta HTTP è GET e si è loggati come utente (non amministratore) compare una pagina di errore 401.
     * @param $id annuncio da bannare
     * @throws SmartyException
     *
     * static function ripristinaLocale($id){
     * $$sessione = new USession();
     * if($_SERVER['REQUEST_METHOD'] == "POST") {
     * $pm = FPersistentManager()::getIstance();
     * $pm->update("visibility", 1, "id", $id, "FLocale");
     * header('Location: /FillSpaceWEB/Admin/annunci');
     * }
     * elseif($_SERVER['REQUEST_METHOD'] == "GET") {
     * if ($sessione->leggi_valore('utente')) {
     * $utente = unserialize($sessione->leggi_valore('utente'));
     * if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
     * header('Location: /FacceBeve/Admin/locali');
     * }
     * else {
     * $view = new VError();
     * $view->error('1');
     * }
     * }
     * else
     * header('Location: /FacceBeve/Utente/login');
     * }
     * } */


    /**
     * Funzione utile per ricercare tutti i locali che contengano una determinata espressione nel loro campo descrizione
     * @throws SmartyException
     *
     * static function ricercaParolaLocale(){
     * $sessione = new USession();
     * if($_SERVER['REQUEST_METHOD'] == "POST") {
     * $view = new VAdmin();
     * $pm = FPersistentManager()::getIstance();
     * $parola = $view->getParola();
     * $result = $pm->loadByParola($parola, "FLocale");
     * $utentiAttivi = null;
     * $localiAttivi = null;
     * $localiBannati = null;
     * $utentiBannati = null; //Proprietari di locali bannati, cosa ci facciamo???????
     * if (is_object($result)){
     * if ($result->getVisibility()) {
     * $localiAttivi = $result;
     * $utentiAttivi = $localiAttivi->getProprietario();
     * }
     * else {
     * $localiBannati = $result;
     * $utentiBannati = $localiBannati->getProprietario();
     * }
     * }
     * elseif (is_array($result)){
     * $a = 0;
     * $b = 0;
     * for ($i = 0; $i<count($result); $i++){
     * if ($result[$i]->getVisibility()) {
     * $localiAttivi[$a] = $result[$i];
     * $utentiAttivi[$a] = $result[$i]->getProprietario();
     * $i++;
     * $a++;
     * }
     * else {
     * $localiBannati[$b] = $result[$i];
     * $utentiBannati[$b] = $result[$i]->getProprietario();
     * $i++;
     * $b++;
     * }
     * }
     * }
     * $img_attivi = static::set_immagini($utentiAttivi);
     * $img_bannati = static::set_immagini($utentiBannati);
     * $view->showAdsPage($localiAttivi, $localiBannati, $img_attivi, $img_bannati);
     * }
     * elseif($_SERVER['REQUEST_METHOD'] == "GET") {
     * if ($sessione->leggi_valore('utente')) {
     * $utente = unserialize($sessione->leggi_valore('utente'));
     * if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")){
     * header('Location: /FacceBeve/Admin/locali');
     * }
     * else {
     * //header('Location: /FillSpaceWEB/Utente/error');
     * $view = new VError();
     * $view->error('1');
     * }
     * }
     * else
     * header('Location: /FacceBeve/Utente/login');
     * }
     * }*/

    /**
     * Funzione utile per eseguire delle ricerche mirate su parole contenute nelle recensioni.
     * @throws SmartyException
     */
    static function ricercaParolaRecensione()
    {
        $sessione = new USession();
        if ($sessione->isLogged()) {
            $pm = FPersistentManager()::getIstance();
            $view = new VAdmin();
            $parola = $view->getParola();
            $recensione = $pm->loadByParola($parola, "FRecensione");
            $img = null;
            if (is_array($recensione)) {
                foreach ($recensione as $rec) {
                    // $ute = $pm->load("username", $rec->getUtente()->getUsername(), "FUtente");
                    $img[] = $pm->load("id", $rec->getUtente()->getImgProfilo(), "FImmagine");
                }
            } elseif ($recensione != null) {
                //$ute = $pm->load("email", $recensione->getEmailClient(), "FUtente");
                $img = $pm->load("id", $recensione->getUtente()->getImgProfilo(), "FImmagine");
            }
            $view->showRevPage($recensione, $img);
        }
    }

    /**
     * Funzione utile per eseguire ricerche sugli utenti.
     * @throws SmartyException
     */
    static function ricercaUtente()
    {
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
            $view->HomeAdmin($utentiAttivi, $utentiBan, $img_attivi, $img_bann);
        }
    }
}