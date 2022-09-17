<?php

/**
 * La classe CGestioneLocale viene utilizzata per eseguire le operazioni CRUD sul locale con tutte le relative informazioni (orario, immagini, …).
 * @author Gruppo 8
 * @package Controller
 */
class CGestioneLocale
{
    /**
     * @var CGestioneLocale|null Variabile di classe che mantiene l'istanza della classe.
     */
    public static ?CGestioneLocale $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe.
     * @return CAccesso|null
     */
    public static function getInstance(): ?CGestioneLocale
    {
        if (!isset(self::$instance)) {
            self::$instance = new CGestioneLocale();
        }
        return self::$instance;
    }

//----------------------------------CREAZIONE DEL LOCALE------------------------------------------------------\\

    public function mostraFormCreaLocale(){
        $sessione = new USession();
        if($sessione->isLogged() && $sessione->leggi_valore("tipo_utente")=="EProprietario"){
            $view = new VGestioneLocale();
            $pm = FPersistentManager::getInstance();
            $genere_cat = $pm->getCategorie();
            $view->showFormCreaLocale($genere_cat);
        }else{
            header("Location: /Ricerca/mostraHome");
        }
    }

    public function mostraInfoLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");
        if($sessione->isLogged()){
            $view->showInfoLocale($locale);
        }

    }



    public function mostraGestioneLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){
            $genere_cat = $pm->getCategorie();
            $eventi = $pm->getEventiByLocale($locale->getId());
            $view->showFormModificaLocale($locale, $genere_cat, $eventi);
        }
    }


    /**
     * Funzione che viene richiamata per la creazione di un locale. Si possono avere diverse situazioni:
     * se l'utente non è loggato come Proprietario viene reindirizzato alla pagina di login perchè solo i Proprietari possono gestire i (propri) locali.
     * se l'utente è loggato e ha attivato l'account:
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della ricerca;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     * @throws SmartyException
     */
    public function creaLocale(){
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");

        $tipo[0] = "F";
        $class = $tipo;

        $proprietario = $pm->load("username", $username, $class);

        if($sessione->isLogged() && $tipo=="EProprietario"){

            $view = new VGestioneLocale();
            $nomeLocale = $view->getNomeLocale();
            $descrizione = $view->getDescrizioneLocale();
            $numTelefono = $view->getNumTelefono();

            $indirizzo = $view->getIndirizzo();
            $numeroCivico = $view->getNumeroCivico();
            $citta = $view->getCitta();
            $CAP = $view->getCAP();
            $localizzazioneLocale = new ELocalizzazione($indirizzo, $numeroCivico, $citta, $CAP);
            $id_Localizzazione = $pm->store($localizzazioneLocale);
            $localizzazioneLocale->setId($id_Localizzazione);

            $locale = new ELocale($nomeLocale, $descrizione, $numTelefono, $proprietario, $localizzazioneLocale);
            $id_locale = $pm->store($locale);
            $locale->setId($id_locale);

            $generi = $view->getCategorie();

            $categorie = array();

            foreach ($generi as $g){
                $pm->storeCategorieLocale($g, $id_locale);
                $categorie[] = $pm->load("genere", $g, "FCategoria");
            }
            $locale->setCategoria($categorie);

            $orario_apertura = $view->getOrarioApertura();
            $orario_chiusura = $view->getOrarioChiusura();
            $chiuso = $view->getOrarioClose();

            print_r($orario_apertura);
            print_r($orario_chiusura);


            $giorni_chiusi = array(0,0,0,0,0,0,0);

            for($i=0; $i<count($chiuso); $i++){
                $giorni_chiusi[$chiuso[$i]] = 1;
            }

            $o = array();

            for($i=0; $i<7; $i++){
                if($i == 0)
                    $giorno = "Lunedì";
                elseif ($i == 1)
                    $giorno = "Martedì";
                elseif ($i == 2)
                    $giorno = "Mercoledì";
                elseif ($i == 3)
                    $giorno = "Giovedì";
                elseif ($i == 4)
                    $giorno = "Venerdì";
                elseif ($i == 5)
                    $giorno = "Sabato";
                elseif ($i == 6)
                    $giorno = "Domenica";

                if($giorni_chiusi[$i] == 0){
                    if($orario_apertura[$i] != null && $orario_chiusura[$i] != null){
                        $orario = new EOrario($giorno, $orario_apertura[$i], $orario_chiusura[$i]);
                        $id = $pm->store($orario);
                        $orario->setId($id);
                        $o[] = $orario;
                        $pm->storeOrariLocale($id, $id_locale);
                    }else{

                        //errore
                    }
                }else{
                    $orario = new EOrario($giorno, "Chiuso", "Chiuso");
                    $id = $pm->store($orario);
                    $orario->setId($id);
                    $o[] = $orario;
                    $pm->storeOrariLocale($id, $id_locale);
                }
            }

            $locale->setOrario($o);

            $img = $view->getImgLocale();
            if(!empty($img)) {
                $img_locale = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_locale);
                $img_locale->setId($id);
                $pm->update("FLocale","idImg", $id, "id", $id_locale);
                $locale->setImg($img_locale);
            }
            header('Location: /Profilo/mostraProfilo');
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }
//----------------------------------CREAZIONE DEL LOCALE------------------------------------------------------\\


//----------------------------------MODIFICA DEL LOCALE------------------------------------------------------\\

    /**
     * Funzione che gestisce la modifica del nome del Locale. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaNomeLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();

        $locale = $pm->load("id",$id_locale,"FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){
            $nomeNuovo = $view->getNomeLocale();
            $pm->update("FLocale","nome",$nomeNuovo,"id",$id_locale);
            $locale->setNome($nomeNuovo);
            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica della descrizione del Locale. Preleva la nuova descrizione dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaDescrizioneLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id",$id_locale,"FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){
            $newDescrizione = $view->getDescrizioneLocale();
            $pm->update("FLocale","descrizione",$newDescrizione,"id",$id_locale);
            $locale->setDescrizione($newDescrizione);
            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica il numero di telefono del Locale. Preleva il nuovo numero di telefono dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaNumTelefonoLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id",$id_locale,"FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){
            $numeroTelefono = $view->getNumTelefono();
            $pm->update("FLocale","numtelefono",$numeroTelefono,"id",$id_locale);
            $locale->setNumTelefono($numeroTelefono);
            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica della categoria del locale. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaCategorieLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id",$id_locale,"FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){
            $generi = $view->getCategorie();
            for($i=0; $i<count($generi); $i++){
                $pm->deleteCategorieLocale($id_locale);
            }
            foreach($generi as $g){
                $categorie[] = $pm->load("genere",$g,"FCategoria");
                $pm->storeCategorieLocale($g, $id_locale);
            }
            $locale->setCategoria($categorie);

            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica della categoria del locale. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaLocalizzazioneLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id",$id_locale,"FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){

            $id_localizzazione = $locale->getLocalizzazione()->getId();

            $indirizzo = $view->getIndirizzo();
            $pm->update("FLocalizzazione", "indirizzo", $indirizzo, "id", $id_localizzazione);

            $numCivico = $view->getNumeroCivico();
            $pm->update("FLocalizzazione", "numCivico", $numCivico,"id", $id_localizzazione);

            $citta = $view->getCitta();
            $pm->update("FLocalizzazione", "citta", $citta, "id", $id_localizzazione);

            $cap = $view->getCAP();
            $pm->update("FLocalizzazione","CAP", $cap, "id", $id_localizzazione);

            $localizzazioneNuova = new ELocalizzazione($indirizzo, $numCivico, $citta, $cap);
            $localizzazioneNuova->setId($id_localizzazione);

            $locale->setLocalizzazione($localizzazioneNuova);
            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica dell'orario del locale. Preleva il nuovo orario dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaOrarioLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id",$id_locale,"FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){
            for($i=0; $i<7; $i++){
                $pm->deleteOrariLocale($id_locale);
            }

            $orario_apertura = $view->getOrarioApertura();
            $orario_chiusura = $view->getOrarioChiusura();
            $chiuso = $view->getOrarioClose();

            $giorni_chiusi = array(0,0,0,0,0,0,0);

            for($i=0; $i<count($chiuso); $i++){
                $giorni_chiusi[$chiuso[$i]] = 1;
            }

            $o = array();

            for($i=0; $i<7; $i++){
                if($i == 0)
                    $giorno = "Lunedì";
                elseif ($i == 1)
                    $giorno = "Martedì";
                elseif ($i == 2)
                    $giorno = "Mercoledì";
                elseif ($i == 3)
                    $giorno = "Giovedì";
                elseif ($i == 4)
                    $giorno = "Venerdì";
                elseif ($i == 5)
                    $giorno = "Sabato";
                elseif ($i == 6)
                    $giorno = "Domenica";

                if($giorni_chiusi[$i] == 0){
                    if($orario_apertura[$i] != null && $orario_chiusura[$i] != null){
                        $orario = new EOrario($giorno, $orario_apertura[$i], $orario_chiusura[$i]);
                        $id = $pm->store($orario);
                        $orario->setId($id);
                        $o[] = $orario;
                        $pm->storeOrariLocale($id, $id_locale);
                    }else{

                        //errore
                    }
                }else{
                    $orario = new EOrario($giorno, "Chiuso", "Chiuso");
                    $id = $pm->store($orario);
                    $orario->setId($id);
                    $o[] = $orario;
                    $pm->storeOrariLocale($id, $id_locale);
                }
            }
            $locale->setOrario($o);
            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }


    //IMG LOCALE\\
    /**
     * Gestisce la modifica dell'immagine del locale. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function addImmagineLocale()
    {
        $view = new VGestioneLocale();
        $sessione = USession::getInstance();
        //$utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id", $view->getIdLocale(), "FLocale");

        $img = $view->getImgLocale();
        list($check, $media) = static::upload($img);
        if ($check == "type") {
            $view->showFormModify( "size",$locale);
        } elseif ($check == "size") {
            $view->showFormModify( "size",$locale);
        } elseif ($check == "ok") {
            $pm = FPersistentManager::getInstance();
            $pm->storeMedia($media, $img[1]); //Salvataggio dell'immagine sul db
            $pm->storeEsterne("FLocale",$media,$view->getIdLocale()); //Salvataggio sulla tabella generata dalla relazione N:N
            header('Location: /Ricerca/dettaglioLocale');
        }
    }

    /**
     * Gestisce la modifica dell'immagine del locale. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaImmagineLocale($id_locale){
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id",$id_locale,"FLocale");

        if($sessione->isLogged() && $tipo == "EProprietario"){
            $img = $view->getImgLocale();
            if(!empty($img)) {
                $img_locale = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_locale);
                $img_locale->setId($id);
                $id_imgvecchia = $locale->getImg()->getId();
                $pm->delete("id", $id_imgvecchia, "FImmagine");
                $pm->update("FLocale","idImg", $id, "id", $id_locale);
                $locale->setImg($img_locale);
            }
            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header('Location: /Ricerca/mostraHome');
        }
    }


    /**
     * Gestisce la cancellazione dell'immagine del locale. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function deleteImmagineLocale()
    {
        $view = new VGestioneLocale();
        $pm = FPersistentManager::getInstance();
        $img = $pm->load("id", $view->getIdImmagine(), "FImmagine"); //Serve per l'eliminazione delle chiavi esterne
        $Y = $pm->delete("id",$view->getIdImmagine(),"FImmagine");
        $pm->deleteEsterne("FLocale",$img);
        header('Location: /Ricerca/dettaglioLocale');
    }

//----------------------------------MODIFICA DEL LOCALE------------------------------------------------------\\

//----------------------------------CANCELLAZIONE DEL LOCALE------------------------------------------------------\\
    /**
     * Funzione utilizzata per eliminare un locale, di cui si è proprietari
     * @param $id id del locale da eliminare
     */
    static function deleteLocale($id)
    {
        $sessione = new USession();
        $proprietario = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getIstance();
        $pm->delete("id", $id, "FLocale");
        header('Location: /FacceBeve/Ricerca/dettaglioLocale');
    }

    public function eliminaLocale($id_locale){
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");

        $locale = $pm->load("id", $id_locale, "FLocale");

        if($sessione->isLogged() && $tipo=="EProprietario"){
            $pm->deleteLocaleEvento($id_locale);
            $pm->deleteCategorieLocale($id_locale);
            $pm->deleteOrariLocale($id_locale);
            $pm->deleteUtenteLocale($id_locale);

            $pm->delete("id", $locale->getLocalizzazione()->getId(), "FLocalizzazione");
            $pm->delete("id", $id_locale, "FLocale");
            header("Location: /Profilo/mostraProfilo");
        }else{
            header("Location: /Ricerca/mostraHome");
        }
    }

//----------------------------------METODI STATICI------------------------------------------------------\\
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
                    $mutente = new EImmagine($nome,$size,$type,$immagine);
                } else {
                    $ris = "type";
                }
            }
        }
        return array($ris,$mutente);
    }

}