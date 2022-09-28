<?php
require_once "autoload.php";
require_once "utility/USession.php";

/**
 * La classe CAdmin implementa funzionalità per l'admin della piattaforma, al quale è consentito
 * bannare/attivare utenti, eliminare recensioni, bannare/ripristinare locali e cercare annunci, recensioni e utenti
 * filtrando i dati del database attraverso un campo di ricerca.
 * @author Gruppo8
 * @package Controller
 */
class CAdmin
{


    /**
     * @var CAdmin|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CAdmin $instance = null;

    /**
     * Costruttore di classe.
     */
    private function __construct()
    {

    }

    /**
     * Restituisce l'istanza della classe.
     * @return CAdmin|null
     */
    public static function getInstance(): ?CAdmin
    {
        if (!isset(self::$instance)) {
            self::$instance = new CAdmin();
        }
        return self::$instance;
    }

    /**
     * Metodo che instanzia
     * @throws SmartyException
     */
    public function dashboardAdmin()
    {
        $sessione = new USession();
        $view = new VAdmin();
        if ($sessione->isLogged() && ($sessione->leggi_valore("tipo_utente") == "EAdmin")) {
            $pm = FPersistentManager::getInstance();

            //loadUtenti --> Separo in Utenti attivi e Bannati
            $utentiAttivi = $pm->loadUtentiByState(1);
            $utentiBannati = $pm->loadUtentiByState(0);

            //loadCategorie
            $categorie = $pm->getCategorie();

            //loadRecensioni segnalate
            $recSegnalate = $pm->load("segnalato", true, "FRecensione");

            //loadProprietari
            $proprietari = $pm->loadAll("FProprietario");

            $view->HomeAdmin($utentiAttivi, $utentiBannati, $categorie, $recSegnalate, $proprietari);
        } else {
            header('Location: /Accesso/login');
        }
    }


    /**
     * Metodo utilizzato dal Admin per aggiungere categorie sul sito.
     * @throws SmartyException
     */
    public function aggiungiCategoria()
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VAdmin();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $genere = $view->getGenere();
            $descrizione = $view->getDescrizione();

            if (!$pm->exist("FCategoria", "genere", $genere)) {
                $categoria = new ECategoria($genere, $descrizione);
                $pm->store($categoria);
                header("Location: /Admin/dashboardAdmin");
            } else {
                $message = "Categoria già esistente";
                echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.replace('/Admin/dashboardAdmin');
                      </script>";
            }
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Metodo utilizzato dal Admin per cancellare categorie dal sito.
     */
    public function rimuoviCategoria($genere)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $genere = str_replace("%20", " ", $genere);
            $pm->delete("genere", $genere, "FCategoria");
            $pm->deleteLocaleCategorie($genere);
            header("Location: /Admin/dashboardAdmin");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }


    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a false).
     **/
    public function sospendiUtente($username)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->update("FUtente", "state", false, "username", $username);
            header("Location: /Admin/dashboardAdmin");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Funzione utile per cancellare un utente già bannato.
     **/
    public function riattivaUtente($username)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->update("FUtente", "state", true, "username", $username);
            header("Location: /Admin/dashboardAdmin");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    /**
     * Funzione utile per eliminare una recensione segnalata.
     * @param $id
     * @throws SmartyException
     */
    public static function eliminaRecensione($id_recensione)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->delete("id", $id_recensione, "FRecensione");
            header("Location: /Admin/dashboardAdmin");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    public static function reinserisciRecensione($id_recensione)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->update("FRecensione", "segnalato", false, "id", $id_recensione);
            header("Location: /Admin/dashboardAdmin");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }


}