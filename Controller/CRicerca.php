<?php


/**
 * La classe CRicerca implementa la funzionalità di ricerca globale su locali ed eventi.
 * @author Gruppo8
 * @package Controller
 */
class CRicerca{

    /**
     * Metodo di ricerca che permette la ricerca di locali o eventi, in base al tipo di ricerca che si vuole effettuare.
     * In base al "tipo di ricerca" si andranno a prendere tre o quattro campi da passare al metodo della classe View(VRicerca)
     */
    static function ricerca(){
        $vRicerca = new VRicerca();
        $sessione = USession::getInstance();
        if($sessione->leggi_valore('utente')){
            $tipo = $vRicerca->getTipoRicerca(); //Nella homepage un campo nella barra di ricerca deve individuare il tipo di ricerca che si vuole effettuare
        }else{
            $tipo="Locali";
        }
        if ($tipo == "Locali") {
                $nomelocale = vRicerca->getNomeLocale();
                $citta= vRicerca->getCitta();
                $categoria = vRicerca->getCategorie();
                if ($nomelocale != null || $citta != null || $categoria != null){
                    $pm = FPersistentManager::GetIstance();
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
            }
        elseif ($tipo == "Evento") {
                $nomelocale = vRicerca->getNomeLocale();
                $nomeevento= vRicerca->getNomeEvento();
                $citta= vRicerca->getCitta();
                $data= vRicerca->getDataEvento();
                if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null){
                    if(CUtente::isLogged()){
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
                    }
                }else
                    header('Location: /FacceBeve/');
        }
    }

    /**Funzione che restituisce tutte le categorie di locali presenti nel sito*/
    static function categorie(){
        $pm = FPersistentManager::GetIstance();
        $result = $pm->loadAll("FCategoria");
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
        $sessione = USession::getInstance();
        $result = $pm->load("id", $id, "FLocale");

        //Calcolo valutazione media locale + sue recensioni con le relative risposte
        $id = $result->getId();
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

        //$this->smarty->assign('recensioniLocale', $recensioni);
        if ($sessione->leggi_valore('utente')) {
            $vRicerca->dettagliLocale($result,$util,"si",$rating);
        }
        else
            $vRicerca->dettagliLocale($result,$util,"no",$rating);
    }


}