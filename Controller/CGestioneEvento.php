<?php
/**
 * La classe CGestioneEvento viene utilizzata per eseguire le operazioni CRUD sugli eventi di un locale.
 * @author Gruppo 8
 * @package Controller
 */
class CGestioneEvento{

    /**
     * @var CGestioneEvento|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CGestioneEvento $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CGestioneEvento|null
     */
    public static function getInstance(): ?CGestioneEvento{
        if(!isset(self::$instance)) {
            self::$instance = new CGestioneEvento();
        }
        return self::$instance;
    }

//----------------------------------CREAZIONE EVENTO------------------------------------------------------\\

    /**
     * Funzione che viene richiamata per la creazione di un evento. Si possono avere diverse situazioni:

     * @throws SmartyException
     */


    public function mostraFormCreaEvento($id_locale){
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $username = $sessione->leggi_valore("utente");
        if($sessione->isLogged() && $tipo=="EProprietario"){
            $view = new VGestioneEvento();
            $view->showFormCreaEvento($id_locale);
        }else{
            header("Location: /Ricerca/mostraHome");
        }



    }


    public function creaEvento($id_locale){
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneEvento();
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");

        if($sessione->isLogged() && $tipo=="EProprietario"){
            $nomeEvento = $view->getNomeEvento();
            $descrizioneEvento = $view->getDescrizioneEvento();
            $dataEvento = $view->getDataEvento();

            echo $dataEvento;

            $evento = new EEvento($nomeEvento, $descrizioneEvento, $dataEvento); //Poi salvalo nel locale

            $img = $view->getImgEvento();

            if (!empty($img)) {
                $img_evento = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_evento);
                $img_evento->setId($id);
                $evento->setImg($img_evento);
            }
            $id_evento = $pm->store($evento);

            $pm->storeEventiLocale($id_evento, $id_locale);

            header("Location: /GestioneLocale/mostraGestioneLocale/".$id_locale);
        }else{
            header("Location: /Ricerca/mostraHome");
        }




    }


    public function eliminaEvento($id_evento){
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");

        if($sessione->isLogged() && $tipo=="EProprietario"){
            $pm->deleteEventoLocale($id_evento);
            $pm->delete("id", $id_evento, "FEvento");
            header("Location: /Profilo/mostraProfilo");
        }else{
            header("Location: /Ricerca/mostraHome");
        }
    }

    public function mostraFormGestioneEvento($id_evento){
        $sessione = new USession();
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");

        if($sessione->isLogged() && $tipo=="EProprietario"){
            $view->showFormModificaEvento($id_evento);
        }else{
            header("Location: /Ricerca/mostraHome");
        }
    }
//----------------------------------CREAZIONE EVENTO------------------------------------------------------\\


//----------------------------------MODIFICA EVENTO------------------------------------------------------\\
    /**
     * @throws SmartyException
     */
    public function formModificaEvento(){
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        /**if($sessione->leggi_valore('utente')){
        $proprietario = unserialize(($sessione->leggi_valore('utente')));
        if(get_class($proprietario) == "EProprietario")
        $view->showFormCreation($proprietario,null);
        else
        $view->showFormCreation($proprietario,'wrong_class');
        }else{
        $error = new VError();
        $error->error(1); //401 -> Forbidden Access
        }*/
        $evento = $pm->load("id",$view->getIdEvento(),"FEvento");
        $view->showFormModify(null,$evento);
    }

    /**
     * Funzione che gestisce la modifica del nome del Evento. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaNomeEvento(){
        $sessione = new USession();
        $view = new VGestioneEvento();

        //$utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $evento = $pm->load("id",$view->getIdEvento(),"FEvento");
        $nomeNuovo = $view->getNomeEvento();
        $evento->setNome($nomeNuovo);
        $pm->update("FEvento","nome",$nomeNuovo,"id",$evento->getId());

        $view->showFormModify(null,$evento);
    }

    /**
     * Funzione che gestisce la modifica del nome del Evento. Preleva la nuova descrizione dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaDescrizioneEvento(){
        $sessione = new USession();
        $view = new VGestioneEvento();

        //$utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $evento = $pm->load("id",$view->getIdEvento(),"FEvento");
        $descrizioneNuova = $view->getDescrizioneEvento();
        $evento->setDescrizione($descrizioneNuova);
        $pm->update("FEvento","descrizione",$descrizioneNuova,"id",$evento->getId());

        $view->showFormModify(null,$evento);
    }

    /**
     * Funzione che gestisce la modifica della data del Evento. Preleva la nuova data dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaDataEvento(){
        $sessione = new USession();
        $view = new VGestioneEvento();

        //$utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $evento = $pm->load("id",$view->getIdEvento(),"FEvento");
        $dataNuova = $view->getDataEvento();
        $evento->setData($dataNuova);
        $pm->update("FEvento","descrizione",$dataNuova,"id",$evento->getId());

        $view->showFormModify(null,$evento);
    }

    //IMG EVENTO\\

    /**
     * Gestisce la modifica dell'immagine del locale. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function addImmagineEvento()
    {
        $view = new VGestioneEvento();
        //$sessione = USession::getInstance();
        //$utente = unserialize($sessione->leggi_valore('utente'));
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id", $view->getIdEvento(), "FLocale");

        $img = $view->getImgEvento();
        list($check, $media) = static::upload($img);
        if ($check == "type") {
            $view->showFormModify( "size",$locale);
        } elseif ($check == "size") {
            $view->showFormModify( "size",$locale);
        } elseif ($check == "ok") {
            $pm = FPersistentManager::getInstance();
            $pm->storeMedia($media, $img[1]); //Salvataggio dell'immagine sul db
            $pm->storeEsterne("FEvento",$media,$view->getIdEvento()); //Salvataggio sulla tabella generata dalla relazione N:N
            header('Location: /Ricerca/dettaglioEvento');
        }
    }


    /**
     * Gestisce la modifica dell'immagine del evento. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaImmagineEvento(){
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        $sessione = new USession();
        //$utente = unserialize($sessione->leggi_valore('utente'));
        $evento = $pm->load("id", $view->getIdEvento(), "FEvento");
        $img = $view->getImgLocale();
        list($check,$media) = static::upload($img);
        if($check=="type"){
            $view->showFormModify("type",$evento);
        }elseif($check=="size"){
            $view->showFormModify("size",$evento);
        }elseif($check=="ok"){
            $pm->updateMedia($media,$img[1]);
            header('Location: /Ricerca/infoLocale'); //profilo!!!
        }
    }


    /**
     * Gestisce la cancellazione dell'immagine del evento.
     * @return void
     * @throws SmartyException
     */
    public function deleteImmagineEvento()
    {
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        $img = $pm->load("id", $view->getIdImmagine(), "FImmagine"); //Serve per l'eliminazione delle chiavi esterne
        $Y = $pm->delete("id",$view->getIdImmagine(),"FImmagine");
        $pm->deleteEsterne("FEvento",$img);
        header('Location: /Ricerca/dettaglioEvento');
    }


//----------------------------------METODI STATICI--------------------------------------------------------\\
    /**
     * Funzione che si preoccupa di verificare lo stato dell'immagine inserita
     * @param $nome_file
     * @return array , dove $ris è lo stato dell'immagine, $nome è il nome dell'immagine e $type è il MIME type dell'immagine
     */
    static function upload($img): array
    {
        //$ris = "no_img";
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