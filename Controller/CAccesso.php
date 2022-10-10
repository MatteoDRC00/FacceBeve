<?php

require_once "autoload.php";
require_once "utility/USession.php";

/**
 * La classe CAccesso è utilizzata per la registrazione e l'autenticazione dell'utente/proprietario.
 * @author Gruppo 8
 * @package Controller
 */
class CAccesso
{
    /**
     * @var CAccesso|null Variabile di classe che mantiene l'istanza della classe.
     */
    public static ?CAccesso $instance = null;

    /**
     * Costruttore della classe
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe
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
     * Mostra il form del login
     * @throws SmartyException
     */
    public function formLogin()
    {
        $view = new VAccesso();
        $view->showFormLogin();
    }

    /**
     * Mostra il form della registrazione dell'utente
     * @throws SmartyException
     */
    public function formRegistrazioneUtente()
    {
        $view = new VAccesso();
        $view->registra_utente();
    }

    /**
     * Mostra il form della registrazione del proprietario
     * @throws SmartyException
     */
    public function formRegistrazioneProprietario()
    {
        $view = new VAccesso();
        $view->registra_proprietario();
    }


    /**
     * Funzione che gestisce il login di utente/proprietario/admin
     * @return void
     */
    public function login()
    {
        $view = new VAccesso();
        $pm = FPersistentManager::getInstance();

        $usernameLogin = $view->getUsername();
        $passwordLogin = md5($view->getPassword());
        if ($usernameLogin == null || $passwordLogin == null) {
            $tipo = "vuoti";
            self::erroreLogin($tipo);
        } else {
            $user = $pm->verificaLogin($usernameLogin, $passwordLogin);
            if ($user != null) {
                $sessione = new USession();
                $sessione->imposta_valore('utente', $user->getUsername());
                $sessione->imposta_valore("tipo_utente", get_class($user));
                if (get_class($user) == "EAdmin") {
                    header("Location: /Admin/dashboardAdmin");
                }
                header("Location: /Ricerca/mostraHome");
            } else {
                $tipo = "credenziali";
                self::erroreLogin($tipo);
            }
        }
    }

    /**
     * Funzione che si occupa di prelevare i dati dal form, creare un oggetto EUtente e salvarlo nel db
     * @return void
     */
    static function registrazioneUtente()
    {
        $pm = FPersistentManager::getInstance();
        $view = new VAccesso();
        $sessione = new USession();

        $username = $view->getUsername();
        $userP = $pm->exist("FProprietario", "username", $username);
        $userU = $pm->exist("FUtente", "username", $username);
        $admin = $pm->exist("FAdmin", "username", $username);

        if ($userP || $userU || $admin) {
            $message = "Username già esistente, si prega di scriverne un altro";
            echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.replace('/Accesso/formRegistrazioneUtente');
                      </script>";
        } else {
            $utente = new EUtente($view->getPassword(), $view->getNome(), $view->getCognome(), $username, $view->getEmail());
            $utente->Iscrizione();

            $img_profilo = null;

            $img = $view->getImgProfilo();

            if (!empty($img)) {
                $img_profilo = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_profilo);
                if(!($id)){
                    $img_profilo = null;
                }
                else
                    $img_profilo->setId($id);
            }
            $utente->setImgProfilo($img_profilo);

            $pm->store($utente);

            $sessione->imposta_valore('utente', $utente->getUsername());
            $sessione->imposta_valore("tipo_utente", get_class($utente));

            header("Location: /Ricerca/mostraHome");
        }
    }


    /**
     * Funzione che si occupa di prelevare i dati dal form, creare un oggetto EProprietario e salvarlo nel db
     * @return void
     */
    static function registrazioneProprietario()
    {
        $pm = FPersistentManager::getInstance();
        $view = new VAccesso();
        $sessione = new USession();

        $username = $view->getUsername();
        $userP = $pm->exist("FProprietario", "username", $username);
        $userU = $pm->exist("FUtente", "username", $username);
        $admin = $pm->exist("FAdmin", "username", $username);

        if ($userP || $userU || $admin) {
            $message = "Username già esistente, si prega di scriverne un altro";
            echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.replace('/Accesso/formRegistrazioneProprietario');
                      </script>";
        } else {
            $proprietario = new EProprietario($view->getNome(), $view->getCognome(), $view->getEmail(), $username, $view->getPassword());

            $img_profilo = null;

            $img = $view->getImgProfilo();

            if (!empty($img)) {
                $img_profilo = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_profilo);
                if(!($id)){
                    $img_profilo = null;
                }
                else
                    $img_profilo->setId($id);
            }
            $proprietario->setImgProfilo($img_profilo);
            $pm->store($proprietario);

            $sessione->imposta_valore('utente', $proprietario->getUsername());
            $sessione->imposta_valore("tipo_utente", get_class($proprietario));

           header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Funzione che provvede alla rimozione delle variabili di sessione, alla sua distruzione e a rinviare alla homepage
     * @return void
     */
    public function logout()
    {
        $sessione = new USession();
        $sessione->chiudi_sessione();
        header('Location: /Ricerca/mostraHome');
    }

    /**
     * Permette il reinserimento delle credenziali nel caso di errato login
     * @param $tipo
     * @return void
     */
    public function erroreLogin($tipo): void
    {
        $view = new VAccesso();
        $view->erroreLogin($tipo);
    }

}