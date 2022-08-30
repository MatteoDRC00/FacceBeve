<?php

class CRecensione{
     /**
     * Funzione che viene richiamata per la scrittura di una recensione. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere recensioni
     * se l'utente è loggato e ha attivato l'account:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della recensione;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     */
    static function scrivi(){
        if(CUtente::isLogged()){
           $view= new VRecensione();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $utente = ($_SESSION['utente']);
                if (get_class($utente) == "EUtente") {
                    $view->showFormPost($utente, null);
                } elseif (get_class($utente) == "EProprietario") {
                    $view->showFormPost($utente, qualcosa); //Che nome dare all'errore
                }
            } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $utente = ($_SESSION['utente']);
                if (get_class($utente) == "EUtente") {
                    $titolo = $view->getTitolo();
                    $descrizione = $view->getDescrizione();
                    $dataScrittura = $view->getDataScrittura();
                    //$autore = $utente;
                    $voto = $view->getValutazione();
                    $nomeLocale = $view->getNomeLocale();
                    $localizzazione = $view->getLocalizzazioneLocale();
                    $pm = FPersistentManager::GetIstance();
                    $locale = $pm->loadForm($nomeLocale,$localizzazione,null);

                    $recensione = new ERecensione($utente,$titolo,$descrizione,$voto,$dataScrittura,$locale);
                    $pm->store($recensione);
                }elseif(get_class($utente) == "EProprietario"){
                     header('Location: /FacceBeve/');
                }
            }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione richiamata quando il proprietario di un locale risponde ad una recensione. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere recensioni
     * se l'utente è loggato e ha attivato l'account:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della recensione;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     * @throws SmartyException
     */
    static function rispondi($id){
        if(CUtente::isLogged()){
            $view= new VRecensione();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $utente = ($_SESSION['utente']);
                if (get_class($utente) == "EUtente") {
                    $view->showFormPost($utente, qualcosa);
                } elseif (get_class($utente) == "EProprietario") {
                    $view->showFormPost($utente, null);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $utente = unserialize($_SESSION['utente']);
                if (get_class($utente) == "EProprietario") {
                    $pm = FPersistentManager::GetIstance();
                    $descrizione = $view->getDescrizioneRisposta();
                    if(isset($descrizione)){
                        $rec = $pm->load("id",$id,"FRecensione");
                        $risposta = new ERisposta($rec,$descrizione,$utente);
                        $pm->store($risposta);
                    }else{
                        //Bisogna lanciare un errore
                    }

                }elseif(get_class($utente) == "EUtente"){
                    header('Location: /FacceBeve/');
                }
            }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }


    static function cancella($tipo,$id){
        if(CUtente::isLogged()){
            $view= new VRecensione();
            $utente = unserialize($_SESSION['utente']);
            $pm = FPersistentManager::GetIstance();
           if (($tipo == "recensione") && (get_class($utente) == "EUtente")) {
              $recensione = $pm->load("id",$id,"FRecensione");
              if($utente->getUsername()==$recensione->getUtente()->getUsername()){
                  $pm->delete("id",$id,"FRecensione");
              }
           }elseif(($tipo == "risposta") && (get_class($utente) == "EProprietario")){
               $risposta = $pm->load("id",$id,"FRisposta");
               if($utente->getUsername()==$risposta->getProprietario()->getUsername()){
                   $pm->delete("id",$id,"FRisposta");
               }
           }else{
               header('Location: /FacceBeve/');
           }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }
    
}