<?php

class FAdmin{
    /**
     * La classe foundation
     * @var string $class
     */
    private static $class="FAdmin";

    /**
     * Tabella nel database
     * @var string $table
     */
    private static $table="Admin";

    /**
     * Attributi della tabella
     * @var string $values
     */
    private static $values="(:username,:email,:password)";

    /**
     * Costruttore
     */
    public function __construct(){}

    /**
     * Questo metodo lega gli attributi dell'Admin da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAdmin $admin
     */
    public static function bind($stmt, EAdmin $admin){
        $stmt->bindValue(':username', $admin->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $admin->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $admin->getPassword(), PDO::PARAM_STR);
    }


    /**
     * Questo metodo restituisce il nome della classe per la costruzione delle Query
     * @return string $class Nome della classe
     */
    public static function getClass(){
        return self::$class;
    }

    /**
     * Questo metodo restituisce il nome della tabella per la costruzione delle Query
     * @return string $table Nome della tabella
     */
    public static function getTable(){
        return self::$table;
    }

    /**
     * Questo metodo restituisce l'insieme dei valori per la costruzione delle Query
     * @return string $values Nomi delle colonne della tabella
     */
    public static function getValues(){
        return self::$values;
    }


    public static function store(EAdmin $admin){
        $db=FDB::getInstance();
        $db->store(self::getClass(),$admin);
    }

}