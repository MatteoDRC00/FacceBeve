<?php
require_once "autoload.php";
require_once "utility/USession.php";

/**
 * La classe CAdmin implementa funzionalità per l'admin della piattaforma, al quale è consentito:
 * * bannare/attivare utenti;
 * * eliminare/ripristinare recensioni segnalate;
 * * cercare recensioni e utenti.
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
     * Metodo che mostra la dashboard di controllo del admin.
     * @throws SmartyException
     */
    public function dashboardAdmin()
    {
        $sessione = new USession();
        $view = new VAdmin();
        if ($sessione->isLogged() && ($sessione->leggi_valore("tipo_utente") == "EAdmin")) {
            $pm = FPersistentManager::getInstance();

            //loadUtenti --> Separo in Utenti attivi e Bannati
            $utentiAttivi = $pm->load("state", 1, "FUtente");
            $utentiA = array();
            if(!is_array($utentiAttivi) && $utentiAttivi != null){
                $utentiA[0] = $utentiAttivi;
            }else if(!empty($utentiAttivi)){
                $utentiA = $utentiAttivi;
            }

            $utentiBannati = $pm->load("state", 0, "FUtente");
            $utentiB = array();
            if(!is_array($utentiBannati) && $utentiBannati != null){
                $utentiB[0] = $utentiBannati;
            }else if(!empty($utentiBannati)){
                $utentiB = $utentiBannati;
            }
            //loadCategorie
            $categorie = $pm->getCategorie();

            //loadRecensioni segnalate
            $recSegnalate = $pm->load("segnalato", true, "FRecensione");

            //loadProprietari
            $proprietari = $pm->loadAll("FProprietario");
            $locali = $pm->loadAll("FLocale");

            $view->HomeAdmin($utentiA, $utentiB, $categorie, $recSegnalate, $proprietari, $locali);
        } else {
            header('Location: /FacceBeve/Accesso/login');
        }
    }


    /**
     * Metodo utilizzato dal Admin per aggiungere categorie sul sito.
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
                header("Location: /FacceBeve/Admin/dashboardAdmin");
            } else {
                $message = "Categoria già esistente";
                echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.replace('/FacceBeve/Admin/dashboardAdmin');
                      </script>";
            }
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

    /**
     * Metodo utilizzato dal Admin per cancellare categorie dal sito.
     * @param $genere string categoria identificata dal proprio nome
     */
    public function rimuoviCategoria(string $genere)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $genere = str_replace("%20", " ", $genere);
            $pm->delete("genere", $genere, "FCategoria");
            $pm->deleteEsterne("Locale_Categorie", "ID_Categoria", $genere);
            header("Location: /FacceBeve/Admin/dashboardAdmin");
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }


    /**
     * Funzione utile per cambiare lo stato di visibilità di un utente (nel caso specifico porta la visibilità a false).
     * @param $username string Username dell'utente da bannare sul sito, impedendoli di scrivere ulteriori recensioni.
     **/
    public function sospendiUtente(string $username)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->update("FUtente", "state", 0, "username", $username);
            header("Location: /FacceBeve/Admin/dashboardAdmin");
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

    /**
     * Funzione utile per cancellare un utente già bannato.
     * @param $username string username identificativo univoco del utente
     **/
    public function riattivaUtente(string $username)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->update("FUtente", "state", 1, "username", $username);
            header("Location: /FacceBeve/Admin/dashboardAdmin");
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

    /**
     * Funzione utile per eliminare una recensione segnalata.
     * @param $id_recensione int identificativo della recensione
     */
    public static function eliminaRecensione(int $id_recensione)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->delete("id", $id_recensione, "FRecensione");
            header("Location: /Admin/dashboardAdmin");
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

    /**
     * Funzione utile per togliere il segnalato a una recensione segnalata.
     * @param $id_recensione int identificativo della recensione
     */
    public static function reinserisciRecensione(int $id_recensione)
    {
        $sessione = new USession();
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EAdmin") {
            $pm->update("FRecensione", "segnalato", false, "id", $id_recensione);
            header("Location: /FacceBeve/Admin/dashboardAdmin");
        } else {
            header("Location: /FacceBeve/Ricerca/mostraHome");
        }
    }

}