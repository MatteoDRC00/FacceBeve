<?php


/**
 * La classe CRicerca implementa la funzionalitÃ  di ricerca globale su locali ed eventi.
 * @author Gruppo8
 * @package Controller
 */
class CRicerca{

    /**
     * Metodo di ricerca che permette di ricerca  su locali ed eventi.
     * Il filtraggio Ã¨ differente in base alla categoria di utente (trasportatore/cliente).
     */
    static function ricerca (){
        $vRicerca = new VRicerca();
        //$tipo = $vRicerca->getType(); --> Nella homepage un campo nella barra di ricerca deve individuare il tipo di ricerca che si vuole effettuare
        $tipo = "Locale";
            if ($tipo == "Locale") {
                $nomelocale = "Franco";
                $citta= "Pescara";
                $categoria = "eheheheh";
                if ($nomelocale != null || $citta != null || $categoria != null){
                    $pm = new FPersistentManager();
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
                    //   $vRicerca->showResult($result, $tipo);
                }else
                    header('Location: /FacceBeve/');
            }
            if ($tipo == "Evento") {
                $nomelocale = "Franco";
                $nomeevento="yeye";
                $citta= "Pescara";
                $data="ieri oggi domani";
                if ($nomelocale != null || $nomeevento != null || $citta != null || $data != null){
                    if(CUtente::isLogged()){
                        $pm = new FPersistentManager();
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
                        // $vRicerca->showResult($result, $tipo);
                    }
                }else
                    header('Location: /FacceBeve/');
            }
    }

    /**
     * Funzione con il compito di indirizzare alla pagina pagina specifica del locale selezionato
     * @param $id id dell'annuncio selezionato

    static function dettagliLocale($id){
        $tipo = null;
        $vRicerca = new VRicerca();
        $pm = new FPersistentManager();
        $result = $pm->load("idAd", $id, "FAnnuncio");
        $data_p = $result->getDepartureDate();
        if ($data_p == "0000-00-00")
            $tipo = "carichi";
        else
            $tipo = "trasporti";
        $nome = $result->getEmailWriter()->getName();
        $img_utente = $pm->load("emailutente",$result->getEmailWriter()->getEmail(),"FMediaUtente");
        $cognome = $result->getEmailWriter()->getSurname();
        $id = $result->getIdAd();
        $tappa = null;
        $med_annuncio = $pm->load("idann","$id","FMediaAnnuncio");
        if ($tipo == "trasporti") {
            $indici = $pm->load("ad", $id , "FTappa");
            if (is_array($indici)) {
                if (is_array(current($indici))) {
                    $tappa = array();
                    for ($i = 0; $i < count($indici); $i++) {
                        $tappa[$i] = $pm->load("id", $indici[$i]['place'], "FLuogo");
                    }
                }
                else
                    $tappa = $pm->load("id", $indici['place'], "FLuogo");
            }
        }
        if (CUtente::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if ($result->getEmailWriter()->getEmail() == $utente->getEmail())
                $vRicerca->showDetails($result, $tipo, $nome, $cognome, $tappa,$img_utente,$med_annuncio,"no");
            else
                $vRicerca->showDetails($result, $tipo, $nome, $cognome, $tappa,$img_utente,$med_annuncio,"si");
        }
        else
            $vRicerca->showDetails($result, $tipo, $nome, $cognome, $tappa,$img_utente,$med_annuncio,"si");
    }
    */

}