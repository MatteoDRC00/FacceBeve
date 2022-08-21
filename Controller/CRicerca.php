<?php


/**
 * La classe CRicerca implementa la funzionalità di ricerca globale su locali ed eventi.
 * @author Gruppo8
 * @package Controller
 */
class CRicerca{

    /**
     * Metodo di ricerca che permette di ricerca su locali ed eventi.
     * Il filtraggio è differente in base alla categoria di utente (trasportatore/cliente).
     */
    static function ricerca (){
        $vRicerca = new VRicerca();
        $tipo = $vRicerca->getTipoRicerca(); // Nella homepage un campo nella barra di ricerca deve individuare il tipo di ricerca che si vuole effettuare
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

    /**Funzione che restituisce tutte le categorie di locali presenti nel sito*/
    static function categorie(){
        $pm = new FPersistentManager(); //VA CAMBIATO CON ISTANCE QUALCOSA
        $result = $pm->loadAll("FCategoria");
    }

    /**
     * Funzione con il compito di indirizzare alla pagina specifica del locale selezionato
     * @param $id id del locale selezionato


    static function dettagliLocale($id){
        $vRicerca = new VRicerca();
        $pm = new FPersistentManager(); //Istance ecc...
        $result = $pm->load("id", $id, "FLocale");
        //$img_utente = $pm->load("emailutente",$result->getEmailWriter()->getEmail(),"FMediaUtente");
        $id = $result->getIdAd();
        $tappa = null;
        $med_annuncio = $pm->load("idann","$id","FMediaAnnuncio");
        if (CUtente::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if ($result->getEmailWriter()->getEmail() == $utente->getEmail())
                $vRicerca->showDetails($result, $tipo, $nome, $cognome, $tappa,$img_utente,$med_annuncio,"no");
            else
                $vRicerca->showDetails($result, $tipo, $nome, $cognome, $tappa,$img_utente,$med_annuncio,"si");
        }
        else
            $vRicerca->showDetails($result, $tipo, $nome, $cognome, $tappa,$img_utente,$med_annuncio,"si");
    }*/


}