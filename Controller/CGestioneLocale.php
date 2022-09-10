<?php

/**
 * La classe CGestioneLocale viene utilizzata per eseguire le operazioni CRUD sul locale con tutte le relative informazioni (orario, immagini, …).
 * @author Gruppo 8
 * @package Controller
 */
class CGestioneLocale
{


//----------------------------------CREAZIONE DEL LOCALE------------------------------------------------------\\
    /**
     * @throws SmartyException
     */
    public function formCreaLocale(){
        $view = new VGestioneLocale();
        $sessione = new USession();
        if($sessione->leggi_valore('utente')){
            $proprietario = unserialize(($sessione->leggi_valore('utente')));
            if(get_class($proprietario) == "EProprietario")
                $view->showFormCreation($proprietario,null);
            else
                $view->showFormCreation($proprietario,'wrong_class');
        }else{
            $error = new VError();
            $error->error(1); //401 -> Forbidden Access
        }
    }

    /**
     * Funzione che viene richiamata per la creazione di un locale. Si possono avere diverse situazioni:
     * se l'utente non è loggato come Proprietario viene reindirizzato alla pagina di login perchè solo i Proprietari possono gestire i (propri) locali.
     * se l'utente è loggato e ha attivato l'account:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della ricerca;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     */
    public static function creaLocale()
    {
        $sessione = new USession();
        $pm = FPersistentManager::GetIstance();
        $proprietario = unserialize($sessione->leggi_valore('utente'));

        $view = new VGestioneLocale();
        $nomeLocale = $view->getNomeLocale();
        $descrizione = $view->getDescrizioneLocale();
        $numTelefono = $view->getNumTelefono();
        $categoria = $view->getCategoria();

        //LOCALIZZAZIONE
        $indirizzo = $view->getIndirizzo();
        $numeroCivico = $view->getNumeroCivico();
        $citta = $view->getCitta();
        $nazione = $view->getNazione();
        $CAP = $view->getCAP();
        $localizzazioneLocale = new ELocalizzazione($indirizzo, $numeroCivico, $citta, $nazione, $CAP);
        pm->store($localizzazioneLocale);
        //

        //ORARIO
        $Orario = array();
        $tmp = $view->getOrario();
        $nomi = array_keys($tmp);
        $orari = array_values($tmp);
        for ($i = 0; $i < count($tmp); $i++) {
            // $orario = new EOrario($nomi[$i],$orari[$i][0],$orari[$i][1]);
            $orario = new EOrario();
            $orario->setGiornoSettimana($nomi[$i]);
            $orario->setOrarioApertura($orari[$i][0]);
            $orario->setOrarioChiusura($orari[$i][1]);
            $Orario[] = $orario;
        }
        pm->store($Orario);

        $Locale = new ELocale($nomeLocale, $descrizione, $numTelefono, $proprietario, $categoria, $localizzazioneLocale, null, $Orario);
        $img = $view->getImgLocale();
        list($check, $media) = static::upload($img);
        if ($check == "type") {
            $view->showFormCreation($proprietario, "size");
        } elseif ($check == "size") {
            $view->showFormCreation($proprietario, "size");
        } elseif ($check == "ok") {
            $pm = FPersistentManager::getInstance();
            $pm->storeMedia($media, $img[1]); //Salvataggio dell'immagine sul db
            $pm->storeEsterne($media); //Salvataggio sulla tabella generata dalla relazione N:N
            header('Location: /Profilo/profilo'); //?
        }
        $id = pm->store($Locale);
        header('Location: /FacceBeve/Utente/');


    }
//----------------------------------CREAZIONE DEL LOCALE------------------------------------------------------\\


//----------------------------------MODIFICA DEL LOCALE------------------------------------------------------\\
    /**
     * @throws SmartyException
     */
    public function formModificaLocale(){
        $view = new VGestioneLocale();
        $sessione = new USession();
        if($sessione->leggi_valore('utente')){
            $proprietario = unserialize(($sessione->leggi_valore('utente')));
            if(get_class($proprietario) == "EProprietario")
                $view->showFormCreation($proprietario,null);
            else
                $view->showFormCreation($proprietario,'wrong_class');
        }else{
            $error = new VError();
            $error->error(1); //401 -> Forbidden Access
        }
    }

    /**
     * Funzione che gestisce la modifica del nome del Locale. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     */
    public function modificaNomeLocale(){
        $sessione = new USession();
        $view = new VGestioneLocale();

        $utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id",$view->getIdLocale(),"FLocale");
        $nomeNuovo = $view->getNomeLocale();
        $locale->setNome($nomeNuovo);
        $pm->update("FLocale","nome",$nomeNuovo,"id",$locale->getId());

        //$view->showFormModify();
    }

    /**
     * Funzione che gestisce la modifica della descrizione del Locale. Preleva la nuova descrizione dalla View e procede alla modifica.
     * @return void
     */
    public function modificaDescrizioneLocale(){
        $sessione = new USession();
        $view = new VGestioneLocale();

        $utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id",$view->getIdLocale(),"FLocale");
        $newDescrizione = $view->getDescrizioneLocale();
        $locale->setNome($newDescrizione);
        $pm->update("FLocale","descrizione",$newDescrizione,"id",$locale->getId());

        //$view->showFormModify();
    }

    /**
     * Funzione che gestisce la modifica il numero di telefono del Locale. Preleva il nuovo numero di telefono dalla View e procede alla modifica.
     * @return void
     */
    public function modificaNumeroLocale(){
        $sessione = new USession();
        $view = new VGestioneLocale();

        $utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id",$view->getIdLocale(),"FLocale");
        $numeroTelefono = $view->getNumTelefono();
        $locale->setNome($numeroTelefono);
        $pm->update("FLocale","numtelefono",$numeroTelefono,"id",$locale->getId());

        //$view->showFormModify();
    }

    /**
     * Funzione che gestisce la modifica della categoria del locale. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     */
    public function modificaCatLocale(){
        $sessione = new USession();
        $view = new VGestioneLocale();

        $utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id",$view->getIdLocale(),"FLocale");
        $newCat = $view->getCategoria();
        foreach($locale->getCategoria() as $cat1){
            $pm->deleteEsterne($cat1);
        }
        foreach($newCat as $cat2){
            $pm->storeEsterne($cat2);
        }
        //$view->showFormModify();
    }

    /**
     * Funzione che gestisce la modifica della categoria del locale. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     */
    public function modificaLocalizzazioneLocale(){
        $sessione = new USession();
        $view = new VGestioneLocale();

        $utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id",$view->getIdLocale(),"FLocale");
        $localizzazione = $locale->getLocalizzazione();

        $a = $view->getIndirizzo();
        $pm->update("FLocalizzazione","indirizzo",$a,"id",$localizzazione->getId());

        $b = $view->getNumeroCivico();
        $pm->update("FLocalizzazione","numCivico",$b,"id",$localizzazione->getId());

        $c = $view->getCitta();
        $pm->update("FLocalizzazione","citta",$c,"id",$localizzazione->getId());

        $d = $view->getCAP();
        $pm->update("FLocalizzazione","CAP",$d,"id",$localizzazione->getId());

        //$view->showFormModify();
    }

    /**
     * Funzione che gestisce la modifica dell'orario del locale. Preleva il nuovo orario dalla View e procede alla modifica.
     * @return void
     */
    public function modificaOrarioLocale(){
        $sessione = new USession();
        $view = new VGestioneLocale();

        //$utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id",$view->getIdLocale(),"FLocale");
        //ORARIO
        $Orario = $locale->getOrario();
        $tmp = $view->getOrario();
        $nomi = array_keys($tmp);
        $orari = array_values($tmp);
        for ($i = 0; $i < count($tmp); $i++) {
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
        //$view->showFormModify();
    }

    /**
     * Gestisce la modifica dell'immagine del locale. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function addImmagineLocale()
    {
        $view = new VGestioneLocale();
        $sessione = USession::getInstance();
        $utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id", $view->getIdLocale(), "FLocale");

        $img = $view->getImgLocale();
        list($check, $media) = static::upload($img);
        if ($check == "type") {
            $view->showFormModify($utente, "size");
        } elseif ($check == "size") {
            $view->showFormModify($utente, "size");
        } elseif ($check == "ok") {
            $pm = FPersistentManager::getInstance();
            $pm->storeMedia($media, $img[1]); //Salvataggio dell'immagine sul db
            $pm->storeEsterne($media); //Salvataggio sulla tabella generata dalla relazione N:N
            header('Location: /Profilo/profilo'); //?
        }
    }

    //Delete Immagine, va fatta?

//----------------------------------MODIFICA DEL LOCALE------------------------------------------------------\\

    /**
     * Funzione utilizzata per eliminare un locale, di cui si è proprietari
     * @param $id id del locale da eliminare
     */
    static function deleteLocale($id)
    {
        $sessione = USession::getInstance();
        if ($proprietario = unserialize($sessione->leggi_valore('utente'))) {
            $utente = unserialize($proprietario = unserialize($sessione->leggi_valore('utente')));
            if (get_class($utente) == "EProprietario") {
                $pm = FPersistentManager::getIstance();
                if (in_array($id, $pm->load("proprietario", $utente->getUsername(), "FLocale"))) {
                    $pm->delete("id", $id, "FLocale");
                    header('Location: /FacceBeve/Utente/profile');
                } else {
                    header('Location: /FacceBeve/'); //Dove ci rimanda?
                }

            } elseif (get_class($utente) == "EUtente") {
                header('Location: /FacceBeve/Utente/profile');
            }
        } else
            header('Location: /FacceBeve/Utente/login');
    }

    //Metodi Statici\\
    /**
     * Funzione che si preoccupa di verificare lo stato dell'immagine inserita
     * @param $nome_file
     * @return array , dove $ris è lo stato dell'immagine, $nome è il nome dell'immagine e $type è il MIME type dell'immagine
     */
    static function upload($img): array
    {
        //$ris = "no_img";
        $type = null;
        $nome = null;
        $max_size = 300000;
        $result = is_uploaded_file($result = is_uploaded_file($img[2])); //true se è stato caricato via HTTP POST.
        if (!$result) {
            $ris = "no_img";
        } else {
            $size = $img[3];
            $type = $img[0];
            if ($size > $max_size) {
                $ris = "size";
            } else {
                if ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                    $immagine = @file_get_contents($img[2]);
                    $immagine = addslashes ($immagine);
                    $mutente = new EImmagine($nome,$size,$type,$immagine);;
                } else {
                    $ris = "type";
                }
            }
        }
        return array($ris,$mutente);
    }

}