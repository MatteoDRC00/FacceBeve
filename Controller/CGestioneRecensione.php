<?php

require_once 'autoload.php';
require_once("utility/USession.php");


class CGestioneRecensione
{

    private static ?CGestioneRecensione $instance = null;

    private function __construct()
    {

    }

    public static function getInstance(): CGestioneRecensione
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new CGestioneRecensione();
        }
        return self::$instance;
    }

    /**
     * Funzione richiamata quando un utente scrive una recensione a un locale.
     * @param $id id del Locale
     * @throws SmartyException
     */
    public static function scriviRecensione($id)
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $utente = $pm->load("username",$sessione->leggi_valore('utente'),"FUtente");
        $locale = $pm->load("id", $id, "FLocale");
        if (($sessione->leggi_valore('tipo_utente') == "EUtente")) {

            $view = new VGestioneRecensione();

            $value = $view->getFormRecensione();

            $titolo = $value[0];
            $valutazione = $value[1];
            if($valutazione==""){

            }
            $descrizione = $value[2];

            $data = (string)date("d/m/Y");

            $recensione = new ERecensione($utente, $titolo, $descrizione, $valutazione, $data, $locale);

            $idR = $pm->store($recensione);

            header('Location: /Ricerca/dettagliLocale/' . $id);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione richiamata quando il proprietario di un locale risponde a una recensione.
     * @param $id id della recensione alla quale si va a rispondere
     * @throws SmartyException
     */
    static function rispondi($id)
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $utente = $sessione->leggi_valore('utente');
        if (($sessione->leggi_valore('tipo_utente') == "EProprietario")) {
            $view = new VGestioneRecensione();

            $proprietario = $pm->load("username",$utente,"FProprietario");

            $descrizione = $view->getDescrizioneRisposta();

            $risposta = new ERisposta($id, $descrizione, $proprietario);

            $pm->store($risposta);

            header('Location: /Ricerca/dettagliLocale/'.$sessione->leggi_valore('locale'));
        } else {
            $sessione->cancella_valore('locale');
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione richiamata quando un utente(può essere sia Proprietario che Utente) decide di cancellare la propria recensione/risposta. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere/rispondere a recensioni
     * se l'utente è loggato :
     * @throws SmartyException
     */
    static function cancellaRecensione($id)
    {
        $sessione = new USession();
        $user = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore('tipo_utente');
        $pm = FPersistentManager::GetInstance();
        if ($tipo == "EUtente") {
            $recensione = $pm->load("id", $id, "FRecensione");
            $utente = $pm->load("username",$user,"FUtente");
            if ($utente->getUsername() == $recensione->getUtente()->getUsername()) {
                $pm->delete("id", $id, "FRecensione");
                header('Location: /Ricerca/dettagliLocale/'.$sessione->leggi_valore('locale'));
            } else {
                $sessione->cancella_valore('locale');
                header('Location: /Ricerca/mostraHome');
            }
        }
    }

    /**
     * Funzione richiamata quando un utente(può essere sia Proprietario che Utente) decide di cancellare la propria recensione/risposta. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere/rispondere a recensioni
     * se l'utente è loggato :
     * @throws SmartyException
     */
    public function cancellaRisposta($id)
    {
        $sessione = new USession();
        $user = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore('tipo_utente');
        $pm = FPersistentManager::GetInstance();
        if ($tipo == "EProprietario") {
            $risposta = $pm->load("id", $id, "FRisposta");
            $proprietario = $pm->load("username",$user,"FProprietario");
            if ($proprietario->getUsername() == $risposta->getProprietario()->getUsername()) {
                $pm->delete("id", $id, "FRisposta");
                header('Location: /Ricerca/dettagliLocale/'.$sessione->leggi_valore('locale'));
            }
        } else {
            $sessione->cancella_valore('locale');
            header('Location: /Ricerca/mostraHome'); //Qualcosa va mostrato però
        }
    }

    public function segnala($i)
    {
        $sessione = USession::getInstance();
        if ($sessione->leggi_valore('utente')) {
            $view = new VGestioneRecensione();
            $utente = unserialize($sessione->leggi_valore('utente'));
            $pm = FPersistentManager::GetIstance();
            if ((get_class($utente) == "EProprietario") || (get_class($utente) == "EUtente")) {
                $recensione = $pm->load("id", $i, "FRecensione");
                if ($recensione) {
                    $recensione->segnala;
                    $pm->update("FRecensione", "counter", $recensione->getCounter(), "id", $i);
                } else {
                    header('Location: /FacceBeve/Utente/');
                }
            }
        } else {
            header('Location: /FacceBeve/Utente/login');
        }
    }

    public function mostraRecensioni()
    {
        $sessione = new USession();
        $locale = $sessione->leggi_valore('locale');

        $l = unserialize($locale);
        $id = $l["id"];

        $pm = FPersistentManager::getInstance();
        $recensioni_locale = $pm->loadRecensioniByLocale($id);

        $view = new VGestioneRecensione();
        $view->mostraRecensioniLocale();

    }

}