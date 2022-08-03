<?php

class FEvento {

    /** classe foundation */
    private static $class="FEvento";
    /** tabella con la quale opera */
    private static $table="Evento";
    /** valori della tabella */
    private static $values="(:nome,:descrizione,:data)";

    public function __construct(){

    }

    public static function bind($stmt, EEvento $evento){
        $stmt->bindValue(':nome', $evento->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $evento->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':data', $evento->getData(), PDO::PARAM_STR);
    }

    public static function getClass(){
        return self::$class;
    }

    public static function getTable(){
        return self::$table;
    }

    public static function getValues(){
        return self::$values;
    }

    public static function store(EEvento $evento){
        $db=FDB::getInstance();
        $db->store(self::getClass(), $evento);
    }


}