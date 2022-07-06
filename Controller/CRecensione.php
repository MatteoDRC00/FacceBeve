<?php

class CRecensione{
    /**
     * Metodo di ricerca che permette di filtrare gli annunci in base a 6 parametri (opzionali).
     * Il filtraggio Ã¨ differente in base alla categoria di utente (trasportatore/cliente).
     */
    static function ricerca(){
       // $vRicerca = new VRicerca();
        //$tipo = $vRicerca->getType();
        $nome = $vRicerca->getNome();
        $citta = $vRicerca->getLuogo();
        $genere = array();
        $genere = $vRicerca->getCategoria();
        } else
            //header('Location: /FillSpaceWEB/');
    }
}