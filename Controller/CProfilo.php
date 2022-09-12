<?php
require_once "autoload.php";
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
        $sessione = new USession();
        $sessione->chiudi_sessione();
        header('Location: Ricerca/mostraHome');
    }

/*
    public function error() {
        $view = new VError();
        $view->error('1');
    } */


    /**
     * Funzione che gestisce la modifica della password del Utente/Proprietario. Preleva la vecchia e la nuova password dalla View, verifica la correttezza della vecchia e procede alla modifica.
     * @return false|void False se la vecchia password inserita non è corretta, altrimenti lancia un errore che rimanda alla View del errore.
     * @throws SmartyException
     */
    public function modificaPassword(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        $pm = FPersistentManager::getInstance();
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
        }
    }

    /**
     * Funzione che gestisce la modifica dello Username del Utente/Proprietario. Preleva lo username nuovo dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaUsername(){
        $view = new VProfilo();
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if($sessione->isLogged()){
            $username = $sessione->leggi_valore('utente');
            $tipo = $sessione->leggi_valore('tipo_utente');
            $tipo[0] = "F";
            $class = $tipo;


            $newusername = $view->getNewUsername();
            if($username == $newusername){
                $message = "L'username è identico a quello precedente";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }elseif($newusername == null) {
                $message = "Si prega di inserire il nuovo username prima di cliccare sul tasto modifica";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }elseif($pm->exist("FUtente", "username", $newusername) || $pm->exist("FProprietario", "username", $newusername)){
                $message = "L'username inserito esiste già, inserirne un altro";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }else{
                $pm->update($class, "username", $newusername, "username", $username);
            }
            header("Location: /Profilo/mostraProfilo");
        }else{
            header("Location: /Ricerca/mostraHome");
        }

    }

    /**
     * Funzione che gestisce la modifica del email del Utente/Proprietario. Preleva la nuova email dalla View e procede alla modifica.
     * @return void
     */
    public function modificaEmail(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        $utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $emailNuova = $view->getEmailNuova();
        $utente->setEmail($emailNuova);
        $pm->update(get_class($utente),"email",$emailNuova,"username",$utente->getUsername());
        header('Location: /Profilo/profilo'); //profilo!!!
    }


    /**
     * Gestisce la modifica dell'immagine del utente/proprietario. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaImmagineProfilo(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        $utente = unserialize($sessione->leggi_valore('utente'));
        $locali = static::caricaLocali($utente);
        $img = $view->getNewImgProfilo();
        list($check,$media) = static::upload($img);
        if($check=="type"){
            $view->profilo($utente,$locali,"type");
        }elseif($check=="size"){
            $view->profilo($utente,$locali,"size");
        }elseif($check=="ok"){
            $pm = FPersistentManager::getInstance();
            $pm->updateMedia($media,$img[1]);
            header('Location: /Profilo/profilo'); //profilo!!!
        }
    }

    //Gestione visualizzazione

    /**
     * @throws SmartyException
     */
    public function formModificaUtente(){
        $view = new VProfilo();
        $sessione = new USession();
        $utente = unserialize(($sessione->leggi_valore('utente')));
        $localiUtente = static::caricaLocali($utente);
        $view->profilo($utente,$localiUtente,null);
    }

    /**
     * @throws SmartyException
     */
    public function formModificaProprietario(){
        $view = new VProfilo();
        $sessione = new USession();
        if($sessione->leggi_valore('utente')){
            $proprietario = unserialize(($sessione->leggi_valore('utente')));
            $localiProprietario = static::caricaLocali($proprietario);
            $view->profilo($proprietario,$localiProprietario,null);
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
     * @param $img array  nella form pe l'immagine
     * @return string stato verifica immagine
     */
    static function upload($img) {
        $pm = FPersistentManager()::getIstance();
        $ris = null;
        $nome = '';
        $max_size = 300000;
        $result = is_uploaded_file($img[2]);
        if (!$result) {
            //No img
            $ris = "ok";
        } else {
            $size = $img[3];
            $type = $img[0];
            if ($size > $max_size) {
                //Il file è troppo grande
                $ris = "size";  // -->Errore relativo alla dimensione del img
            }
            elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                $nome = $img[1];
                $immagine = @file_get_contents($img[2]);
                $immagine = addslashes ($immagine);
                $mutente = new EImmagine($nome,$size,$type,$immagine);
                //$pm->updateMedia($mutente,$nome);
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

    /**
     * Metodo richiamato per individuare i locali collegati ad un utente, se questo è un Proprietario allora saranno i locali da l*i gestiti,
     * se invece è un Utente saranno i suoi locali preferiti
     * @return array|null
    */
    static function caricaLocali($utente): ?array
    {
        $pm = FPersistentManager::getInstance();
        if(get_class($utente) == "EProprietario"){
            return $pm->load("proprietario",$utente->getUsername(),"FLocale");
        }else{
            return null;
        }
    }

    public function mostraProfiloUtente(){
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if($sessione->isLogged()){
            $username = $sessione->leggi_valore("utente");
            $tipo = $sessione->leggi_valore("tipo_utente");
            $tipo[0] = "F";
            $class = $tipo;
            $utente = $pm->load("username", $username, $class);

            $locali_preferiti = $pm->getLocaliPreferiti($username);

            $view = new VProfilo();
            $view->mostraProfiloUtente($utente, $locali_preferiti);
        }else{
            $sessione->chiudi_sessione();
            header("Location: /Ricerca/mostraHome");
        }

    }

    public function mostraProfiloProprietario(){
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if($sessione->isLogged()){
            $username = $sessione->leggi_valore("utente");
            $tipo = $sessione->leggi_valore("tipo_utente");
            $tipo[0] = "F";
            $class = $tipo;
            $proprietario = $pm->load("username", $username, $class);

            $locali = $pm->load("proprietario", $username, $class);

            $view = new VProfilo();
            $view->mostraProfiloProprietario($proprietario, $locali);
        }else{
            $sessione->chiudi_sessione();
            header("Location: /Ricerca/mostraHome");
        }

    }

    /**
     * Funzione che si occupa del supporto per le immagini, in modo da fornire una foto profilo anche agli utenti che non ne hanno caricata una.
     * @param $image immagine da analizzare
     * @param $tipo variabile che indirizza al tipo di file di default da settare nel caso in cui $image = null
     * @return array contenente informazioni sul tipo e i dati che costituiscono un immagine (possono essere anche degli array)
     */
    public function setImage(EImmagine $image, $tipo): array
    {
        if (isset($image)) {
            $pic64 = base64_encode($image->getImmagine());
            $type = $image->getType();
        }
        elseif ($tipo == 'EUtente') {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/utente.png'); //Immagine generica per l'utente
            $pic64= base64_encode($data);
            $type = "image/png";
        }elseif ($tipo == 'EProprietario'){
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/proprietario.png'); //Immagine generica per il proprietario
            $pic64= base64_encode($data);
            $type = "image/png";
        }
        /**elseif($tipo == 'ELocale') {
        $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/locale.png'); //Immagine generica per il proprietario
        $pic64= base64_encode($data);
        $type = "image/png";
        }*/
        return array($type, $pic64);
    }

}