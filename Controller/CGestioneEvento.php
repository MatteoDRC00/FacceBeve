<?php

/**
 * La classe CGestioneEvento viene utilizzata per eseguire le operazioni CRUD sugli eventi di un locale.
 * @author Gruppo 8
 * @package Controller
 */
class CGestioneEvento
{

    /**
     * @var CGestioneEvento|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CGestioneEvento $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe.
     * @return CGestioneEvento|null
     */
    public static function getInstance(): ?CGestioneEvento
    {
        if (!isset(self::$instance)) {
            self::$instance = new CGestioneEvento();
        }
        return self::$instance;
    }

//----------------------------------CREAZIONE EVENTO------------------------------------------------------\\

    /**
     * Funzione che viene richiamata per la creazione di un evento.
     * @param $id_locale
     * @throws SmartyException
     */
    public function mostraFormCreaEvento($id_locale)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        //$username = $sessione->leggi_valore("utente");
        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $view = new VGestioneEvento();
            $view->showFormCreaEvento($id_locale);
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Funzione che viene richiamata per la creazione di un evento.
     * @param $id_locale
     * @throws SmartyException
     */
    public function creaEvento($id_locale)
    {
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneEvento();
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $nomeEvento = $view->getNomeEvento();
            $descrizioneEvento = $view->getDescrizioneEvento();
            $dataEvento = $view->getDataEvento();

            $evento = new EEvento($nomeEvento, $descrizioneEvento, $dataEvento);

            $img = $view->getImgEvento();

            if (!empty($img)) {
                $img_evento = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_evento);
                $img_evento->setId($id);
                $evento->setImg($img_evento);
            }
            $id_evento = $pm->store($evento);

            $pm->storeEventiLocale($id_evento, $id_locale);

            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header("Location: /Ricerca/mostraHome");
        }


    }

    public function eliminaEvento($id_evento)
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $pm->deleteEventoLocale($id_evento);
            $pm->delete("id", $id_evento, "FEvento");
            header("Location: /Profilo/mostraProfilo");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    public function mostraFormGestioneEvento($id_evento)
    {
        $sessione = new USession();
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $view->showFormModificaEvento($id_evento);
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }
//----------------------------------CREAZIONE EVENTO------------------------------------------------------\\


//----------------------------------MODIFICA EVENTO------------------------------------------------------\\
    /**
     * @throws SmartyException
     */
    /* public function formModificaEvento(){
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
         }
         $evento = $pm->load("id",$view->getIdEvento(),"FEvento");
         $view->showFormModify(null,$evento);
     }*/

    /**
     * Funzione che gestisce la modifica del nome del Evento. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaNomeEvento($id_evento)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        $evento = $pm->load("id", $id_evento, "FEvento");
        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $nomeNuovo = $view->getNomeEvento();
            $evento->setNome($nomeNuovo);
            $pm->update("FEvento", "nome", $nomeNuovo, "id", $id_evento);
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
        }


    }

    /**
     * Funzione che gestisce la modifica del nome del Evento. Preleva la nuova descrizione dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaDescrizioneEvento($id_evento)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();

        $evento = $pm->load("id", $id_evento, "FEvento");
        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $descrizioneNuova = $view->getDescrizioneEvento();
            $pm->update("FEvento", "descrizione", $descrizioneNuova, "id", $id_evento);
            $evento->setDescrizione($descrizioneNuova);
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica della data del Evento. Preleva la nuova data dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaDataEvento($id_evento)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $evento = $pm->load("id", $id_evento, "FEvento");
            $dataNuova = $view->getDataEvento();
            $evento->setData($dataNuova);
            $pm->update("FEvento", "data", $dataNuova, "id", $id_evento);
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
        }

        $view->showFormModify(null, $evento);
    }

    /**
     * Gestisce la modifica dell'immagine del evento. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaImmagineEvento($id_evento)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        $evento = $pm->load("id", $id_evento, "FEvento");

        if ($sessione->isLogged() && $tipo = "EProprietario") {
            $img = $view->getImgEvento();
            if (!empty($img)) {
                $img_evento = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_evento);
                $img_evento->setId($id);
                $id_imgvecchia = $evento->getImg()->getId();
                $pm->delete("idImg", $id_imgvecchia, "FImmagine");
                $pm->update("FEvento", "idImg", $id, "id", $id_evento);
                $evento->setImg($img_evento);
            }
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
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
        $Y = $pm->delete("id", $view->getIdImmagine(), "FImmagine");
        $pm->deleteEsterne("FEvento", $img);
        header('Location: /Ricerca/dettaglioEvento');
    }

}