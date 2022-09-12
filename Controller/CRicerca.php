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
        $sessione = new USession();
        $tipo = $vRicerca->getTipoRicerca();
        /*if($sessione->isLogged()){
            $tipo = $vRicerca->getTipoRicerca(); //Nella homepage un campo nella barra di ricerca deve individuare il tipo di ricerca che si vuole effettuare
            echo $tipo;
        }else{
            $tipo="Locali";
        }*/
        if ($tipo == "Locali") {
                $nomelocale = $vRicerca->getNomeLocale();
                $citta= $vRicerca->getCitta();
                $categoria = $vRicerca->getCategorie();
                if ($nomelocale != null || $citta != null || $categoria != null){
                    $pm = FPersistentManager::getInstance();
                    $part1 = null;
                    if ($nomelocale != null) {
                        $part1 = $pm->load("name", $nomelocale, "FLocale");
                        if ($part1)
                            $part1 = $part1->getId();
                    }
                    $part2 = null;
                    if ($citta != null) {
                        $part2 = $pm->load("localizzazione", $citta, "FLocale");
                        if($part2)
                            $part2 = $part2->getId();
                    }
                    $result = $pm->loadForm($part1, $part2,$categoria,"tmp",$tipo);
                    $vRicerca->showResult($result, $tipo);
                }else
                    header('Location: /FacceBeve/');
        }elseif ($tipo == "Evento") {
                $nomelocale = $vRicerca->getNomeLocale();
                $nomeevento= $vRicerca->getNomeEvento();
                $citta= $vRicerca->getCitta();
                $data= $vRicerca->getDataEvento();
                if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null){ //JAVASCRIPTTTTT
                        $pm = FPersistentManager::GetIstance();;
                        $part1 = null; //NomeLocale
                        if ($nomelocale != null) {
                            $part1 = $pm->load("nome", $nomelocale, "FLocale");
                            if ($part1)
                                $part1 = $part1->getId();
                        }
                        $part2 = null;
                        if ($nomeevento != null) {
                            $part2 = $pm->load("nome", $nomeevento, "FEvento");
                            if($part2)
                                $part2 = $part2->getId();
                        }
                        $part3 = null;
                        if ($citta != null) {
                            $part3 = $pm->load("localizzazione", $citta, "FLocale");
                            if($part3)
                                $part3 = $part3->getId();
                        }
                        $part4 = null;
                        if ($data != null) {
                            $part4 = $pm->load("data", $data, "FEvento");
                            if($part4)
                                $part4 = $part4->getId();
                        }
                        $result = $pm->loadForm($part1, $part2, $part3, $part4,$tipo);
                        $vRicerca->showResult($result, $tipo);
                }else
                    header('Location: /FacceBeve/');
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
        $pm = FPersistentManager::GetIstance();
        $sessione = new USession();
        $result = $pm->load("id", $id, "FLocale");

        //Calcolo valutazione media locale + sue recensioni con le relative risposte
        //$id = $result->getId();
        $recensioni = $pm->load("locale",$id,"FRecensione");
        if (is_array($recensioni)) {
            $util = array();
            $sum = 0;
            foreach ($recensioni as $item) {
                $id = $item->getId();
                $sum += $item->getVoto();
                //Vettore bi-dimensionale dove le righe sono le recensioni e le colonne le risposte(o viceversa?)
                //$risposte = $pm->load("recensione",$id,"FRisposta");
                $util[$item] = $pm->load("recensione", $id, "FRisposta"); //-->Ogni elemento ha la recensione e le risposte associate a tale recensione
            }
            $rating=$sum/(count($recensioni));
        }else{
            $rating=$recensioni->getVoto();
            $util[$recensioni]=$pm->load("recensione",$id,"FRisposta");
        }
        if($sessione->leggi_valore('utente')){
            $utente = unserialize($sessione->leggi_valore('utente'));
            if(get_class($utente)=="EUtente"){
                if($vRicerca->preferiti()){
                    $utente->addLocale($result);
                    $pm->store($utente);
                }
            }
        }

        //$this->smarty->assign('recensioniLocale', $recensioni);
         $vRicerca->dettagliLocale($result,$util,$rating);
    }


}