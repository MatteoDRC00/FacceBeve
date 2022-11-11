<?php

require_once 'autoload.php';
require_once("utility/USession.php");

/**
 * La classe CGestioneRecensione viene utilizzata per la scrittura(e cancellazione delle proprie) di recensioni(utente) e risposte(proprietario del locale coinvolto), include
 * la possibilità per il proprietario di segnalare recensioni(ipoteticamente volgari o non consone) all'admin.
 * @author Gruppo 8
 * @package Controller
 */
class CGestioneRecensione
{

    /**
     * @var CGestioneRecensione|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CGestioneRecensione $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct()
    {

    }

    /**
     * Restituisce l'istanza della classe.
     * @return CGestioneRecensione|null
     */
    public static function getInstance(): CGestioneRecensione
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new CGestioneRecensione();
        }
        return self::$instance;
    }

    /**
     * Funzione richiamata quando un utente scrive una recensione a un locale.
     * @param $id int id del Locale
     * @throws SmartyException
     */
    public static function scriviRecensione($id)
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $utente = $pm->load("username", $sessione->leggi_valore('utente'), "FUtente");
        $locale = $pm->load("id", $id, "FLocale");
        if (($sessione->leggi_valore('tipo_utente') == "EUtente")) {

            $view = new VGestioneRecensione();

            $value = $view->getFormRecensione();

            $titolo = $value[0];
            $valutazione = $value[1];
            $descrizione = $value[2];

            $data = (string)date("d/m/Y");

            $recensione = new ERecensione($utente, $titolo, $descrizione, $valutazione, $data, $locale[0]);

            $idR = $pm->store($recensione);

            header('Location: /FacceBeve/Ricerca/dettagliLocale/' . $id);
        } else {
            header('Location: /FacceBeve/Ricerca/mostraHome');
        }
    }

    /**
     * Funzione richiamata quando il proprietario di un locale risponde a una recensione.
     * @param $id int id della recensione alla quale si va a rispondere
     * @throws SmartyException
     */
    static function rispondi($id)
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $utente = $sessione->leggi_valore('utente');
        if (($sessione->leggi_valore('tipo_utente') == "EProprietario")) {
            $view = new VGestioneRecensione();

            $proprietario = $pm->load("username", $utente, "FProprietario");

            $descrizione = $view->getDescrizioneRisposta();

            $risposta = new ERisposta($id, $descrizione, $proprietario);

            $pm->store($risposta);

            header('Location: /FacceBeve/Ricerca/dettagliLocale/' . $view->getIdLocale());
        } else {
            header('Location: /FacceBeve/Ricerca/mostraHome');
        }
    }

    /**
     * Funzione richiamata quando un utente(può essere sia Proprietario che Utente) decide di cancellare la propria recensione/risposta. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere/rispondere a recensioni
     * se l'utente è loggato : può cancellare la recensione solo se scritta da lui
     * @param $id int id della recensione
     * @throws SmartyException
     */
    static function cancellaRecensione($id)
    {
        $sessione = new USession();
        $view = new VGestioneRecensione();
        $user = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore('tipo_utente');
        $pm = FPersistentManager::GetInstance();
        if ($tipo == "EUtente") {
            $recensione = $pm->load("id", $id, "FRecensione");
            $utente = $pm->load("username", $user, "FUtente");
            if ($utente->getUsername() == $recensione[0]->getUtente()->getUsername()) {
                $pm->delete("id", $id, "FRecensione");
                header('Location: /FacceBeve/Ricerca/dettagliLocale/' . $view->getIdLocale());
            } else {
                $sessione->cancella_valore('locale');
                header('Location: /FacceBeve/Ricerca/mostraHome');
            }
        }
    }

    /**
     * Funzione richiamata quando un utente(può essere sia Proprietario che Utente) decide di cancellare la propria recensione/risposta. Si possono avere diverse situazioni:
     * se l'utente non è loggato viene reindirizzato alla pagina di login perchè solo gli utenti registrati possono scrivere/rispondere a recensioni
     * se l'utente è loggato : può cancellare la risposta solo se scritta da lui
     * @param $id int id della risposta da cancellare
     * @throws SmartyException
     */
    public function cancellaRisposta($id)
    {
        $sessione = new USession();
        $user = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore('tipo_utente');
        $view = new VGestioneRecensione();
        $pm = FPersistentManager::GetInstance();
        if ($tipo == "EProprietario") {
            $risposta = $pm->load("id", $id, "FRisposta");
            $proprietario = $pm->load("username", $user, "FProprietario");
            if ($proprietario->getUsername() == $risposta->getProprietario()->getUsername()) {
                $pm->delete("id", $id, "FRisposta");
                header('Location: /FacceBeve/Ricerca/dettagliLocale/' . $view->getIdLocale());
            }
        } else {
            header('Location: /FacceBeve/Ricerca/mostraHome'); //Qualcosa va mostrato però
        }
    }

    /**
     * Funzione richiamata dal proprietario del locale per segnalare al admin una determinata recensione(che potrà essere poi eliminata dal sito dal admin)
     * @param $id int id della recensione da segnalare
    */
    public function segnalaRecensione($id)
    {
        $sessione = new USession();
        $view = new VGestioneRecensione();
        $user = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore('tipo_utente');
        $pm = FPersistentManager::GetInstance();
        if ($tipo == "EProprietario") {
            $pm->update("FRecensione", "segnalato", 1, "id", $id);
            header('Location: /FacceBeve/Ricerca/dettagliLocale/' . $view->getIdLocale());
        } else {
            header('Location: /FacceBeve/Ricerca/mostraHome');
        }
    }

}