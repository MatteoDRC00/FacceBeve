<?php

/**
 * Classe utilizzata per trasmettere risultati di query alle View
 *
 */

class UCheck
{

    private static UCheck $_instance;

    /**
     * Costruttore di classe.
     */
    private function __construct(){

    }

    /**Restituisce l'unica istanza della della classe*/
    public static function getInstance(): UCheck{
        if ( !isset(self::$_instance) ) {
            self::$_instance = new UCheck();
        }
        return self::$_instance;
    }

    public function check($result){
        if(is_array($result))
            $x = $result;
        elseif(isset($result))
            $x[] = $result;
        else
            $x = null;
        return $x;
    }

}