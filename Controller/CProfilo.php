<?php
require_once "autoloader.php";
require_once "utility/USession.php";

/**
 * Classe per la gestione delle operazioni all'interno dell'area personale dell'utente.
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
     */
    public function modificaPassword(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        $pm = FPersistentManager::getInstance();
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            $passwordVecchia = $view->getPasswordVecchia();
            $passwordNuova = $view->getPasswordNuova();
            if(md5($passwordVecchia)==$utente->getPassword()) {
                if($passwordNuova!=$passwordVecchia){
                    $utente->setPassword($passwordNuova);
                    $pm->update(get_class($utente),"password",$passwordNuova,"username",$utente->getUsername());
                    header('Location: /Profilo/profilo'); //profilo!!!
                }else{
                    $view->errorePassword($utente); //? farei come in FillSpace
                }
            }else{
                $view->erroreModifica("password");
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
                $view->erroreModifica("username");
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
     */
    public function modificaImmagineProfilo(){
        $view = new VProfilo();
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            $nome = $view->getNewImgProfilo();
            $check = static::upload($utente,$nome);


            header('Location: /Areapersonale/mostraAreaPersonale');
        }
    }


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
            $pm->store($utente);
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
                $pm->updateMedia($mutente);
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


}