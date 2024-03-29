<?php

require_once "autoload.php";
require_once "utility/USession.php";

/**
 * La classe CProfilo viene utilizzata per la gestione delle aree personali, con le relative possibili modifiche e gestioni
 * @author Gruppo 8
 * @package Controller
 */
class CProfilo
{

    /**
     * @var CProfilo|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CProfilo $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe.
     * @return CProfilo|null
     */
    public static function getInstance(): ?CProfilo
    {
        if (!isset(self::$instance)) {
            self::$instance = new CProfilo();
        }
        return self::$instance;
    }

    /**
     * Funzione utilizzata per mostrare l'area personale di un Utente/Proprietario
     * @return void
     */
    public function mostraProfilo()
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged()) {
            $username = $sessione->leggi_valore("utente");
            $tipo = $sessione->leggi_valore("tipo_utente");
            if ($tipo == "EUtente") {
                $utente = $pm->load("username", $username, "FUtente");
                $locali_preferiti = $pm->getLocaliPreferiti($username);
                $view = new VProfilo();
                $view->mostraProfiloUtente($utente, $locali_preferiti);
            } elseif ($tipo == "EProprietario") {
                $proprietario = $pm->load("username", $username, "FProprietario");
                $locali = $pm->load("proprietario", $username, "FLocale");
                $view = new VProfilo();
                $view->mostraProfiloProprietario($proprietario, $locali);
            }
        }else{
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }

    }

    /**
     * Funzione che gestisce la modifica dello Username per utente/Proprietario. Preleva lo username nuovo dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaUsername()
    {
        $view = new VProfilo();
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged()) {
            $username = $sessione->leggi_valore('utente');
            $tipo = $sessione->leggi_valore('tipo_utente');
            $tipo[0] = "F";
            $class = $tipo;

            $user = $pm->load("username", $username, $class);

            $newusername = $view->getNewUsername();
            if ($username == $newusername) {
                $message = "L'username è identico a quello precedente";
                $tipo = "user";
                self::erroreModifica($tipo, $message, $user);
            } elseif ($newusername == null) {
                $message = "Si prega di inserire il nuovo username prima di cliccare sul tasto modifica";
                $tipo = "user";
                self::erroreModifica($tipo, $message, $user);
            } elseif ($pm->exist("FUtente", "username", $newusername) || $pm->exist("FProprietario", "username", $newusername)) {
                $message = "L'username inserito esiste già, inserirne un altro";
                $tipo = "user";
                self::erroreModifica($tipo, $message, $user);
            } else {
                $pm->update($class, "username", $newusername, "username", $username);
                $user->setUsername($newusername);
                $sessione->imposta_valore("utente", $newusername);
                $sessione->imposta_valore("tipo_utente", get_class($user));
                header("Location: /FacceBeve/Profilo/mostraProfilo");
            }
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }

    }

    /**
     * Funzione che gestisce la modifica del email del Utente/Proprietario. Preleva la nuova email dalla View e procede alla modifica.
     * @return void
     */
    public function modificaEmail()
    {
        $view = new VProfilo();
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged()) {
            $username = $sessione->leggi_valore('utente');
            $tipo = $sessione->leggi_valore('tipo_utente');
            $tipo[0] = "F";
            $class = $tipo;

            $newemail = $view->getNewEmail();
            $user = $pm->load("username", $username, $class);

            if ($newemail != null) {
                if ($newemail != $user->getEmail()) {
                    $user->setEmail($newemail);
                    $pm->update($class, "email", $newemail, "username", $username);
                    header('Location: /FacceBeve/Profilo/mostraProfilo');
                } else {
                    $message = "La email inserita è identica a quella precedente, si prega di scriverne un'altra";
                    $tipo = "email";
                    self::erroreModifica($tipo, $message, $user);
                }
            } else {
                $message = "Entrambi i campi devono essere pieni";
                $tipo = "email";
                self::erroreModifica($tipo, $message, $user);
            }
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

    /**
     * Funzione che gestisce la modifica della password del Utente/Proprietario. Preleva la vecchia e la nuova password dalla View, verifica la correttezza della vecchia e procede alla modifica.
     * @return false|void False se la vecchia password inserita non è corretta, altrimenti lancia un errore che rimanda alla View del errore.
     * @throws SmartyException
     */
    public function modificaPassword(){
        $view = new VProfilo();
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if($sessione->isLogged()){
            $username = $sessione->leggi_valore('utente');
            $tipo = $sessione->leggi_valore('tipo_utente');
            $tipo[0] = "F";
            $class = $tipo;

            $password = $view->getPassword();
            $newpassword = $view->getNewPassword();

            $user = $pm->load("username", $username, $class);

            if($password != null && $newpassword != null){
                if(md5($password) == $user->getPassword()){
                    if($newpassword != $password){
                        $user->setPassword($newpassword);
                        $pm->update($class,"password", md5($newpassword),"username",$username);
                        header('Location: /FacceBeve/Profilo/mostraProfilo');
                    }else{
                        $message = "La password inserita è identica a quella precedente, si prega di scriverne un'altra";
                        $tipo="password";
                        self::erroreModifica($tipo,$message,$user);
                    }
                }else{
                    $message = "La password precedente inserita è sbagliata, si prega di riprovare";
                    $tipo="password";
                    self::erroreModifica($tipo,$message,$user);
                }

            }else{
                $message = "Entrambi i campi devono essere pieni";
                $tipo="password";
                self::erroreModifica($tipo,$message,$user);
            }
        }else{
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

    /**
     * Gestisce la modifica dell'immagine del utente/proprietario. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaImmagineProfilo()
    {
        $view = new VProfilo();
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged()) {
            $username = $sessione->leggi_valore('utente');
            $tipo = $sessione->leggi_valore('tipo_utente');
            $tipo[0] = "F";
            $class = $tipo;

            $img = $view->getNewImgProfilo();
            if (!empty($img)) {
                $img_profilo = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_profilo);
                if($id){
                	$img_profilo->setId($id);
                    $user = $pm->load("username", $username, $class);
                    if($user->getImgProfilo() != null){
                      $id_imgvecchia = $user->getImgProfilo()->getId();
                      $pm->update($class, "idImg", $id, "username", $username);
                      $pm->delete("id", $id_imgvecchia, "FImmagine");
                    }else{
                      $pm->update($class, "idImg", $id, "username", $username);
                      $user->setImgProfilo($img_profilo);
                    }
                } 
            }
            header('Location: /FacceBeve/Profilo/mostraProfilo');
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

    //Gestione visualizzazione

    /**
     * Funzione utilizzata per mostrare il form di modifica delle informazioni di un utente
     * @throws SmartyException
     */
    public function formModificaUtente()
    {
        $view = new VProfilo();
        $sessione = new USession();
        $utente = unserialize(($sessione->leggi_valore('utente')));
        $localiUtente = static::caricaLocali($utente);
        $view->profilo($utente, $localiUtente, null);
    }

    /**
     * Funzione utilizzata per mostrare il form di modifica delle informazioni di un proprietario
     * @throws SmartyException
     */
    public function formModificaProprietario()
    {
        $view = new VProfilo();
        $sessione = new USession();
        if ($sessione->leggi_valore('utente')) {
            $proprietario = unserialize(($sessione->leggi_valore('utente')));
            $localiProprietario = static::caricaLocali($proprietario);
            $view->profilo($proprietario, $localiProprietario, null);
        }
    }

    /**
     * Gestisce la visualizzazione dell'area personale degli utenti in base al tipo di utente. Se nessun utente è loggato reindirizza al login.
     * @return void
     * @throws SmartyException
     */
    public function profilo()
    {
        $sessione = USession::getInstance();
        if (!$sessione->leggi_valore('utente')) {
            $log = CAccesso::getInstance();
            $log->mostraLogin();
        } else {
            if ((get_class($sessione->leggi_valore('utente')) == 'EUtente') || (get_class($sessione->leggi_valore('utente')) == 'EProprietario')) {
                $sessione->cancella_valore("last_visited");
                $utente = unserialize($sessione->leggi_valore('utente'));
                $view = new VProfilo();
                $locali = static::caricaLocali($utente);
                $view->profilo($utente, $locali, null);
            }
            if (get_class($sessione->leggi_valore('utente')) == 'EAdmin') {
                $sessione->cancella_valore("last_visited");
                $admin = CAdmin::getInstance();
                $admin->homepage();
            }
        }
    }

    /**
     * Funzione che richiama il metodo errore della class VProfilo per mostrare l'errore generato dall'utente
     * @param $tipo tipo di errore generato
     * @param $message messaggio da stampare
     * @param $user utente collegato
    */
    public function erroreModifica($tipo, $message, $user): void
    {
        $view = new VProfilo();

        $view->errore($tipo, $message, $user);
    }


    ///////////////////////////////////////////////METODI STATICI///////////////////////////////////////////////////////////

    /**
     * Metodo richiamato per individuare i locali collegati ad un utente, se questo è un Proprietario allora saranno i locali da l*i gestiti,
     * se invece è un Utente saranno i suoi locali preferiti
     * @return array|null
     */
    static function caricaLocali($utente): ?array
    {
        $pm = FPersistentManager::getInstance();
        if (get_class($utente) == "EProprietario") {
            return $pm->load("proprietario", $utente->getUsername(), "FLocale");
        } else {
            return null;
        }
    }

}