<?php

class CRecensione{
    /**
     * Funzione che viene richiamata per la scrittura di una recensione. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere recensioni
     * se l'utente è loggato e ha attivato l'account:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della ricerca;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     */
    static function scrivi(){
        if(CUtente::isLogged()){
           $view= new VRecensione();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $utente = /*unserialize*/($_SESSION['utente']);
                if (get_class($utente) == "EUtente") {
                    $view->showFormCreation($utente, null);
                } elseif (get_class($utente) == "EProprietario") {
                    $view->showFormCreation($utente, qualcosa); //Che nome dare all'errore
                }
            } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $utente = /*unserialize*/($_SESSION['utente']);
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
                     //Qui che si fa?
                }
            }
        }else{
            header('Location: /FacceBeve/Utente/login');
        }
    }

}