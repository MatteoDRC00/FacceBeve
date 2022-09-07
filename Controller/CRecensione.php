<?php

class CRecensione{
     /**
     * Funzione che viene richiamata per la scrittura di una recensione. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere recensioni.
     * se l'utente è loggato come Utente:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della recensione;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     */
    static function scrivi(){
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
           $view= new VRecensione();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $utente = $sessione->leggi_valore('utente');
                if (get_class($utente) == "EUtente") {
                    $view->showFormPost($utente, null);
                } elseif (get_class($utente) == "EProprietario") {
                    $view->showFormPost($utente, 'wrong_class'); //Proprietario prova, ma non può, a scrivere una recensione
                }
            } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $utente = $sessione->leggi_valore('utente');
                if (get_class($utente) == "EUtente") {
                    $titolo = $view->getTitolo();
                    $descrizione = $view->getDescrizione();
                    $dataScrittura = $view->getDataScrittura();
                    $voto = $view->getValutazione();
                    if(($descrizione!=null) || ($voto!=null)){
                        $nomeLocale = $view->getNomeLocale();
                        $localizzazione = $view->getLocalizzazioneLocale();
                        $pm = FPersistentManager::GetIstance();
                        $locale = $pm->loadForm($nomeLocale,$localizzazione,null);

                        $recensione = new ERecensione($utente,$titolo,$descrizione,$voto,$dataScrittura,$locale);
                        $pm->store($recensione);
                    }else{
                        $view->showFormPost($utente, 'vuoto'); //Recensione vuota, i.e., senza voto e senza un testo, solo il titolo(che può invece mancare) non basta
                    }


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
     * se l'utente è loggato come Proprietario del locale:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della recensione;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti --> errore.
     * @throws SmartyException
     */
    static function rispondi($id){
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $view= new VRecensione();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $utente = $sessione->leggi_valore('utente');
                if (get_class($utente) == "EUtente") {
                    $view->showFormPost($utente, 'wrong_class');
                } elseif (get_class($utente) == "EProprietario") {
                    $view->showFormPost($utente, null);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $utente = unserialize($sessione->leggi_valore('utente'));
                if (get_class($utente) == "EProprietario") {
                    $pm = FPersistentManager::GetIstance();
                    $descrizione = $view->getDescrizioneRisposta();
                    if(isset($descrizione)){
                        $rec = $pm->load("id",$id,"FRecensione");
                        $risposta = new ERisposta($rec,$descrizione,$utente);
                        $pm->store($risposta);
                    }else{
                        $view->showFormPost($utente, 'vuoto'); //Risposta senza testo
                    }

                }elseif(get_class($utente) == "EUtente"){
                    header('Location: /FacceBeve/');
                }
            }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }

    /**
     * Funzione richiamata quando un utente(può essere sia Proprietario che Utente) decide di cancellare la propria recensione/risposta. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere/rispondere a recensioni
     * se l'utente è loggato :
     * 1) se è un Utente che vuole cancellare la propria recensione;
     * 2) se è un Proprietario che vuole cancellare la propria risposta;
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti --> errore.
     * @throws SmartyException
     */
    static function cancella($tipo,$id){
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $view= new VRecensione();
            $utente = unserialize($sessione->leggi_valore('utente'));
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
               header('Location: /FacceBeve/'); //Qualcosa va mostrato però
           }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }

    public function segnala($i){
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $view= new VRecensione();
            $utente = unserialize($sessione->leggi_valore('utente'));
            $pm = FPersistentManager::GetIstance();
            if ((get_class($utente) == "EProprietario") || (get_class($utente) == "EUtente")) {
               $recensione = pm->load("id",$i,"FRecensione");
               if($recensione){
                   $recensione->segnala;
                   $pm->update("FRecensione","counter",$recensione->getCounter(),"id",$i);
               }else{
                   header('Location: /FacceBeve/Utente/');
               }
            }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }

}