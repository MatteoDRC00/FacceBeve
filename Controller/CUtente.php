<?php

class CUtente
{
    //DA RIVEDEREEEEEEEEEEEEEEEEEE
    /**
     * Metodo che verifica se l'utente è loggato
     * @return boolean $identificato indica se l'utente era già loggato o meno
     */
    static function isLogged() {
        $identificato = false;
        $sessione = USession::getInstance();

        /* if (isset($_COOKIE['PHPSESSID'])) {
          //   Il PHPSESSID Viene utilizzato per stabilire una sessione utente e trasmettere dati di stato tramite un cookie temporaneo,
          //   comunemente denominato cookie di sessione. (scade alla chiusura del browser)


             if (session_status() == PHP_SESSION_NONE) {
                 //header('Cache-Control: no cache'); //no cache
                 //session_cache_limiter('private_no_expire'); // works
                 //session_cache_limiter('public'); // works too
             }
        }*/

        if (!($sessione->leggi_valore('utente'))) {
            $identificato = true;
        }
        return $identificato;
    }

    /**
     * Funzione che consente il login di un utente registrato. Si possono avere diversi casi:
     * 1) se il metodo della richiesta HTTP è GET:
     *   - se l'utente è già loggato viene reindirizzato alla homepage;
     *     - se l'utente non è loggato si viene indirizzati alla form di login;
     * 2) se il metodo della richiesta HTTP è POST viene richiamata la funzione verifica().
     * @throws SmartyException
     */
    static function login(){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            if(static::isLogged()) {
                $pm = FPersistentManager::getIstance();
                $sessione = USession::getInstance();
                $view = new VUtente();
                $result = $pm->loadEventi($sessione->leggi_valore('utente'));
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
     * 1) se, dopo la ricerca nel db non si hanno risultati ($utente = null)  SI VEDRA' ALLA FINE DEL PROGETTOoppure se l'utente si trova nel db ma ha lo stato false //FACOLTATIVO
     *    viene ricaricata la pagina con l'aggiunta dell'errore nel login.
     * 2) se l'utente esiste ed è attivo(in sessione), avviene il reindirizzamaneto alla homepage;
     * 3) se le credenziali inserite rispettano i vincoli per l'amministratore, avviene il reindirizamento alla homepage dell'amministratore;
     * 4) se si verifica la presenza di particolari cookie avviene il reindirizzamento alla pagina specifica //FACOLTATIVO.
     * @throws SmartyException
     */
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
                if ($_POST['username'] != 'admin') {
                    //Ipoteticamente utile, per tornare nell'ultima pagina visitata
                    if (isset($_COOKIE['nome_visitato'])) {
                        header('Location: /FacceBeve/Utente/daVedere');
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

    /**
     * Funzione che provvede alla rimozione delle variabili di sessione, alla sua distruzione e a rinviare alla homepage
     */
    static function logout(){
        $sessione = USession::getInstance();
        $sessione->chiudi_sessione();
        header('Location: /FacceBeve/Utente/login');
    }

    public function error() {
        $view = new VError();
        $view->error('1');
    }

    /**
     * Funzione che si occupa di mostrare la form di registrazione per il trasportatore.
     * 1) se il metodo della richiesta HTTP è GET e si è loggati, avviene il reindirizzamento alla homepage;
     * 2) se il metodo della richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento vero e proprio alla form di registrazione;
     * 3) se il metodo della richiesta HTTP è POST viene invocato il metodo registra_proprietario() che si occupa della gestione dei dati inseriti nella form.
     * @throws SmartyException
     */
    static function registrazioneProprietario() {
        if($_SERVER['REQUEST_METHOD']=="GET") {
            if (static::isLogged()) {
                header('Location: /FacceBeve/');
            }
            else {
                $view = new VUtente();
                $view->registra_proprietario();
            }
        }else if($_SERVER['REQUEST_METHOD']=="POST") {
            static::regist_proprietario_verifica();
        }
    }

    /**
     * Funzione che si occupa di mostrare la form di registrazione per l'utente.
     * 1) se il metodo della richiesta HTTP è GET e si è loggati, avviene il reindirizzamento alla homepage;
     * 2) se il metodo della richiesta HTTP è GET e non si è loggati, avviene il reindirizzamento vero e proprio alla form di registrazione;
     * 3) se il metodo della richiesta HTTP è POST viene invocato il metodo registra_cliente() che si occupa della gestione dei dati inseriti nella form.
     * @throws SmartyException
     */
    static function registrazioneUtente(){
        if($_SERVER['REQUEST_METHOD']=="GET") {
            $view = new VUtente();
            $pm = new FPersistentManager();
            if (static::isLogged()) {
                $pm->loadEventi($_SESSION['utente']);
            }
            else {
                $view->registra_utente();
            }
        }else if($_SERVER['REQUEST_METHOD']=="POST") {
            static::regist_utente_verifica();
        }
    }


    /**
     * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il cliente .
     * In questo metodo avviene la verifica sull'univocità dell'email inserita;
     * se questa verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del cliente.
     */
    static function regist_utente_verifica () {
        $pm = new FPersistentManager();
        $view = new VUtente();
        $usercheck = $view->getUsername();
        $verusername = $pm->exist("username", $usercheck,"FUtente");

        if ($verusername){
            $view->registrazioneUtenteError ("username"); //username già esistente
        }
        else {
            $utente = new EUtente($view->getPassword(),$view->getNome(),$view->getCognome(),$usercheck,$view->getEmail());
            //$cliente = new ECliente($_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password'], true);
            if ($utente != null) {
                if (isset($_FILES['Img'])) {
                    $nome_file = 'file';
                    $img = static::upload($cliente,"registrazioneCliente",$nome_file);
                    switch ($img) {
                        case "size":
                            $view->registrazioneCliError("size");
                            break;
                        case "type":
                            $view->registrazioneCliError("typeimg");
                            break;
                        case "ok":
                            header('Location: /FillSpaceWEB/Utente/login');
                            break;
                    }
                }
            }
            /*
            list ($stato, $nome, $type) = CGestioneAnnuncio::upload('file');
            if ($stato == "type")
                $view->registrazioneCliError("typeimg");
            elseif ($stato == "size")
                $view->registrazioneCliError("size");
            elseif ($stato == "no_img") {
                $pm->store($cliente);
                header('Location: /FillSpaceWEB/Utente/login');
            }
            elseif ($stato == "ok_img") {
                $pm->store($cliente);
                $m_utente = new EMediaUtente($nome, $cliente->getEmail());
                $m_utente->setType($type);
                $pm->storeMedia($m_utente,'file');
                header('Location: /FillSpaceWEB/Utente/login');
            }
            */
        }
    }


}