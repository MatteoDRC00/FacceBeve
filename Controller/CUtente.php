<?php

class CUtente
{
    /**
     * Metodo che verifica se l'utente è loggato
     */
    static function isLogged() {
        $identificato = false;
        if (isset($_COOKIE['PHPSESSID'])) {
            if (session_status() == PHP_SESSION_NONE) {
                //header('Cache-Control: no cache'); //no cache
                //session_cache_limiter('private_no_expire'); // works
                //session_cache_limiter('public'); // works too
                session_start();
            }
        }
        if (isset($_SESSION['utente'])) {
            $identificato = true;
        }
        return $identificato;
    }

    /**
     * Funzione che consente il login di un utente registrato. Si possono avere diversi casi:
     * 1) se il metodo della richiesta HTTP è GET:
     *   - se l'utente è già loggato viene reindirizzato alla homepage;
     * 	 - se l'utente non è loggato si viene indirizzati alla form di login;
     * 2) se il metodo della richiesta HTTP è POST viene richiamata la funzione verifica().
     */
    static function login(){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            if(static::isLogged()) {
                $pm = new FPersistentManager();
                $view = new VUtente();
                $result = $pm->loadEventi($_SESSION['utente']);
                $view->loginOk($result);
            }
            else{
                $view=new VUtente();
                $view->showFormLogin();
            }
        }elseif ($_SERVER['REQUEST_METHOD']=="POST")
            static::verifica();
    }

    /**
     * Funzione che si occupa di verifica l'esistenza di un utente con username e password inseriti nel form di login.
     * 1) se, dopo la ricerca nel db non si hanno risultati ($utente = null) oppure se l'utente si trova nel db ma ha lo stato false
     *    viene ricaricata la pagina con l'aggunta dell'errore nel login.
     * 2) se l'utente ed è attivo, avviene il reindirizzamaneto alla homepage;
     * 3) se le credenziali inserite rispettano i vincoli per l'amministratore, avviene il reindirizamento alla homepage dell'amministratore;
     * 4) se si verifica la presenza di particolari cookie avviene il reindirizzamento alla pagina specifica.
     */
    static function verifica() {
        $view = new VUtente();
        $pm = new FPersistentManager();
        $utente = $pm->loadLogin($_POST['username'], $_POST['password']);
        if ($utente != null && $utente->getState() != false) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
                $salvare = serialize($utente);
                $_SESSION['utente'] = $salvare;
                if ($_POST['username'] != 'admin') {
                    if (isset($_COOKIE['chat']) && $_COOKIE['chat'] != $_POST['email']){
                        header('Location: /FillSpaceWEB/Messaggi/chat');
                    }
                    elseif (isset($_COOKIE['nome_visitato'])) {
                        header('Location: /FacceBeve/Utente/dettaglioutente');
                    }
                    else {
                        if (isset($_COOKIE['chat']))
                            setcookie("chat", null, time() - 900,"/");
                        else
                            header('Location: /FacceBeve/');
                    }
                }
                else {
                    header('Location: /FacceBeve/Admin/homepage');
                }
            }
        }
        else {
            $view->loginError();
        }
    }




}