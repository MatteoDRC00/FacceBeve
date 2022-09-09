<?php
require_once "utility/autoload.php";
require_once "utility/USession.php";

/**
 * Classe utilizzata per la gestione delle operazioni all'interno dell'area personale dell'utente:
 * -Modifica del profilo
 * -Visualizzazione del profilo
 * @package Controller
 */
class CProfilo{

    /**
     * @var CProfilo|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CProfilo $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CProfilo|null
     */
    public static function getInstance(): ?CProfilo{
        if(!isset(self::$instance)) {
            self::$instance = new CProfilo();
        }
        return self::$instance;
    }

    /**
     * Funzione che provvede alla rimozione delle variabili di sessione, alla sua distruzione e a rinviare alla homepage
     */
    static function logout(){
        $sessione = USession::getInstance();
        $sessione->chiudi_sessione();
        header('Location: /FacceBeve/Utente/login');
    }

    //Forse non serve
    public function error() {
        $view = new VError();
        $view->error('1');
    }


    /**
     * Funzione che gestisce la modifica della password del Utente/Proprietario. Preleva la vecchia e la nuova password dalla View, verifica la correttezza della vecchia e procede alla modifica.
     * @return false|void False se la vecchia password inserita non è corretta, altrimenti lancia un errore che rimanda alla View del errore.
     * @throws SmartyException
     */
    public function modificaPassword(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        $pm = FPersistentManager::getInstance();
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            $locali = static::caricaLocali($utente);
            $passwordVecchia = $view->getPasswordVecchia();
            $passwordNuova = $view->getPasswordNuova();
            if(md5($passwordVecchia)==$utente->getPassword()) {
                if($passwordNuova!=$passwordVecchia){
                    $utente->setPassword($passwordNuova);
                    $pm->update(get_class($utente),"password",$passwordNuova,"username",$utente->getUsername());
                    header('Location: /Profilo/profilo');
                }else{
                    $view->profilo($utente,$locali,"password_old");
                }
            }else{
                $view->profilo($utente,$locali,"password_error");
                //return false;
            }
        }else{
            $view = new VError();
            $view->error(1);   //Accesso proibito
        }
    }

    /**
     * Funzione che gestisce la modifica dello Username del Utente/Proprietario. Preleva lo username nuovo dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaUsername(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            $pm = FPersistentManager::getInstance();
            $usernameNuova = $view->getUsernameNuova();
            //Controllo sulla Username, essendo identificativa, che quella immessa non sia già stata scelta(da errore anche se inserisco la vecchia username)
            $bool = false;
            $check = $pm->loadAll(get_class($utente));
            foreach($check as $x){
                if($x->getUsername()==$usernameNuova){
                    $bool = true;
                }
            }
            if(!$bool){
                $utente->setUsername($usernameNuova);
                $pm->update(get_class($utente),"username",$usernameNuova,"username",$utente->getUsername());
                header('Location: /Profilo/profilo'); //profilo!!!
            }else{
                $locali = static::caricaLocali($utente);
                $view->profilo($utente,$locali,"username");
            }
        }else{
            $view = new VError();
            $view->error(1);   //Accesso proibito
        }

    }

    /**
     * Funzione che gestisce la modifica del email del Utente/Proprietario. Preleva la nuova email dalla View e procede alla modifica.
     * @return void
     */
    public function modificaEmail(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            $pm = FPersistentManager::getInstance();
            $emailNuova = $view->getEmailNuova();
            $utente->setEmail($emailNuova);
            $pm->update(get_class($utente),"email",$emailNuova,"username",$utente->getUsername());
            header('Location: /Profilo/profilo'); //profilo!!!
        }else{
            $view = new VError();
            $view->error(1);   //Accesso proibito
        }
    }


    /**
     * Gestisce la modifica dell'immagine del cliente. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaImmagineProfilo(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            $locali = static::caricaLocali($utente);
            $nome = $view->getNewImgProfilo();
            $check = static::upload($utente,$nome);
            if($check=="type"){
                $view->profilo($utente,$locali,"type");
            }elseif($check=="size"){
                $view->profilo($utente,$locali,"size");
            }elseif($check=="ok"){
                header('Location: /Profilo/profilo'); //profilo!!!
            }else{
                $view = new VError();
                $view->error(1);   //Accesso proibito
            }
        }
    }


    /**
     * Gestisce la visualizzazione dell'area personale degli utenti in base al tipo di utente. Se nessun utente è loggato reindirizza al login.
     * @return void
     * @throws SmartyException
     */
    public function profilo(){
        $sessione = USession::getInstance();
        if(!$sessione->leggi_valore('utente')){
            $sessione->imposta_valore("last_visited","/Profilo/profilo");
            $log = CAccesso::getInstance();
            $log->mostraLogin();
        }else{
            if ((get_class($sessione->leggi_valore('utente')) == 'EUtente') || (get_class($sessione->leggi_valore('utente')) == 'EProprietario') ) {
                $sessione->cancella_valore("last_visited");
                $utente = unserialize($sessione->leggi_valore('utente'));
                $view = new VProfilo();
                $locali = static::caricaLocali($utente);
                $view->profilo($utente,$locali,null);
            }
            if (get_class($sessione->leggi_valore('utente')) == 'EAdmin') {
                $sessione->cancella_valore("last_visited");
                $admin = CAdmin::getInstance();
                $admin->homepage();
            }
        }
    }


    ///////////////////////////////////////////////METODI STATICI///////////////////////////////////////////////////////////
    /**
     * Funzione di supporto che si occupa di verificare la correttezza dell'immagine inserita nella form di registrazione.
     * Nel caso in cui non ci sono errori di inserimento, avviene la store dell'utente e la corrispondente immagine nel database.
     * @param $utente obj utente
     * @param $nome_file passato nella form pe l'immagine
     * @return string stato verifica immagine
     */
    static function upload($utente,$nome_file) {
        $pm = FPersistentManager()::getIstance();
        $ris = null;
        $nome = '';
        $max_size = 300000;
        $result = is_uploaded_file($_FILES[$nome_file]['tmp_name']);
        if (!$result) {
            //no immagine
            //$pm->store($utente);
            //return "ok";
            $ris = "ok";
        } else {
            $size = $_FILES[$nome_file]['size'];
            $type = $_FILES[$nome_file]['type'];
            if ($size > $max_size) {
                //Il file è troppo grande
                $ris = "size";  // -->Errore relativo alla dimensione del img
            }
            //$type = $_FILES[$nome_file]['type'];
            elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                $nome = $_FILES[$nome_file]['name'];
                $immagine = @file_get_contents($_FILES["img"]['tmp_name']);
                $immagine = addslashes ($immagine);
                $mutente = new EImmagine($nome,$size,$type,$immagine);
                $pm->updateMedia($mutente,$nome_file);
                //return "ok";
                $ris = "ok";
            }
            else {
                //formato diverso
                //return "type";
                $ris = "type";
            }
        }
        return $ris;
    }

    /**
     * Metodo richiamato per individuare i locali collegati ad un utente, se questo èun Proprietario allora saranno i locali da l*i gestiti,
     * se invece è un Utente saranno i suoi locali preferiti
     * @return array|null
    */
    static function caricaLocali($utente): ?array
    {
        $pm = FPersistentManager::getInstance();
        if(get_class($utente) == "EProprietario"){
            $locali = $pm->load("proprietario",$utente->getUsername(),"FLocale");
            return $locali;
        }else{
            return null;
        }
    }


}