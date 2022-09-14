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
        }elseif ($tipo == "Evento") {
                $nomelocale = $vRicerca->getNomeLocale();
                $nomeevento= $vRicerca->getNomeEvento();
                $citta= $vRicerca->getCitta();
                $data= $vRicerca->getDataEvento();
                if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null){ //JAVASCRIPTTTTT
                        $pm = FPersistentManager::GetIstance();
                        $result = $pm->loadForm($nomelocale, $nomeevento, $citta, $data,$tipo);
                        $vRicerca->showResult($result, $tipo, $nomelocale, $citta, $nomeevento, $data);
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
                    $pm->storeEsterne($utente);
                }else{
                    //Potrebbe dare errore
                    $utente->deleteLocale($result);
                    $pm->deleteEsterne($utente);
                }
            }
        }

        //$this->smarty->assign('recensioniLocale', $recensioni);
         $vRicerca->dettagliLocale($result,$util,$rating);
    }


}