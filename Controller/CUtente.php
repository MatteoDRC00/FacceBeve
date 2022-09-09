<?php

class CUtente
{


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