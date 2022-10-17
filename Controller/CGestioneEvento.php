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

    /**
     * Funzione che viene richiamata per la creazione di un evento.
     * @param $id_locale int id del locale nel quale si svolge l'evento
     * @throws SmartyException
     */
    public function mostraFormCreaEvento($id_locale)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $view = new VGestioneEvento();
            $view->showFormCreaEvento($locale[0]);
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Funzione che viene richiamata per la modifica di un evento.
     * @param $id_evento int id del evento
     *  @return void
     */
    public function mostraFormGestioneEvento(int $id_evento)
    {
        $sessione = new USession();
        $view = new VGestioneEvento();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        $evento = $pm->load("id", $id_evento, "FEvento");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $view->showFormModificaEvento($evento[0]);
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Funzione richiamata nella creazione di un evento
     * @param $id_locale int id del locale nel quale si svolge l'evento
     * @return void
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
            }else{
                $evento->setImg(null);
            }
            $id_evento = $pm->store($evento);

            $pm->storeEsterne("Locale_Eventi", "ID_Locale", "ID_Evento", $id_locale, $id_evento);

            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header("Location: /Ricerca/mostraHome");
        }

    }

    /**
     * Funzione utilizzata dal proprietario per eliminare un evento dal locale
     * @param $id_evento int id del evento
     * @return void
     */
    public function eliminaEvento(int $id_evento)
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $tipo = $sessione->leggi_valore("tipo_utente");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $pm->deleteEsterne("Locale_Eventi", "ID_Evento", $id_evento);
            $pm->delete("id", $id_evento, "FEvento");
            header("Location: /Profilo/mostraProfilo");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Funzione che gestisce la modifica del nome del Evento. Preleva il nuovo nome dalla View e procede alla modifica.
     * @param $id_evento int id del evento
     * @return void
     * @throws SmartyException
     */
    public function modificaNomeEvento(int $id_evento)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();
        $evento = $pm->load("id", $id_evento, "FEvento");
        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $nomeNuovo = $view->getNomeEvento();
            $pm->update("FEvento", "nome", $nomeNuovo, "id", $id_evento);
            $evento[0]->setNome($nomeNuovo);
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica del nome del Evento. Preleva la nuova descrizione dalla View e procede alla modifica.
     * @param $id_evento int id del evento
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
            $evento[0]->setDescrizione($descrizioneNuova);
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica della data del Evento. Preleva la nuova data dalla View e procede alla modifica.
     * @param $id_evento int id del evento
     * @return void
     * @throws SmartyException
     */
    public function modificaDataEvento(int $id_evento)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();

        $evento = $pm->load("id", $id_evento, "FEvento");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $dataNuova = $view->getDataEvento();
            $pm->update("FEvento", "data", $dataNuova, "id", $id_evento);
            $evento[0]->setData($dataNuova);
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Gestisce la modifica dell'immagine del evento. Preleva la nuova immagine dalla view e procede alla modifica.
     * @param $id_evento int id del evento
     * @return void
     * @throws SmartyException
     */
    public function modificaImmagineEvento(int $id_evento)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $view = new VGestioneEvento();
        $pm = FPersistentManager::getInstance();

        $evento = $pm->load("id", $id_evento, "FEvento");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $img = $view->getImgEvento();
            if (!empty($img)) {
                $img_evento = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_evento);
                $img_evento->setId($id);
                $id_imgvecchia = $evento[0]->getImg()->getId();
                $pm->update("FEvento", "idImg", $id, "id", $id_evento);
                $pm->delete("id", $id_imgvecchia, "FImmagine");
                $evento[0]->setImg($img_evento);
            }
            header("Location: /GestioneEvento/mostraFormGestioneEvento/" . $id_evento);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

}