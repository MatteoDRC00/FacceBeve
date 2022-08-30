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
    static function creaLocale(){
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
                  $indirizzo = $view->getIndirizzo();
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
                     // $orario = new EOrario($nomi[$i],$orari[$i][0],$orari[$i][1]);
                      $orario = new EOrario();
                      $orario->setGiornoSettimana($nomi[$i]);
                      $orario->setOrarioApertura($orari[$i][0]);
                      $orario->setOrarioChiusura($orari[$i][1]);
                      $Orario[] = $orario;
                  }
                  //

                  pm->store($localizzazioneLocale); //che sia giusto?
                  pm->store($Orario);
                  $Locale = new ELocale($nomeLocale,$descrizione,$numTelefono,$proprietario,$categoria,$localizzazioneLocale,null,$Orario);
                  pm->store($Locale);

              }elseif(get_class($proprietario) == "EUtente"){
                  header('Location: /FacceBeve/');
              }
          }
      }
    }


    /**
     * Funzione invocata per modificare le informazioni del locale di cui si è proprietari
     * 1) se il metodo di richiesta HTTP è POST e si è loggati come proprietario, si applicano le modifiche;
     * 2) se il metodo di richiesta HTTP è GET e non si è loggati come proprietario, avviene il reindirizzamento alla pagina del proprio profilo;
     * 3) se non si è loggati, si viene reindirizzati alla form di login.
     */
    static function modificaLocale() {
        if (CUtente::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if (get_class($utente) == "EProprietario") {
                $view = new VGestioneLocale();
                $pm = FPersistentManager::getIstance();

                $locale = $pm->load("proprietario", $utente->getUsername(), "FLocale");
                //Nome Locale
                $a = $view->getNomeLocale();
                if (($a != $locale->getNome()) && isset($a)) {
                    $locale->setNome($a);
                    $pm->update("nome", $a, "id", $locale->getId(), "FLocale");
                }
                //Descrizione Locale
                $a = $view->getDescrizione();
                if (($a != $locale->getDescrizione()) && isset($a)) {
                    $locale->setDescrizione($a);
                    $pm->update("descrizione", $a, "id", $locale->getId(), "FLocale");
                }
                //Numero di telefono Locale
                $a = $view->getNumTelefono();
                if (($a != $locale->getNumTelefono()) && isset($a)) {
                    $locale->setNumTelefono($a);
                    $pm->update("numtelefono", $a, "id", $locale->getId(), "FLocale");
                }
                //Categoria Locale
                $a = $view->getCategoria();
                if (($a != $locale->getCategoria()) && isset($a)) {
                    $pm->update("genere", $a, "genere", $locale->getCategoria()->getGenere(), "FCategoria");
                    $locale->setCategoria($a);
                }

                //LOCALIZZAZIONE
                //Indirizzo Locale
                $a = $view->getIndirizzo();
                if (($a != $locale->getLocalizzazione()->getIndirizzo()) && isset($a)) {
                    $locale->getLocalizzazione()->setIndirizzo($a);
                    $pm->update("indirizzo", $a, "id", $locale->getLocalizzazione()->getCodice(), "FLocalizzazione");
                }
                //Numero civico Locale
                $a = $view->getNumeroCivico();
                if (($a != $locale->getLocalizzazione()->getNumCivico()) && isset($a)) {
                    $locale->getLocalizzazione()->setNumCivico($a);
                    $pm->update("numCivico", $a, "id", $locale->getLocalizzazione()->getCodice(), "FLocalizzazione");
                }
                //Citta Locale
                $a = $view->getCitta();
                if (($a != $locale->getLocalizzazione()->getNumCitta()) && isset($a)) {
                    $locale->getLocalizzazione()->setCitta($a);
                    $pm->update("citta", $a, "id", $locale->getLocalizzazione()->getCodice(), "FLocalizzazione");
                }
                //$nazione = $view->getNazione();

                //CAP Locale
                $a = $view->getCAP();
                if (($a != $locale->getLocalizzazione()->getCAP()) && isset($a)) {
                    $locale->getLocalizzazione()->setCAP($a);
                    $pm->update("CAP", $a, "id", $locale->getLocalizzazione()->getCodice(), "FLocalizzazione");
                }
                //

                //ORARIO
                $Orario = $locale->getOrario();
                $tmp = $view->getOrario();
                $nomi = array_keys($tmp);
                $orari = array_values($tmp);
                for ($i = 0; $i < count($tmp); $i++) {
                    // $orario = new EOrario($nomi[$i],$orari[$i][0],$orari[$i][1]);
                    $orario = new EOrario();
                    $orario->setGiornoSettimana($nomi[$i]);
                    $orario->setOrarioApertura($orari[$i][0]);
                    $orario->setOrarioChiusura($orari[$i][1]);
                    if ($Orario[$i] != $orario) {
                        $Orario[] = $orario;
                        $pm->update("OrarioApertura", $orari[$i][0], "id", $locale->getOrario()[$i]->getId(), "FOrario");
                        $pm->update("OrarioChiusura", $orari[$i][1], "id", $locale->getOrario()[$i]->getId(), "FOrario");
                    }
                }
            } elseif (get_class($utente) == "ECliente") {
                header('Location: /Faccebeve/Utente/profile');
            }
        } else
            header('Location: /Faccebeve/Utente/login');
    }

    /**
     * Funzione utilizzata per eliminare un locale, di cui si è proprietari
     * @param $id id del locale da eliminare
     */
    static function deleteLocale($id) {
        if (CUtente::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if (get_class($utente) == "EProprietario") {
                $pm = FPersistentManager::getIstance();
                if(in_array($id,$pm->load("proprietario", $utente->getUsername(), "FLocale"))){
                    $pm->delete("id", $id, "FLocale");
                    header('Location: /FacceBeve/Utente/profile');
                }else{
                    header('Location: /FacceBeve/'); //Dove ci rimanda?
                }

            }elseif(get_class($utente) == "EUtente"){
                header('Location: /FacceBeve/Utente/profile');
            }
        }
        else
            header('Location: /FacceBeve/Utente/login');
    }


    /**
     * Funzione che si preoccupa di verificare lo stato dell'immagine inserita
     * @param $nome_file
     * @return array , dove $ris è lo stato dell'immagine, $nome è il nome dell'immagine e $type è il MIME type dell'immagine
     */
    static function upload($nome_file)
    {
        $ris = "no_img";
        $type = null;
        $nome = null;
        $max_size = 300000;
        $result = is_uploaded_file($_FILES[$nome_file]['tmp_name']);
        if (!$result) {
            $ris = "no_img";
        } else {
            $size = $_FILES[$nome_file]['size'];
            //$type = $_FILES[$nome_file]['type'];
            if ($size > $max_size) {
                $ris = "size";
            } else {
                $type = $_FILES[$nome_file]['type'];
                if ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                    $nome = $_FILES[$nome_file]['name'];
                    //$immagine = file_get_contents($_FILES[$nome_file]['tmp_name']);
                    //$immagine = addslashes($immagine);
                    $ris = "ok_img";
                } else {
                    $ris = "type";
                }
            }
        }
        return array($ris, $nome, $type);
    }

}