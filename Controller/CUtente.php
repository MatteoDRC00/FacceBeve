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
     * @throws SmartyException
     */
    static function regist_utente_verifica () {
        $pm = new FPersistentManager();
        $view = new VUtente();
        $usercheck = $view->getUsername();
        $vereusername1 = $pm->exist("username", $usercheck,"FProprietario");
        $vereusername2 = $pm->exist("username", $usercheck,"FUtente");
        $view = new VUtente();
        if (($vereusername1) || ($vereusername2)){
            $view->registrazioneUtenteError ("username"); //username già esistente
        }
        else {
            $utente = new EUtente($view->getPassword(),$view->getNome(),$view->getCognome(),$usercheck,$view->getEmail());
            if (isset($_FILES['img_profilo'])) { //ipoteticamente
                $nome_file = 'img_profilo';
                $img = static::upload($utente,"registrazioneUtente",$nome_file);
                switch ($img) {
                    case "size":
                        $view->registrazioneUteenteError("size");
                        break;
                    case "type":
                        $view->registrazioneUtenteError("typeimg");
                        break;
                    case "ok":
                        header('Location: /FacceBeve/Utente/login');
                        break;
                }
            }
            //VA VISTO IL BLOB
            list ($stato, $nome, $type) = CGestioneLocale::upload('img');
            if ($stato == "type")
                $view->registrazioneUtenteError("typeimg");
            elseif ($stato == "size")
                $view->registrazioneUtenteError("size");
            elseif ($stato == "no_img") {
                $pm->store($utente);
                header('Location: /FacceBeve/Utente/login');
            }
            elseif ($stato == "ok_img") {
                $size = $_FILES['img']['size']; //I GUESS, ALTRIMENTI SI CHIAMERA' 'file'
                $pm->store($utente);
                $media = new EImmagine($nome, $size,$type);
                $media->setType($type);
                $pm->storeMedia($media,'file');
                header('Location: /FacceBeve/Utente/login');
            }
        }
    }


    /**
     * DA MODIFICAREEEEEE
     * Funzione di supporto che si occupa di verificare la correttezza dell'immagine inserita nella form di registrazione.
     * Nll caso in cui non ci sono errori di inserimento, avviene la store dell'utente e la corrispondente immagine nel database.
     * @param $utente obj utente
     * @param $funz tipo di funzione da svolgere
     * @param $nome_file passato nella form pe l'immagine
     * @return string stato verifa immagine
     */
    static function upload($utente,$funz,$nome_file) {
        $pm = new FPersistentManager();
        $ris = null;
        $nome = '';
        $max_size = 300000;
        $result = is_uploaded_file($_FILES[$nome_file]['tmp_name']);
        if (!$result) {
            //no immagine
            if ($funz == "registrazioneCliente") {
                $pm->store($utente);
                //return "ok";
                $ris = "ok";
            }
            if ($funz == "registrazioneTrasportatore") {
                $a = static:: reg_immagine_mezzo_tra($utente,$max_size,$nome,false,$nome_file);
                //return $a;
                $ris = $a;
            }
        } else {
            $size = $_FILES[$nome_file]['size'];
            $type = $_FILES[$nome_file]['type'];
            if ($size > $max_size) {
                //Il file è troppo grande
                //return "size";
                $ris = "size";
            }
            //$type = $_FILES[$nome_file]['type'];
            elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                $nome = $_FILES[$nome_file]['name'];
                if ($funz == "registrazioneCliente") {
                    $pm->store($utente);
                    $mutente = new EMediaUtente($nome, $utente->getEmail());
                    $mutente->setType($type);
                    $pm->storeMedia($mutente,$nome_file);
                    //return "ok";
                    $ris = "ok";
                }
                elseif ($funz == "modificaUtente") {
                    $pm->delete("emailutente",$utente->getEmail(),"FMediaUtente");
                    $mutente = new EMediaUtente($nome, $utente->getEmail());
                    $mutente->setType($type);
                    $pm->storeMedia($mutente,$nome_file);
                    //return "ok";
                    $ris = "ok";
                }
                elseif ($funz = "registrazioneTrasportatore") {
                    $a = static:: reg_immagine_mezzo_tra($utente,$max_size,$nome,true,$nome_file);
                    //return $a;
                    $ris = $a;
                }
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
     * Funzione di supporto che si occupa di verificare i dati inseriti nella form di registrazione per il trasportatore.
     * In questo metodo avviene la verifica sull'univocità dell'email e la targa inseriti;
     * se queste verifiche non riscontrano problemi, si passa verifica dell'immagine inserita e quindi alla store nel db vera e propria del trasportatore.
     */
    static function regist_proprietario_verifica() {
        $error_username = false;
        $error_mezzo = false;
        $pm = new FPersistentManager();
        $vereusername1 = $pm->exist("email", $_POST['username'],"FProprietario");
        $vereusername2 = $pm->exist("email", $_POST['email'],"FUtente");
        $view = new VUtente();
        if (($vereusername1) || ($vereusername2)){
            $view->registrazionePropError($error_username,"");
        }
        else {
            $proprietario = new EProprietario($view->getNome(),$view->getCognome(),$view->getEmail(),$view->getUsername(),$view->getPassword());
            if ($proprietario != null) {
                if (isset($_FILES['img_profilo'])) {
                    $nome_file = 'img_profilo';
                    $img = static::upload($proprietario,"registrazioneTrasportatore",$nome_file);
                    switch ($img) {
                        case "size":
                            $view->registrazionePropError($error_username,"size");
                            break;
                        case "type":
                            $view->registrazionePropError($error_username,"typeimg");
                            break;
                        case "ok":
                            header('Location: /FacceBeve/Utente/login');
                            break;
                    }
                }
            }
            /*
            list ($stato, $nome, $type) = CGestioneAnnuncio::upload('file');
            list ($stato_1, $nome_1, $type_1) = CGestioneAnnuncio::upload('imm_mezzo');
            if ($stato == "type")
                $view->registrazioneTrasError($error_email,$error_mezzo,"typeimg");
            elseif($stato_1 == "type")
                $view->registrazioneTrasError($error_email,$error_mezzo,"typeimgM");
            elseif ($stato == "size")
                $view->registrazioneTrasError($error_email,$error_mezzo,"size");
            elseif($stato_1 == "size")
                $view->registrazioneTrasError($error_email,$error_mezzo,"sizeM");
            elseif ($stato == "no_img" && $stato_1 == "no_img") {
                $pm->store($trasportatore);
                header('Location: /FillSpaceWEB/Utente/login');
            }
            elseif ($stato == "ok_img" && $stato_1 == "no_img") {
                $pm->store($trasportatore);
                $m_profilo = new EMediaUtente($nome, $trasportatore->getEmail());
                $m_profilo->setType($type);
                $pm->storeMedia($m_profilo,'file');
                header('Location: /FillSpaceWEB/Utente/login');
            }
            elseif ($stato == "no_img" && $stato_1 == "ok_img") {
                $pm->store($trasportatore);
                $pm->store($mezzo);
                $m_mezzo = new EMediaMezzo($nome_1, $mezzo->getPlate());
                $m_mezzo->setType($type_1);
                $pm->storeMedia($m_mezzo,'imm_mezzo');
                header('Location: /FillSpaceWEB/Utente/login');
            }
            elseif ($stato == "ok_img" && $stato_1 == "ok_img") {
                $pm->store($trasportatore);
                $pm->store($mezzo);
                $m_profilo = new EMediaUtente($nome, $trasportatore->getEmail());
                $m_profilo->setType($type);
                $m_mezzo = new EMediaMezzo($nome_1, $mezzo->getPlate());
                $m_mezzo->setType($type_1);
                $pm->storeMedia($m_profilo,'file');
                $pm->storeMedia($m_mezzo,'imm_mezzo');
                header('Location: /FillSpaceWEB/Utente/login');
            }
            */
        }
    }
}