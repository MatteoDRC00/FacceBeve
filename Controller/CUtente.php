<?php

class CUtente
{
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
            $sessione = USession::getInstance();
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
            $sessione = USession::getInstance();
            if ($sessione->leggi_valore('utente')) {
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
    }


    /**
     * DA MODIFICAREEEEEE
     * Funzione di supporto che si occupa di verificare la correttezza dell'immagine inserita nella form di registrazione.
     * Nel caso in cui non ci sono errori di inserimento, avviene la store dell'utente e la corrispondente immagine nel database.
     * @param $utente obj utente
     * @param $funz tipo di funzione da svolgere
     * @param $nome_file passato nella form pe l'immagine
     * @return string stato verifa immagine
     */
    static function upload($utente,$funz,$nome_file) {
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
                //return "size";
                $ris = "size";  // -->Errore relativo alla dimensione del img
            }
            //$type = $_FILES[$nome_file]['type'];
            elseif ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                $nome = $_FILES[$nome_file]['name'];
                $immagine = @file_get_contents($_FILES[$nome_file]['tmp_name']);
                $immagine = addslashes ($immagine);
                if ($funz == "registrazioneUtente") {
                    $pm->store($utente);
                    $mutente = new EImmagine($nome,$size,$type,$immagine);
                    $pm->storeMedia($mutente,$nome_file);
                    //return "ok";
                    $ris = "ok";
                }
                elseif ($funz == "modificaUtente") {
                    $pm->delete("id",$utente->getImgProfilo(),"FImmagine"); //A EImmagine manca l'id
                    $mutente = new EImmagine($nome,$size,$type,$immagine);
                    $pm->storeMedia($mutente,$nome_file);
                    //return "ok";
                    $ris = "ok";
                }
                elseif ($funz = "registrazioneProprietario") {
                    $pm->store($utente);
                    $mutente = new EImmagine($nome,$size,$type,$immagine);
                    $pm->storeMedia($mutente,$nome_file);
                    //return "ok";
                    $ris = "ok";
                }elseif ($funz == "modificaProprietario") {
                    $pm->delete("id",$utente->getImgProfilo(),"FImmagine"); //A EImmagine manca l'id
                    $mutente = new EImmagine($nome,$size,$type,$immagine);
                    $pm->storeMedia($mutente,$nome_file);
                    //return "ok";
                    $ris = "ok";
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
        $view = new VUtente();
        $usercheck = $view->getUsername();
        $vereusername1 = $pm->exist("username", $usercheck,"FProprietario");
        $vereusername2 = $pm->exist("username", $usercheck,"FUtente");
        if (($vereusername1) || ($vereusername2) && ($usercheck!="admin") && ($usercheck!="Admin")){
            $view->registrazionePropError($error_username,"");
        }
        else {
            $proprietario = new EProprietario($view->getNome(),$view->getCognome(),$view->getEmail(),$view->getUsername(),$view->getPassword());
            if ($view->getImgProfilo() !== null) {
                $nome_file = 'img_profilo';
                $img = static::upload($proprietario,"registrazioneProprietario",$nome_file);
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
    }
}