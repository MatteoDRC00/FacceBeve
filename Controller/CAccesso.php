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
    public function login()
    {
        $view = new VAccesso();
        $pm = FPersistentManager::getInstance();

        $usernameLogin = $view->getUsername();
        $passwordLogin = md5($view->getPassword());
        if ($usernameLogin == null || $passwordLogin == null) {
            $tipo="vuoti";
            self::erroreLogin($tipo);
        } else {
            $user = $pm->verificaLogin($usernameLogin, $passwordLogin);
            echo $user." ok ";
            if ($user != null) {
                $sessione = new USession();
                $sessione->imposta_valore('utente', $user->getUsername());
                $sessione->imposta_valore("tipo_utente", get_class($user));
                header("Location: /Ricerca/mostraHome");
            }else{
                $tipo="credenziali";
                self::erroreLogin($tipo);
            }
        }
    }

    /**
     * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il cliente .
     * In questo metodo avviene la verifica sull'univocità dell'email inserita;
     * se questa verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del cliente.
     * @throws SmartyException
     */
    static function registrazioneUtente() {
        $pm = FPersistentManager::getInstance();
        $view = new VAccesso();
        $sessione = new USession();

        $username = $view->getUsername();
        $userP = $pm->exist("FProprietario", "username", $username);
        $userU = $pm->exist("FUtente", "username", $username);

        if (($userP) || ($userU) && ($username!="admin")){
            $view->registrazioneUtenteError ("username"); //username già esistente
        }
        else {
            //FARE CONTROLLO VIA CLIENT
            $utente = new EUtente($view->getPassword(),$view->getNome(),$view->getCognome(),$username,$view->getEmail());
            $utente->Iscrizione();

            $img_profilo = null;

            $img = $view->getImgProfilo();
            //list($check, $img_profilo) = static::upload($img);
            if (!empty($img)) {
                $img_profilo = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_profilo);
                $img_profilo->setId($id);
            }
            $utente->setImgProfilo($img_profilo);

            $pm->store($utente);

            $sessione->imposta_valore('utente',$utente->getUsername());
            $sessione->imposta_valore("tipo_utente", get_class($utente));

            header("Location: /Ricerca/mostraHome");
        }
    }


    /**
     * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il cliente .
     * In questo metodo avviene la verifica sull'univocità dell'email inserita;
     * se questa verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del cliente.
     * @throws SmartyException
     */
    static function registrazioneProprietario() {
        $pm = FPersistentManager::getInstance();
        $view = new VAccesso();
        $sessione = new USession();

        $username = $view->getUsername();
        $userP = $pm->exist("FProprietario", "username", $username);
        $userU = $pm->exist("FUtente", "username", $username);

        if (($userP) || ($userU) && ($username!="admin")){
            $view->registrazioneUtenteError ("username"); //username già esistente
        }
        else {
            //FARE CONTROLLO VIA CLIENT
            $proprietario = new EProprietario($view->getNome(),$view->getCognome(),$view->getEmail(),$username,$view->getPassword());

            $img_profilo = null;

            $img = $view->getImgProfilo();
            if (!empty($img)) {
                $img_profilo = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm::store($img_profilo);
                $img_profilo->setId($id);
            }
            $proprietario->setImgProfilo($img_profilo);
            $pm->store($proprietario);

            $sessione->imposta_valore('utente',$proprietario->getUsername());
            $sessione->imposta_valore("tipo_utente", get_class($proprietario));

            header("Location: /Ricerca/mostraHome");
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
        $pm = FPersistentManager::getInstance();
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
        $ris = null;
        $nome = $img[0];
        $max_size = 300000;
        $result = is_uploaded_file($img[3]);
        if (!$result) {
            //no immagine
            //$pm->store($utente);

            //return "ok";
            return $ris;
        } else {
            $size = $img[1];
            $type = $img[2];
            if ($size > $max_size) {
                //Il file è troppo grande
                $ris = "size";  // -->Errore relativo alla dimensione del img
            }
            //$type = $_FILES[$nome_file]['type'];
            elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                $immagine = @file_get_contents($img[3]);
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
        if(!isset($mutente))
            $mutente=null;
        return array($ris,$mutente);
    }


    /**
     * Funzione che provvede alla rimozione delle variabili di sessione, alla sua distruzione e a rinviare alla homepage
     */
    static function logout(){
        $sessione = new USession();
        $sessione->chiudi_sessione();
        header('Location: /Ricerca/mostraHome');
    }


    public function erroreLogin($tipo): void {
        $view = new VAccesso();
        $view->erroreLogin($tipo);
    }
}