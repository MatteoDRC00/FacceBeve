<?php

/**
 * La classe CGestioneLocale viene utilizzata per la creazione del locale con tutte le relative informazioni (orario, immagini, …).
 * @author Gruppo 8
 * @package Controller
 */

class CGestioneLocale{

    /**
     * Funzione che viene richiamata per la creazione di un locale. Si possono avere diverse situazioni:
     * se l'utente non è loggato come Proprietario viene reindirizzato alla pagina di login perchè solo i Proprietari possono gestire i (propri) locali.
     * se l'utente è loggato e ha attivato l'account:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della ricerca;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     */
    static function crea(){
      if(CUtente::isLogged()){
          if ($_SERVER['REQUEST_METHOD'] == "GET") {
              $view = new VGestioneAnnunci();
              $proprietario = unserialize($_SESSION['utente']);
              if (get_class(proprietario) == "EProprietario") {
                  $view->showFormCreation($proprietario,null);
              }elseif (get_class($proprietario) == "EUtente") {
                  $view->showFormCreation($proprietario,"errore da definire");
              }
          } elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
              $pm = FPersistentManager::GetIstance();
              $proprietario = unserialize($_SESSION['utente']);
              if (get_class(proprietario) == "EProprietario") {
                  $view = new VGestioneLocale();
                  $nomeLocale = $view->getNomeLocale();
                  $descrizione = $view->getDescrizione();
                  $numTelefono = $view->getNumTelefono();
                  $categoria = $view->getCategoria();

                  //LOCALIZZAZIONE
                  $indirizzo = $view->getNumeroCivico();
                  $numeroCivico = $view->getNumeroCivico();
                  $citta = $view->getCitta();
                  $nazione = $view->getNazione();
                  $CAP = $view->getCAP();
                  $localizzazioneLocale = new ELocalizzazione($indirizzo,$numeroCivico,$citta,$nazione,$CAP);
                  //
                  //ORARIO
                  $Orario = array();
                  $tmp = $view->getOrario();
                  $nomi = array_keys($tmp);
                  $orari = array_values($tmp);
                  for($i=0;$i<count($tmp);$i++){
                      $orario = new EOrario($nomi[$i],$orari[$i][0],$orari[$i][1]);
                      $Orario[] = $orario;
                  }
                  //
                  pm->store($localizzazioneLocale); //che sia giusto?
                  pm->store($Orario);
                  $Locale = new ELocale($nomeLocale,$descrizione,$numTelefono,$proprietario,$categoria,$localizzazioneLocale,null,$Orario);
                  pm->store($Locale);

              }elseif(get_class($proprietario) == "EUtente"){
                  //Qui che si fa?
              }
          }




      }

    }

}