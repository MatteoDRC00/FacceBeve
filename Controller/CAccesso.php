<?php

require_once "autoload.php";
require_once "utility/USession.php";

/**
 * Classe utilizzata la registrazione e l'autenticazione dell'utente.
 * @package Controller
 */
class CAccesso
{
    /**
     * @var CAccesso|null Variabile di classe che mantiene l'istanza della classe.
     */
    public static ?CAccesso $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe.
     * @return CAccesso|null
     */
    public static function getInstance(): ?CAccesso
    {
        if (!isset(self::$instance)) {
            self::$instance = new CAccesso();
        }
        return self::$instance;
    }


    /**
     * Funzione che consente il login di un utente registrato. Si possono avere diversi casi:
     * 1) se il metodo della richiesta HTTP è GET:
     *   - se l'utente è già loggato viene reindirizzato alla homepage;
     *    - se l'utente non è loggato si viene indirizzati alla form di login;
     * 2) se il metodo della richiesta HTTP è POST viene richiamata la funzione verifica().
     * @throws SmartyException

    static function login(){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            $sessione = new USession();
            if($sessione->leggi_valore('utente')) {
                $pm = FPersistentManager::getIstance();
                $view = new VUtente();
                $result = $pm->loadEventi($sessione->leggi_valore('utente'));
                //Vengono mostrati, se presenti, solo gli eventi futuri, quelli passati visualizzabili nella pagina del locale
                $eventi = array();
                $oggi = date("d/m/Y");
                foreach($result as $evento){
                    if($evento->getData() > $oggi){
                        $eventi[] = $evento;
                    }
                }
                $classe = get_class($sessione->leggi_valore('utente'));
                $view->loginOk($eventi,$classe);
            }
            else{
                $view=new VUtente();
                $view->showFormLogin();
            }
        }elseif ($_SERVER['REQUEST_METHOD']=="POST")
            static::verifica();
    }
     */

    /**
     * Funzione che si occupa di verifica l'esistenza di un utente con username e password inseriti nel form di login.
     * 1) se, dopo la ricerca nel db non si hanno risultati ($utente = null)  SI VEDRA' ALLA FINE DEL PROGETTO oppure se l'utente si trova nel db ma ha lo stato false //FACOLTATIVO
     *    viene ricaricata la pagina con l'aggiunta dell'errore nel login.
     * 2) se l'utente esiste ed è attivo(in sessione), avviene il reindirizzamaneto alla homepage;
     * 3) se le credenziali inserite rispettano i vincoli per l'amministratore, avviene il reindirizamento alla homepage dell'amministratore;
     * 4) se si verifica la presenza di particolari cookie avviene il reindirizzamento alla pagina specifica //FACOLTATIVO.
     * @throws SmartyException

    static function verifica() {
        $view = new VUtente();
        $pm = new FPersistentManager();
        $UsernameLogin = $view->getUsername();
        $PasswordLogin = $view->getPassword();
        $utente = $pm->loadLogin($UsernameLogin, $PasswordLogin);
        if ($utente != null) {
            $sessione = USession::getInstance();
            if (!($sessione->leggi_valore('utente'))) {
                $salvare = serialize($utente);
                $sessione->imposta_valore('utente',$salvare);
                if (($UsernameLogin != 'admin') && ($UsernameLogin != 'Admin')) {
                    //Ipoteticamente utile, per tornare nell'ultima pagina visitata
                    //if (isset($_COOKIE['ultimo_visitato'])) {
                    header('Location: /FacceBeve/Utente/home');
                    //}
                }
                else {
                    header('Location: /FacceBeve/Admin/homepage');
                }
            }
        }
        else {
            $view->loginError();
        }
    } */

    /**
     * @throws SmartyException
     */
    public function formLogin(){
        $view = new VAccesso();
        $view->showFormLogin();
    }

    /**
     * @throws SmartyException
     */
    public function formRegistrazioneUtente(){
        $view = new VAccesso();
        $view->registra_utente();
    }

    /**
     * @throws SmartyException
     */
    public function formRegistrazioneProprietario(){
        $view = new VAccesso();
        $view->registra_proprietario();
    }


    /**
     * Funzione che gestisce il login dell'utente, prelevando le credenziali di accesso dalla view, verifica se un utente con queste credenziali esiste,
     * dopo aver messo in sessione le informazioni riguardo l'utente, reindirizza alla homepage.
     * @throws SmartyException
     */
    public function login() {
        $view = new VAccesso();
        $pm = FPersistentManager::getInstance();

        $usernameLogin = $view->getUsername();
        $passwordLogin = $view->getPassword();

        $user = $pm->verificaLogin($usernameLogin, $passwordLogin);

        if ($user != null) {
            $sessione = new USession();
            $salvare = serialize($user);
            $sessione->imposta_valore('utente',$salvare);

            $tipo = get_class($user);

            $pm = FPersistentManager::getInstance();

            $genere_cat = $pm->getCategorie();
            $topLocali = $pm->top4Locali();
            $locali = array();
            foreach($topLocali as $locale){
                $locale = $pm::load("id", $locale["id"], "FLocale");
                $locali[] = $locale;
            }

            $view2 = new VRicerca();
            $view2->mostraHome($tipo, $genere_cat, $locali);
            /*
            if (get_class($user)=="EUtente") {

            }
            elseif(get_class($user)=="EProprietario")  {
                $view->loginOk(null,"EUtente");
            }elseif(($UsernameLogin=="admin") && ($PasswordLogin=="admin"))  {
                header('Location: /FacceBeve/Admin/homepage');
            }*/
        }
    }


    /**
     * Funzione che si occupa di mostrare la form di registrazione per l'utente.
     * 1) se il metodo della richiesta HTTP è GET e si è loggati, avviene il reindirizzamento alla homepage;
     * 2) se il metodo della richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento vero e proprio alla form di registrazione;
     * 3) se il metodo della richiesta HTTP è POST viene invocato il metodo registra_cliente() che si occupa della gestione dei dati inseriti nella form.
     * @throws SmartyException

    static function registrazioneUtente(){
        if($_SERVER['REQUEST_METHOD']=="GET") {
            $view = new VUtente();
            $pm = new FPersistentManager();
            $sessione = USession::class;
            if ($sessione->leggi_valore('utente')) {
                $pm->loadEventi($_SESSION['utente']);
            }
            else {
                $view->registra_utente();
            }
        }else if($_SERVER['REQUEST_METHOD']=="POST") {
            static::regist_utente_verifica();
        }
    }*/


    /**
     * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il cliente .
     * In questo metodo avviene la verifica sull'univocità dell'email inserita;
     * se questa verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del cliente.
     * @throws SmartyException

    static function regist_utente_verifica () {
        $pm = new FPersistentManager();
        $view = new VUtente();
        $usercheck = $view->getUsername();
        $vereusername1 = $pm->exist("username", $usercheck,"FProprietario");
        $vereusername2 = $pm->exist("username", $usercheck,"FUtente");
        $view = new VUtente();
        if (($vereusername1) || ($vereusername2) && ($usercheck!="admin") && ($usercheck!="Admin")){
            $view->registrazioneUtenteError ("username"); //username già esistente
        }
        else {
            $utente = new EUtente($view->getPassword(),$view->getNome(),$view->getCognome(),$usercheck,$view->getEmail());
            if ($view->getImgProfilo() !== null) {
                $nome_file = 'img_profilo';
                $img = static::upload($utente,"registrazioneUtente",$nome_file);
                switch ($img) {
                    case "size":
                        $view->registrazioneUteenteError("size"); //Img troppo grande\piccola
                        break;
                    case "type":
                        $view->registrazioneUtenteError("typeimg"); //Formato non supportato
                        break;
                    case "ok":
                        header('Location: /FacceBeve/Utente/login');
                        break;
                }
            }

            list ($stato, $nome, $type) = CGestioneLocale::upload('img'); //DA CHIARIRE
            if ($stato == "type")
                $view->registrazioneUtenteError("typeimg");
            elseif ($stato == "size")
                $view->registrazioneUtenteError("size");
            elseif ($stato == "no_img") {
                $utente->Iscrizione();
                $pm->store($utente);
                header('Location: /FacceBeve/Utente/login');
            }
            elseif ($stato == "ok_img") {
                $size = $_FILES['img']['size']; //I GUESS, ALTRIMENTI SI CHIAMERA' 'file'
                $utente->Iscrizione();
                $pm->store($utente);
                $media = new EImmagine($nome, $size,$type);
                $media->setType($type);
                $pm->storeMedia($media,'file');
                header('Location: /FacceBeve/Utente/login');
            }
        }
    } */


    /**
     * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il cliente .
     * In questo metodo avviene la verifica sull'univocità dell'email inserita;
     * se questa verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del cliente.
     * @throws SmartyException
     */
    static function registrazioneUtente() {
        $pm = FPersistentManager::getInstance();
        $view = new VAccesso();

        $usercheck = $view->getUsername();
        $vereusername1 = $pm->exist("FProprietario", "username", $usercheck);
        $vereusername2 = $pm->exist("FUtente", "username", $usercheck);

        if (($vereusername1) || ($vereusername2) && ($usercheck!="admin")){
            $view->registrazioneUtenteError ("username"); //username già esistente
        }
        else {
            //FARE CONTROLLO VIA CLIENT
            $utente = new EUtente($view->getPassword(),$view->getNome(),$view->getCognome(),$usercheck,$view->getEmail());
            $utente->Iscrizione();
            $img = $view->getImgProfilo();
            if (!empty($img)) {
                $img_profilo = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm::store($img_profilo);

                /*
                $nome_file = 'img_profilo';
                list($img,$foto) = static::upload($nome_file);
                switch ($img) {
                    case "size":
                        $view->registrazioneUtenteError("size"); //Img troppo grande\piccola
                        break;
                    case "type":
                        $view->registrazioneUtenteError("typeimg"); //Formato non supportato
                        break;
                    case "ok":
                        if($foto){
                            $idImg = $pm->storeMedia($foto,$nome_file);
                            $foto->setId($idImg);
                            $utente->setImgProfilo($foto);
                        }
                        break;
                }*/
            }else{
                $utente->setImgProfilo(null);
                header('Location: /FacceBeve/Utente/');
            }
            $pm->store($utente);

        }
    }


    /**
     * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il cliente .
     * In questo metodo avviene la verifica sull'univocità dell'email inserita;
     * se questa verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del cliente.
     * @throws SmartyException
     */
    static function registrazioneProprietario() {
        $pm = FPersistentManager()::getIstance();;
        $view = new VAccesso();
        //Controllo dell'unicità dello Username scelto
        $usercheck = $view->getUsername();
        $vereusername1 = $pm->exist("username", $usercheck,"FProprietario");
        $vereusername2 = $pm->exist("username", $usercheck,"FUtente");
        if (($vereusername1) || ($vereusername2) && ($usercheck!="admin")){
            $view->registrazionePropError ("username"); //username già esistente
        }
        else {
            //FARE CONTROLLO VIA CLIENT
            $proprietario = new EProprietario($view->getNome(),$view->getCognome(),$view->getEmail(),$usercheck,$view->getPassword());
            //$utente->Iscrizione();
            if ($view->getImgProfilo() !== null) {
                $nome_file = 'img_profilo';
                list($img,$foto) = static::upload($proprietario,$nome_file);
                switch ($img) {
                    case "size":
                        $view->registrazionePropError("size"); //Img troppo grande\piccola
                        break;
                    case "type":
                        $view->registrazionePropError("typeimg"); //Formato non supportato
                        break;
                    case "ok":
                        if($foto){
                            $idImg = $pm->storeMedia($foto,$nome_file);
                            $foto->setId($idImg);
                            $proprietario->setImgProfilo($foto);
                        }
                        $pm->store($proprietario);
                        header('Location: /FacceBeve/Utente/');
                        break;
                }
            }
        }
    }



    public function error() {
        $view = new VError();
        $view->error('1');
    }


    /////////////////////////////////////METODI STATICI///////////////////////////////
    /**
     * Metodo statico invocato quando l'Utente effettua il login.
     * @return array|null
    */
    static function eventiUtente($utente): ?array
    {
        $pm = FPersistentManager::getIstance();
        $result = $pm->loadEventi($utente);
        if(isset($result)){
            //Vengono mostrati, se presenti, solo gli eventi futuri, quelli passati sono visualizzabili nella pagina del locale
            $eventi = array();
            $oggi = date("d/m/Y");
            foreach($result as $evento){
                if($evento->getData() > $oggi){
                    $eventi[] = $evento;
                }
            }
            return $eventi;
        }else{
            return null;
        }
    }


    /**
     * Funzione di supporto che si occupa di verificare la correttezza dell'immagine inserita nella form di registrazione.
     * Nel caso in cui non ci sono errori di inserimento, avviene la store dell'utente e la corrispondente immagine nel database.
     * @param $nome_file passato nella form pe l'immagine
     * @return array stato verifica immagine
     */
    static function upload($img) {
        $pm = FPersistentManager::getInstance();
        $ris = null;
        $nome = '';
        $max_size = 300000;
        $result = is_uploaded_file($img[2]);
        if (!$result) {
            //no immagine
            //$pm->store($utente);

            //return "ok";
            return $ris;
        } else {
            $size = $img[3];
            $type = $img[0];
            if ($size > $max_size) {
                //Il file è troppo grande
                $ris = "size";  // -->Errore relativo alla dimensione del img
            }
            //$type = $_FILES[$nome_file]['type'];
            elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                $immagine = @file_get_contents($img[2]);
                $immagine = addslashes ($immagine);
                //$pm->store($utente);
                $mutente = new EImmagine($nome,$size,$type,$immagine);
                //$pm->storeMedia($mutente,$nome_file);
                //return "ok";
                $ris = "ok";
            }
            else {
                //formato diverso
                //return "type";
                $ris = "type";
            }
        }
        return array($ris,$mutente);
    }


    public function logout(){
        $sessione = new USession();
        $sessione->chiudi_sessione();
        header("Location: /");
    }


}