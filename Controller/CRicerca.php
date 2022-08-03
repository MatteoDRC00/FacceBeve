<?php


/**
 * La classe CRicerca implementa la funzionalitÃ  di filtraggio degli annunci.
 * @author Gruppo8
 * @package Controller
 */
class CRicerca{

    /**
     * Metodo di ricerca che permette di filtrare gli annunci in base a 6 parametri (opzionali).
     * Il filtraggio Ã¨ differente in base alla categoria di utente (trasportatore/cliente).
     */
    static function ricerca (){
        $vRicerca = new VRicerca();
        $tipo = "Evento o Locale";
        $nome = "Franco";
        $citta= "Pescara";
        $categoria = "eheheheh";
        if ($nome != null || $citta != null || $categoria != null) {
            if ($tipo == "Locale") {
                $pm = new FPersistentManager();
                $part1 = null;
                if ($nome != null) {
                    $part1 = $pm->load("name", $nome, "FLocale");
                    if ($part1)
                        $part1 = $part1->getId();
                }
                $part2 = null;
                if ($citta != null) {
                    $part2 = $pm->load("localizzazione", $citta, "FLocale");
                    if($part2)
                        $part2 = $part2->getId();
                }
                $result = $pm->loadForm($part1, $part2,$categoria);
             //   $vRicerca->showResult($result, $tipo);
            }
            if ($tipo == "Evento") {  //Ci sono cose da cambiare, in Locale ci vanno le attivita, in Evenmto ci va la data
                if(CUtente::isLogged()){
                    $pm = new FPersistentManager();
                    $part1 = null;
                    if ($nome != null) {
                        $part1 = $pm->load("name", $nome, "FLocale");
                        if ($part1)
                            $part1 = $part1->getId();
                    }
                    $part2 = null;
                    if ($citta != null) {
                        $part2 = $pm->load("name", $citta, "FLocale");
                        if($part2)
                            $part2 = $part2->getId();
                    }
                   // $result = $pm->loadForm($part1, $part2);
                   // $vRicerca->showResult($result, $tipo);
                }
            }
        } else
            header('Location: /FillSpaceWEB/');
    }
}