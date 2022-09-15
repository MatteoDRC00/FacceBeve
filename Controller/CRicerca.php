<?php

require_once 'autoload.php';

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
                header('Location: /Admin/dashboard');
            }
        }else{
            $tipo = "nouser";
        }

        $pm = FPersistentManager::getInstance();
        $genere_cat = $pm->getCategorie();
        $topLocali = $pm->top4Locali();

        $locali = array();

        if(!empty($topLocali)){
            foreach($topLocali as $locale){
                $locale = $pm::load("id", $locale["id"], "FLocale");
                $locali[] = $locale;
            }
        }

        $view = new VRicerca();
        $view->mostraHome($tipo, $genere_cat, $locali);
    }

    /**
     * Metodo di ricerca che permette la ricerca di locali o eventi, in base al tipo di ricerca che si vuole effettuare.
     * In base al "tipo di ricerca" si andranno a prendere tre o quattro campi da passare al metodo della classe View(VRicerca)
     * @throws SmartyException
     */
    public function ricerca(){
        $vRicerca = new VRicerca();
        $tipo = $vRicerca->getTipoRicerca();
        if ($tipo == "Locali") {
                $nomelocale = $vRicerca->getNomeLocale();
                $citta= $vRicerca->getCitta();
                $categoria = $vRicerca->getCategorie();
                if ($nomelocale != null || $citta != null || $categoria != null){
                    $pm = FPersistentManager::getInstance();
                    $result = $pm->loadForm($nomelocale, $citta,$categoria,"tmp",$tipo);
                    $vRicerca->showResult($result, $tipo,$nomelocale,$citta,$categoria,null);
                }else
                    header('Location: /Ricerca/mostraHome');
        }elseif ($tipo == "Eventi") {
                /*$nomelocale = $vRicerca->getNomeLocale();
                $nomeevento= $vRicerca->getNomeEvento();
                $citta= $vRicerca->getCitta();
                $data= $vRicerca->getDataEvento();
                if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null){
                        $pm = FPersistentManager::GetInstance();
                        $result = $pm->loadForm($nomelocale, $nomeevento, $citta, $data,$tipo);
                        $vRicerca->showResult($result, $tipo, $nomelocale, $citta, $nomeevento, $data);
                }else
                    header('Location: /Ricerca/mostraHome');  */
                print_r($_POST);
        }else{
            header('Location: /Ricerca/mostraHome');
           }
    }

    /**
     * Metodo che, a seconda dell'utente che ha cliccato, mostra la pagina del locale: <br>
     * -Se l'utente ha cliccato, nella sua area personale, il locale, questo rimanda alla pagina del locale; <br>
     * -Se è il proprietario del locale, rimanda alla pagina di gestione del locale.

    public function mostraLocale(){
        $vProfilo = new VRicerca();
        $sessione = new Session();
        if($sessione->isLogged()){
            if($sessione->leggi_valore('tipo_utente') == "EUtente"){
                $idLocale = $vProfilo->getIdLocale();

            }
        }else{
            header('Location : /Ricerca/mostraHome'); //Oppure un errore?
        }
    }*/


    /**
     * Funzione con il compito di indirizzare alla pagina specifica del locale selezionato
     * @param $id id del locale selezionato
     *
     * @throws SmartyException
     */
     static function dettagliLocale(){
        $vRicerca = new VRicerca();
        $id = $vRicerca->getIdLocale();
        $pm = FPersistentManager::GetInstance();
        $sessione = new USession();
        $result = $pm->load("id", $id, "FLocale");

        //Calcolo valutazione media locale + sue recensioni con le relative risposte
        $recensioni = $pm->load("locale",$id,"FRecensione");
        if (is_array($recensioni)) {
            $risposte = array();
            $sum = 0;
            foreach ($recensioni as $item) {
                $id = $item->getId();
                $sum += $item->getVoto();
                $risposte[] = $pm->load("recensione", $id, "FRisposta"); //-->Ogni elemento ha la recensione e le risposte associate a tale recensione
            }
            $rating=$sum/(count($recensioni));
        }else{
            $rating=$recensioni->getVoto();
            $risposte=$pm->load("recensione",$id,"FRisposta");
        }
        if($sessione->leggi_valore('utente')){
            if($sessione->leggi_valore('tipo_utente')=="EUtente"){
                $proprietario=false;
                $utente = $pm->load("id",$sessione->leggi_valore('utente'),"FUtente");
                if($vRicerca->preferiti()){
                    $utente->addLocale($result);
                    $pm->storeEsterne("FLocale",$utente,$id);
                }else{
                    //Potrebbe dare errore
                    $utente->deleteLocale($result);
                    $pm->deleteEsterne("FLocale",$utente,$id);
                }
            }elseif($sessione->leggi_valore('tipo_utente')=="EProprietario"){
                $check = $pm->exist("FLocale","proprietario",$sessione->leggi_valore('utente'));
                if($check)
                    $proprietario=true;
                else
                    $proprietario=false;
            }
        }

        //$this->smarty->assign('recensioniLocale', $recensioni);
         $vRicerca->dettagliLocale($result, $recensioni, $risposte, $rating, $proprietario);
    }


}