<?php
require_once "autoload.php";
require_once "utility/USession.php";
require_once "utility/UCheck.php";

/**
 * La classe CRicerca implementa la funzionalità di ricerca globale su locali ed eventi.
 * @author Gruppo8
 * @package Controller
 */
class CRicerca{

    /**
     * @var CRicerca|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CRicerca $instance = null;

    /**
     * Costruttore di classe.
     */
    private function __construct(){

    }

    /**
     * Restituisce l'istanza della classe.
     * @return CRicerca|null
     */
    public static function getInstance(): ?CRicerca {
        if(!isset(self::$instance)) {
            self::$instance = new CRicerca();
        }
        return self::$instance;
    }

    public function mostraHome(){
        $sessione = new USession();

        if($sessione->isLogged()){
            $tipo = $sessione->leggi_valore("tipo_utente");
            if($tipo == "EAdmin"){
                header('Location: /Admin/dashboardAdmin');
            }
        }else{
            $tipo = "nouser";
        }

        $pm = FPersistentManager::getInstance();
        $genere_cat = $pm->getCategorie();
        $topLocali = $pm->top4Locali();

        $locali = array();
        $valutazione = array();

        if(!empty($topLocali)){
            foreach($topLocali as $locale){
                $valutazione[] = $locale["ValutazioneMedia"];
                $locale = $pm->load("id", $locale["id"], "FLocale");
                $locali[] = $locale;
            }
        }

        $view = new VRicerca();
        $view->mostraHome($tipo, $genere_cat, $locali, $valutazione);
    }

    /**
     * Metodo di ricerca che permette la ricerca di locali o eventi, in base al tipo di ricerca che si vuole effettuare.
     * In base al "tipo di ricerca" si andranno a prendere tre o quattro campi da passare al metodo della classe View(VRicerca)
     * @throws SmartyException
     */
    public function ricerca(){
        $vRicerca = new VRicerca();
        $tipo = $vRicerca->getTipoRicerca();
        $pm = FPersistentManager::getInstance();
        $check = UCheck::getInstance();
        if ($tipo == "Locali") {
                $nomelocale = $vRicerca->getNomeLocale();
                $citta= $vRicerca->getCitta();
                $categoria = $vRicerca->getCategorie();
                if ($nomelocale != null || $citta != null || $categoria != null){
                    $result = $check->check($pm->loadForm($nomelocale, $citta,$categoria,"tmp",$tipo));
                    $vRicerca->showResult($result, $tipo,$nomelocale,$citta,$categoria,null,null);
                }else
                    header('Location: /Ricerca/mostraHome');
        }elseif ($tipo == "Eventi") {
                $nomelocale = $vRicerca->getNomeLocale();
                $nomeevento= $vRicerca->getNomeEvento();
                $citta= $vRicerca->getCitta();
                $data= $vRicerca->getDataEvento();
                if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null){
                        $pm = FPersistentManager::GetInstance();
                        list($result[],$local[]) = $pm->loadForm($nomelocale, $nomeevento, $citta, $data,$tipo);
                        $vRicerca->showResult($result, $tipo, $nomelocale, $citta, $nomeevento, $data,$local);
                }else
                    header('Location: /Ricerca/mostraHome');
        }else{
            header('Location: /Ricerca/mostraHome');
           }
    }


    /**
     * Funzione con il compito di indirizzare alla pagina specifica del locale selezionato
     * @param $id id del locale selezionato
     *
     * @throws SmartyException
     */
     static function dettagliLocale($id){
        $vRicerca = new VRicerca();
        $pm = FPersistentManager::GetInstance();
        $sessione = new USession();
        $sessione->cancella_valore('locale');
        $sessione->imposta_valore('locale',$id);
        $result = $pm->load("id", $id, "FLocale");
        $proprietario=null;
        $check = UCheck::getInstance();

        //Calcolo valutazione media locale + sue recensioni con le relative risposte
         $recensioni = $check->check($pm->load("locale",$id,"FRecensione"));
         $tipo = $sessione->leggi_valore('tipo_utente');
         $username = $sessione->leggi_valore('utente');
         $presente = $pm->existEsterna("utenti_locali", "ID_Locale", $id, "ID_Utente", $username);

        if (is_array($recensioni)) {
            $risposte = array();
            $sum = 0;
            foreach ($recensioni as $item) {
                $idSearch = $item->getId();
                $sum += $item->getVoto();
                $risposte[] = $pm->load("recensione", $idSearch, "FRisposta"); //-->Ogni elemento ha la recensione e le risposte associate a tale recensione
            }
            $rating=$sum/(count($recensioni));
        }else{
            $idSearch = $recensioni->getId();
            $rating=$recensioni->getVoto();
            $risposte[]=$pm->load("recensione",$idSearch,"FRisposta");
        }
        if($sessione->leggi_valore('utente')){
             if($sessione->leggi_valore('tipo_utente')=="EProprietario"){
                $check = $pm->exist("FLocale","proprietario",$sessione->leggi_valore('utente'));
                if($check)
                    $proprietario=1;
             }
        }
        $vRicerca->dettagliLocale($tipo,$presente,$result, $recensioni, $risposte, $rating,$proprietario);
    }


    public function aggiungiAPreferiti($id_locale){
         $sessione = new USession();
         $view = new VRicerca();
         $pm = FPersistentManager::getInstance();

         $username = $sessione->leggi_valore("utente");
         $tipo = $sessione->leggi_valore("tipo_utente");

         if($sessione->isLogged() && $tipo == "EUtente"){
             $value = $view->getPreferito();
             if($value == "Aggiunto!"){
                 $pm->storeUtentiLocali($username, $id_locale);
                 header("Location: /Profilo/mostraProfilo");
             }elseif ($value == "Aggiungi ai preferiti"){
                 $pm->deleteUtentiLocali($username, $id_locale);
                 header("Location: /Profilo/mostraProfilo");
             }
         }

    }


}