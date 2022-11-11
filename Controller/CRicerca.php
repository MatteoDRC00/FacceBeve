<?php
require_once "autoload.php";
require_once "utility/USession.php";

/**
 * La classe CRicerca implementa la funzionalità di ricerca globale su locali ed eventi.
 * @author Gruppo8
 * @package Controller
 */
class CRicerca
{

    /**
     * @var CRicerca|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CRicerca $instance = null;

    /**
     * Costruttore di classe.
     */
    private function __construct()
    {

    }

    /**
     * Restituisce l'istanza della classe.
     * @return CRicerca|null
     */
    public static function getInstance(): ?CRicerca
    {
        if (!isset(self::$instance)) {
            self::$instance = new CRicerca();
        }
        return self::$instance;
    }

    /**
     * Funzione utilizzata per mostrare al utente la homepage del sito, includendo o escludente una serie d'informazioni in base al tipo di utente(se connesso o meno)
     */
    public function mostraHome()
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $eventiUtente = null;
        $localiEventiUtente = null;

        if ($sessione->isLogged()) {
            $tipo = $sessione->leggi_valore("tipo_utente");
            if ($tipo == "EAdmin") {
                header('Location: /FacceBeve/Admin/dashboardAdmin');
            }elseif ($tipo == "EUtente") {
                list ($eventiUtente, $localiEventiUtente)  = $pm->eventiUtente($sessione->leggi_valore("utente"));
            }
        } else {
            $tipo = "nouser";
        }

        $categorie = $pm->getCategorie();
        list($topLocali, $valutazione) = $pm->top4Locali();

        $view = new VRicerca();
        $view->mostraHome($tipo, $categorie, $topLocali, $valutazione,$eventiUtente, $localiEventiUtente);
    }

    /**
     * Metodo di ricerca che permette la ricerca di locali o eventi, in base al tipo di ricerca che si vuole effettuare.
     * In base al "tipo di ricerca" si andranno a prendere tre o quattro campi da passare al metodo della classe View(VRicerca)
     * @throws SmartyException
     */
    public function ricerca()
    {
        $vRicerca = new VRicerca();
        $tipo = $vRicerca->getTipoRicerca();
        $pm = FPersistentManager::getInstance();
        if ($tipo == "Locali") {
            $nomelocale = str_replace('"',"'",rtrim($vRicerca->getNomeLocale()));
            $citta = str_replace('"',"'",rtrim($vRicerca->getCitta()));
            $categoria = $vRicerca->getCategorie();
            if ($nomelocale != null || $citta != null || $categoria != null) {
                $result = $pm->loadForm($nomelocale, $citta, $categoria, "tmp", $tipo);
                $vRicerca->showResult($result, $tipo, $nomelocale, $citta, $categoria, null, null);
            } else
                header('Location: /FacceBeve/Ricerca/mostraHome');
        } elseif ($tipo == "Eventi") {
            $nomelocale = str_replace('"',"'",rtrim($vRicerca->getNomeLocaleEvento()));
            $nomeevento = str_replace('"',"'",rtrim($vRicerca->getNomeEvento()));
            $citta = str_replace('"',"'",rtrim($vRicerca->getCitta()));
            $data = $vRicerca->getDataEvento();
            if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null) {
                list($result, $local) = $pm->loadForm($nomelocale, $nomeevento, $citta, $data, $tipo);
                $vRicerca->showResult($result, $tipo, $nomelocale, $citta, $nomeevento, $data, $local);
            } else {
                header('Location: /FacceBeve/Ricerca/mostraHome');
            }
        }
    }

    /**
     * Funzione con il compito di indirizzare alla pagina specifica del locale selezionato mostrandone tutti i dettagli
     * @param $id_locale
     * @return void
     */
    public function dettagliLocale($id_locale)
    {
        $vRicerca = new VRicerca();
        $pm = FPersistentManager::getInstance();
        $sessione = new USession();
        $locale = $pm->load("id", $id_locale, "FLocale");
        $eventiOrganizzati = $locale[0]->getEventiOrganizzati();
        $proprietario = null;

        //Calcolo valutazione media locale + sue recensioni con le relative risposte
        $recensioni = $pm->load("locale", $id_locale, "FRecensione");
        $risposte = null;
        $tipo = $sessione->leggi_valore('tipo_utente');
        $username = $sessione->leggi_valore('utente');
        $presente = $pm->existEsterne("Utenti_Locali", "ID_Locale", $id_locale, "ID_Utente", $username);
        if (!empty($recensioni)) {
            //$risposte = array();
            $sum = 0;
            foreach ($recensioni as $item) {
                $idSearch = $item->getId();
                $sum += $item->getVoto();
                $risposta = $pm->load("recensione", $idSearch, "FRisposta"); //-->Ogni elemento ha la recensione e le risposte associate a tale recensione
                $risposte[] = $risposta;
            }
            if ((count($recensioni) != 0))
                $rating = $sum / (count($recensioni));
            else
                $rating = 0;
        } else {
            $recensioni = array();
            $rating = 0;
        }
        
        $rating = round($rating, 2);
        
        if ($sessione->leggi_valore('tipo_utente') == "EProprietario") {
            $check = $pm->exist("FLocale", "proprietario", $sessione->leggi_valore('utente'));
            if ($check)
                $proprietario = 1;
        }

        $utente = $pm->load("username",$username,"FUtente");
        if($utente)
            $stato = $utente->getState();
        else
            $stato = 0;

       $vRicerca->dettagliLocale($username,$stato, $tipo, $presente, $locale, $recensioni, $risposte, $rating, $proprietario, $eventiOrganizzati);
    }

    /**
     * Funzione utilizzata per l'aggiunta di un locale ai "preferiti" di un utente
     * @param $id_locale int identificativo numerico del locale
    */
    public function aggiungiAPreferiti($id_locale)
    {
        $sessione = new USession();
        $view = new VRicerca();
        $pm = FPersistentManager::getInstance();

        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");

        if ($sessione->isLogged() && $tipo == "EUtente") {
            $value = $view->getPreferito();
            if ($value == "Aggiunto!") {
                $pm->storeEsterne("Utenti_Locali", "ID_Locale", "ID_Utente", $id_locale, $username);
                header("Location: /FacceBeve/Ricerca/dettagliLocale/" . $id_locale);
            } elseif ($value == "Aggiungi ai preferiti") {
                $pm->deleteUtentiLocali($username, $id_locale);
                header("Location: /FacceBeve/Ricerca/dettagliLocale/" . $id_locale);
            }
        }
    }

}