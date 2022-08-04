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
}