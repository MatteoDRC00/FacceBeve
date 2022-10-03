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

    public function mostraHome()
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $eventiUtente = null;
        $localiEventiUtente = null;

        if ($sessione->isLogged()) {
            $tipo = $sessione->leggi_valore("tipo_utente");
            if ($tipo == "EAdmin") {
                header('Location: /Admin/dashboardAdmin');
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
            $nomelocale = $vRicerca->getNomeLocale();
            $citta = $vRicerca->getCitta();
            $categoria = $vRicerca->getCategorie();
            if ($nomelocale != null || $citta != null || $categoria != null) {
                $result = $pm->loadForm($nomelocale, $citta, $categoria, "tmp", $tipo);
                $vRicerca->showResult($result, $tipo, $nomelocale, $citta, $categoria, null, null);
            } else
                header('Location: /Ricerca/mostraHome');
        } elseif ($tipo == "Eventi") {
            $nomelocale = $vRicerca->getNomeLocaleEvento();
            $nomeevento = $vRicerca->getNomeEvento();
            $citta = $vRicerca->getCitta();
            $data = $vRicerca->getDataEvento();
            if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null) {
                $pm = FPersistentManager::GetInstance();
                list($result, $local) = $pm->loadForm($nomelocale, $nomeevento, $citta, $data, $tipo);
                $vRicerca->showResult($result, $tipo, $nomelocale, $citta, $nomeevento, $data, $local);
            } else
                header('Location: /Ricerca/mostraHome');
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }


    /**
     * Funzione con il compito di indirizzare alla pagina specifica del locale selezionato
     * @param $id id del locale selezionato
     *
     * @throws SmartyException
     */
    static function dettagliLocale($id)
    {
        $vRicerca = new VRicerca();
        $pm = FPersistentManager::GetInstance();
        $sessione = new USession();
        $result = $pm->load("id", $id, "FLocale");
        $eventiOrganizzati = $result[0]->getEventiOrganizzati();
        $proprietario = null;

        if ($sessione->isLogged())
            $logged = "loggato";
        else
            $logged = "nouser";

        //Calcolo valutazione media locale + sue recensioni con le relative risposte
        $recensioni = $pm->load("locale", $id, "FRecensione");
        $risposte = null;
        $tipo = $sessione->leggi_valore('tipo_utente');
        $username = $sessione->leggi_valore('utente');
        $presente = $pm->existEsterna("utenti_locali", "ID_Locale", $id, "ID_Utente", $username);
        if (!empty($recensioni)) {
            //$risposte = array();
            $sum = 0;
            foreach ($recensioni as $item) {
                $idSearch = $item->getId();
                $sum += $item->getVoto();
                $risposta = $pm->load("recensione", $idSearch, "FRisposta"); //-->Ogni elemento ha la recensione e le risposte associate a tale recensione
                $risposte[] = $risposta;
            }
            if((count($recensioni)!=0))
               $rating = $sum / (count($recensioni));
            else
                $rating = 0;
        }else{
            $recensioni= array();
            $rating = 0;
        }
        if ($sessione->leggi_valore('tipo_utente') == "EProprietario") {
            $check = $pm->exist("FLocale", "proprietario", $sessione->leggi_valore('utente'));
            if ($check)
                $proprietario = 1;
        }

       $vRicerca->dettagliLocale($tipo, $presente, $result, $recensioni, $risposte, $rating, $proprietario, $logged, $eventiOrganizzati);
    }


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
                $pm->storeUtentiLocali($username, $id_locale);
                header("Location: /Profilo/mostraProfilo");
            } elseif ($value == "Aggiungi ai preferiti") {
                $pm->deleteUtentiLocali($username, $id_locale);
                header("Location: /Profilo/mostraProfilo");
            }
        }
    }


}