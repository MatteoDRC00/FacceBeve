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

    /**
     * Restituisce il risultato di una query
     * -Array
     * -Se non array, diventa un array ad un elemento per essere implementato nel foreach di smarty
     * -null, i.e. ==> (!isset)
    */
    public function check($result){
        $x = array();
        if(!empty($result)){
            $x = $result;
        }elseif(isset($result))
            $x[] = $result;
        return $x;
    }

    /**
     * Restituisce il risultato della query (Eventi con input da form + locale per ogni evento)
     * -Array
     * -Se non array, diventa un array ad un elemento per essere implementato nel foreach di smarty
     * -null, i.e. ==>(!isset)
     */
    public function checkDouble($result): array
    {
        $y = null;
        $x = null;
        if(is_array($result[0])){
            $x = $result[0];
            $y = $result[1];
        }
        elseif(isset($result)){
             $x[]= $result[0];
             $y[] =  $result[1];
        }
        return array ($x,$y);
    }

}